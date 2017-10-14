<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */

$this->title = Yii::t('atpay', 'Save As New {modelClass}: ', [
    'modelClass' => 'Transaction',
]). ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('atpay', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('atpay', 'Save As New');
?>
<div class="transaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
