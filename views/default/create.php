<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */

$this->title = Yii::t('atpay', 'Create Transaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('atpay', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
