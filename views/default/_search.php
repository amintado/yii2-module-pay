<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model amintado\pay\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'uid')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => Yii::t('atpay', 'Choose Taban users')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('atpay', 'Choose Date'),
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder' => 'Price']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?php /* echo $form->field($model, 'invoice')->textInput(['placeholder' => 'Invoice']) */ ?>

    <?php /* echo $form->field($model, 'UUID')->textInput(['maxlength' => true, 'placeholder' => 'UUID']) */ ?>

    <?php /* echo $form->field($model, 'lock', ['template' => '{input}'])->textInput(['style' => 'display:none']); */ ?>

    <?php /* echo $form->field($model, 'restored_by')->textInput(['maxlength' => true, 'placeholder' => 'Restored By']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('atpay', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('atpay', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
