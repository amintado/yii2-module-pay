<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('atpay', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('atpay', 'Transaction').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'u.username',
                'label' => Yii::t('atpay', 'Uid')
            ],
        'date',
        'price',
        'description',
        'invoice',
        'UUID',
        ['attribute' => 'lock', 'visible' => false],
        'restored_by',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
