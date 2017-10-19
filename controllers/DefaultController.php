<?php

namespace amintado\pay\controllers;

use amintado\base\AmintadoFunctions;
use amintado\pay\classes\Atpayfunctions;
use amintado\pay\classes\PayIR;
use amintado\pay\models\Invoice;
use BadMethodCallException;
use common\models\base\UserInfo;
use common\models\User;
use Yii;
use amintado\pay\models\Transaction;
use amintado\pay\models\TransactionSearch;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Transaction model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'verify' => ['post']
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'pdf', 'save-as-new', 'verify'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex($uid=null)
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->searchMy(Yii::$app->request->queryParams);
        if (empty($url)){
            $user=UserInfo::findOne(['uid'=>Yii::$app->user->id]);
        }else{
            $user=UserInfo::findOne(['uid'=>$uid]);
            if (empty($user)){
                throw new BadRequestHttpException(Yii::t('atpay', 'this user not exist'));
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user'=>$user
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();
        Yii::$app->assetManager->forceCopy = true;
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->price)) {
                $price = intval($model->price);
                $pay = new PayIR();
                $moduleID = Yii::$app->controller->module->id;

                $redirectUrl = urlencode(Yii::$app->urlManager->createAbsoluteUrl(["$moduleID/default/verify"]));

                $result = $pay->send(Atpayfunctions::Option('payIR_API'), $price, $redirectUrl);
            }
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }


    public function actionVerify()
    {

        $post = Yii::$app->request->post();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'api=' . Atpayfunctions::Option('payIR_API') . '&transId=' . $post['transId']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = Json::decode($res);
        switch ($res['status']) {
            case 0:
                throw new BadRequestHttpException($res['errorMessage']);
                break;
            case 1:
                $amount = $res['amount'];
        }
        {
            //---------------- Create Invoice -------------------
            $invoice = new Invoice();
            $invoice->date = date('Y-m-d H:i:s');
            $invoice->uid = Yii::$app->user->id;
            $invoice->status = Invoice::STATUS_PAID;
            $invoice->price = (int)$amount;
            $invoice->discount = 0;
            $invoice->tax = 0;
            $invoice->paymentmethod = Invoice::PAYMENT_METHOD_ONLINE_PAYIR;
            $invoice->paydate = date('Y-m-d H:i:s');
            $invoice->description = Yii::t('atpay', 'Deposit {amount} Rials online from card {cardnumber} in {date}', ['amount' => $amount, 'cardnumber' => $post['cardNumber'], 'date' => ((new AmintadoFunctions())->convertdate(date('ymd')))]);
            $invoice->title = Yii::t('atpay', 'Deposit Online');
            $invoice->paycode = $post['transId'];
            if (!$invoice->validate() or !$invoice->save()) {
                throw new BadMethodCallException(Yii::t('atpay', 'Invoice Not Saved'));
            }

        }

        {
            //---------------- Save Transaction -------------------
            $transaction = new Transaction();
            $transaction->uid = Yii::$app->user->id;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->price = $invoice->price;
            $transaction->description = $invoice->description;
            $transaction->invoice = $invoice->id;
            if (!$transaction->validate() or !$transaction->save()) {
                throw new BadMethodCallException(Yii::t('atpay', 'Transaction Not Saved'));
            }
        }

        {
            //---------------- Add Amount To User Profile -------------------

            $user = UserInfo::findOne(['uid' => Yii::$app->user->id]);
            $user->balance = (string)(intval($user->balance) + intval($transaction->price));
            if (!$user->validate() or !$user->save()) {
                throw new BadMethodCallException(Yii::t('atpay', 'User Info Not Saved'));
            }

        }

        {
            //---------------- update inventory in transaction table -------------------
            $transaction->inventory = intval($user->balance);
            $transaction->save();
        }
        unset($invoice);
        unset($user);
        unset($transaction);
        $moduleID = Yii::$app->controller->module->id;

        return $this->redirect(["/$moduleID"]);
    }


    /**
     *
     * Export Transaction information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id, $uid=null)
    {
        $model = $this->findModel($id);

        $content = $this->renderPartial('_pdf', [
            'model' => $model,
            'uid'=>$uid
        ]);



        return (new Atpayfunctions())->RenderPDF($content);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('atpay', 'The requested page does not exist.'));
        }
    }
}
