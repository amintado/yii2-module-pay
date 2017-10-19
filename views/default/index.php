<?php

/* @var $this yii\web\View */
/* @var $searchModel amintado\pay\models\TransactionSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use amintado\base\AmintadoFunctions;
use amintado\pay\models\Transaction;
use common\models\base\UserInfo;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('atpay', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="transaction-index">
    <p>
    <h4>
        <?= Yii::t('atpay', 'Current inventory') . ':' ?>
        <?=
        number_format
        (
            intval
            (
                $user->balance
            )
            , 0
            , ','
            , ','
        ),
            ' ' . Yii::t('atpay', 'RIAL');
        ?>
    </h4>

    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('atpay', 'Increase in inventory'), ['create'], ['class' => 'btn btn-success']) ?>

    </p>
    <div class="search-form" style="display:none">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'date',
            'value' => function ($model) {
                /**
                 * @var $model Transaction
                 */
                if (Yii::$app->language == 'fa-IR') {
                    return (new AmintadoFunctions())->convertdatetime($model->date);
                }
            },
            'filter' => false,
            'pageSummary'=> Yii::t('atpay', 'sum')
        ],

        [
            'attribute' => 'price',
            'value' => function ($model) {
                /**
                 * @var $model Transaction
                 */
                $price=intval($model->price);
                if ($price<0){
                    $out = '';
                    $out .= number_format($price, 0, ',', ',');
                    $out .= ' ' . Yii::t('atpay', 'RIAL');
                    return
                        '<div style="color:red">'.
                        $out.
                        '</div>';
                }else{
                    return ' ';
                }

            },
            'filter' => false,
            'format'=>'html',
            'label'=> Yii::t('atpay', 'Removal')
        ],

        [
            'attribute' => 'price',
            'value' => function ($model) {
                /**
                 * @var $model Transaction
                 */
                $price=intval($model->price);
                if ($price>0){
                    $out = '';
                    $out .= number_format($price, 0, ',', ',');
                    $out .= ' ' . Yii::t('atpay', 'RIAL');
                    return
                        '<div style="color:green">'.
                        $out.
                        '</div>';
                }else{
                    return ' ';
                }

            },
            'filter' => false,
            'format'=>'html',
            'label'=> Yii::t('atpay', 'Deposits')
        ],
        [
            'attribute'=>'inventory',
            'value'=>function($model){
                /**
                 * @var $model Transaction
                 */
                $price=intval($model->inventory);
                $out = '';
                $out .= number_format($price, 0, ',', ',');
                $out .= ' ' . Yii::t('atpay', 'RIAL');
                return $out;
            }
        ],
        [
            'attribute' => 'description',
            'filter'=>false
        ],
        ['attribute' => 'lock', 'visible' => false],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{pdf}',
            'buttons' =>
            [
                    'pdf'=>function($url, $model, $id){
                        $moduleID = '';

                        foreach (Yii::$app->modules as $key => $value) {
                            if (is_object($value)){
                                if (!empty($value->class)){
                                    if ($value->class == 'amintado\pay\Module') {

                                        $moduleID = $key;
                                        break;
                                    }
                                }

                            }else{
                                if (!empty($value['class'])) {
                                    if ($value['class'] == 'amintado\pay\Module') {

                                        $moduleID = $key;
                                        break;
                                    }
                                }
                            }


                        }
                        if (!empty($moduleID)){
                            if (Yii::$app->user->id==$model->uid){
                                $url=Yii::$app->urlManager->createAbsoluteUrl(["/$moduleID/default/pdf",'id'=>$id]);
                            }else{
                                $url=Yii::$app->urlManager->createAbsoluteUrl(["/$moduleID/default/pdf",'id'=>$id,'uid'=>$model->uid]);

                            }
                        }


                        return '<a href="' . $url . '" title="'. Yii::t('atpay', 'transaction PDF').'" aria-label="'. Yii::t('atpay', 'transaction PDF').'" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    }
            ]

        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transaction']],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '',
            'filter'=>false
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => Yii::t('atpay', 'Full'),
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">' . Yii::t('atpay', 'Export All Data') . '</li>',
                    ],
                ],
            ]),
        ],
    ]); ?>

</div>
