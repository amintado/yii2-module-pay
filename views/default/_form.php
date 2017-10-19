<?php

use amintado\pay\assets\PayAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

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

                            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder' => Yii::t('atpay', 'Deposits'),'rel'=>'amount','value'=>10000,'type'=>'number'])->label(Yii::t('atpay', 'Deposits')) ?>
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
                            <td class="text-left" id="pay-price">10.000</td>
                        </tr>
                        <tr>
                            <td>هزینه ی واریز</td>
                            <td class="text-left" id="cost">0</td>
                        </tr>
                        <tr class="active">
                            <td>مجموع</td>
                            <td class="text-left" id="sum">10.000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>




    <div class="form-group">

            <?= Html::submitButton( Yii::t('atpay', 'Pay') , ['class' =>  'btn btn-success']) ?>

        <?= Html::a(Yii::t('atpay', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
