<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */

$this->title = Yii::t('atpay', 'Increase in inventory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('atpay', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
