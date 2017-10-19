<?php

use amintado\pay\classes\Atpayfunctions;
use amintado\pay\models\SettingsPayForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$paymodel = new SettingsPayForm();
$moduleID = '';

foreach (Yii::$app->modules as $key => $value) {
    if (!empty($value['class'])) {
        if ($value['class'] == 'amintado\pay\Module') {
            $moduleID = $key;
            break;
        }
    }

}
//---------------- init Module -------------------
$module = (new amintado\pay\Module($moduleID))->init();
$payform = ActiveForm::begin(
    [
        'id' => 'paymentSettingsForm',
        'action' => ["/$moduleID/manage/settings/index"]
    ]
)
?>
    <div class="row">
        <div class="jumbotron">
            <div class="container">
                <h2><?= Yii::t('atpay', 'payment settings') ?> </h2>
                <p><?= Yii::t('atpay', 'here you can edit payment module settings') ?> </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    <?php
                                    $initialPreview = [];
                                    //<check is logo file exist or not>
                                    {
                                        $file = Atpayfunctions::Option('logofileName');
                                        if (!empty($file)) {
                                            if (empty(Yii::$app->modules[$moduleID]->UploadFolderURL)) {
                                                $baseurl = 'http://' . $_SERVER['SERVER_NAME'] . '/frontend/uploads/atpayupload/' . $file;
                                                $initialPreview[] = $baseurl;
                                            } else {
                                                $initialPreview[] = Yii::$app->modules[$moduleID]->UploadFolderURL . $file;
                                            }
                                        }
                                    }

                                    //</check is logo file exist or not>

                                    ?>
                                    <?= $payform->field($paymodel, 'factor_logo')->widget(FileInput::className(),
                                        [
                                            'options' => ['accept' => 'image/*'],
                                            'pluginOptions' => [
                                                'showPreview' => false,
                                                'showCaption' => true,
                                                'showRemove' => true,
                                                'showUpload' => false,
                                                'initialPreview' => $initialPreview,
                                                'initialPreviewAsData' => true,
                                                'initialPreviewConfig' => [
                                                    ['caption' => 'icon.jpg', 'size' => '873727'],
                                                ],
                                                'overwriteInitial' => false,
                                                'previewFileType' => 'image',
                                                'showPreview' => true,
                                            ]
                                        ]
                                    ) ?></label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $payform->field($paymodel, 'address')->input('text', ['aria-describedby' => 'helpId', 'placeholder' => Atpayfunctions::Option('address')]) ?>
                                <small id="helpId"
                                       class="text-muted"><?= Yii::t('atpay', 'This address is included in invoices and invoice receipts') ?> </small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $payform->field($paymodel, 'telephone')->input('text', ['aria-describedby' => 'helpId', 'placeholder' => Atpayfunctions::Option('telephone')]) ?>
                                <small id="helpId"
                                       class="text-muted"><?= Yii::t('atpay', 'This telephone is included in invoices and invoice receipts') ?> </small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $payform->field($paymodel, 'payIR_API')->input('text', ['aria-describedby' => 'helpId', 'placeholder' => Atpayfunctions::Option('payIR_API')]) ?>
                                <small id="helpId"
                                       class="text-muted"><?= Yii::t('atpay', 'Private key for pay.ir payment') ?> </small>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= Html::submitButton(Yii::t('atpay', 'submit settings'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>