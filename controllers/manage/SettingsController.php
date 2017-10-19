<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/18/2017
 * Time: 8:53 AM
 */

namespace amintado\pay\controllers\manage;


use amintado\pay\models\Settings;
use amintado\pay\models\SettingsPayForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use amintado\pay\classes\Atpayfunctions;
class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' =>
                [
                    'class' => VerbFilter::className(),
                    'actions' => []
                ],
            'access' =>
                [
                    'class' => AccessControl::className(),
                    'rules' =>
                        [
                            [
                                'allow' => true,
                                'actions' => ['index'],
                                'roles' => ['@']
                            ],
                            [
                                'allow' => false
                            ]
                        ]

                ]
        ];
    }

    public $UploadDirectory='/atpayupload/';



    public function actionIndex()
    {
        if (!empty(Yii::$app->request->post())) {
            $model = new SettingsPayForm();
            $model->load(Yii::$app->request->post());

            foreach ($model->attributes() as $attributeIndex => $attribute) {
                switch ($attribute) {
                    case 'factor_logo':
                        $upload = UploadedFile::getInstance($model, 'factor_logo');
                        //<check file uploaded>
                        {
                            if (!empty($upload)){
                                //<check old logo is exist or Not>
                                {
                                    $oldFile=Atpayfunctions::Option('logofileName');
                                    if (!empty($oldFile)){
                                        unlink(realpath(Yii::getAlias(Yii::$app->controller->module->uploadFolder.'/'.$oldFile)));
                                    }
                                }
                                //</check old logo is exist or Not>

                                //<save new logo>
                                {
                                    $targetFolder=realpath(Yii::getAlias(Yii::$app->controller->module->uploadFolder));
                                    //<Check upload folder is exist or not>
                                    {

                                        if (empty($targetFolder)){
                                            mkdir(Yii::getAlias(Yii::$app->controller->module->uploadFolder),0777,true);
                                        }
                                    }
                                    //</Check upload folder is exist or not>
                                    $upload->saveAs
                                    (
                                        Yii::getAlias(Yii::$app->controller->module->uploadFolder.$upload->name)
                                    );
                                    Atpayfunctions::Option('logofileName',($upload->name));
                                }
                                //</save new logo>

                            }
                        }
                        //</check file uploaded>
                    break;
                    default :

                        Atpayfunctions::Option($attribute, $model->$attribute);
                        break;
                }
            }

        }
        if (!empty($_SERVER["HTTP_REFERER"])){
            return $this->redirect($_SERVER["HTTP_REFERER"]);
        }else{
            return $this->redirect(['/']);
        }
    }
}