<?php

use amintado\pay\assets\PayAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
$asset=PayAsset::register($this);
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>


    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-body">

                    <h3 style="text-align: right">روش های پرداخت</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="name" id="inputID" value=""" checked="checked">
                                    Pay.ir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">

                            <img src="<?= $asset->baseUrl.'/image/payir.png' ?> " class="img-responsive" alt="pay.ir" style="height: 58px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder' => 'Price']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover pay-info-list">

                        <tbody>
                        <tr>
                            <td>واحد پول</td>
                            <td class="text-left">IRR</td>
                        </tr>
                        <tr>
                            <td>مبلغ واریزی</td>
                            <td class="text-left">10.000</td>
                        </tr>
                        <tr>
                            <td>هزینه ی واریز</td>
                            <td class="text-left">0</td>
                        </tr>
                        <tr class="active">
                            <td>مجموع</td>
                            <td class="text-left">10.000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>




    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('atpay', 'Create') : Yii::t('atpay', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->controller->action->id != 'create'): ?>
            <?= Html::submitButton(Yii::t('atpay', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
