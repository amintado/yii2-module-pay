<?php

use amintado\pay\classes\Atpayfunctions;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model amintado\pay\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('atpay', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view" style="direction: rtl">

    <div class="row">
        <div class="col-sm-9">
            <?php
            //<check is logo file exist or not>
            {
                $file = Atpayfunctions::Option('logofileName');
                if (!empty($file)) {
                    if (empty(Yii::$app->controller->module->UploadFolderURL)) {
                        $baseurl = 'http://' . $_SERVER['SERVER_NAME'] . '/frontend/uploads/atpayupload/' . $file;
                        $logo = $baseurl;
                    } else {
                        $logo = Yii::$app->controller->module->UploadFolderURL . $file;
                    }
                }
            }
            //</check is logo file exist or not>

            ?>
            <img src="<?= $logo ?>" style="height: 70px;position: relative;float: right;" alt="Image">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h3 style="font-family:'Samim'">
                <?= Yii::t('atpay', 'Transaction receipt') ?>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 text-right">
            <?= Yii::t('atpay', 'Date:') ?>
            <?= (new amintado\base\AmintadoFunctions())->convertdatetime($model->date) ?>
        </div>
        <div class="col-xs-4 text-right" style="float: right !important;">
            <?= Yii::t('atpay', 'Invoice called:') . User::findOne(['id' =>
                empty($uid)?
                Yii::$app->user->id:$uid

            ])->fullname ?>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-xs-4 text-right">
            <?= Yii::t('atpay', 'Transaction Number:') ?>
            <?= $model->id ?>
        </div>
        <div class="col-xs-4 text-right" style="float: right !important;">
            <?= Yii::t('atpay', 'username:') . User::findOne(['id' =>
                empty($uid)?
                    Yii::$app->user->id:$uid
            ])->username ?>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <?= Atpayfunctions::Option('address') ?>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <?= Yii::t('atpay', 'telephone:') ?>
            <?= Atpayfunctions::Option('telephone') ?>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <?= Yii::t('atpay', 'One transaction:') ?>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
       <div class="col-md-12">
           <table class="table table-{1:striped|sm|bordered|hover|inverse} table-bordered">

               <thead class="thead-inverse|thead-default">
               <tr>
                   <th style="width: 30%" class="text-right"><?= Yii::t('atpay', 'Date') ?></th>
                   <th style="width: 50%" class="text-right"><?= Yii::t('atpay', 'Description') ?></th>
                   <th style="width: 20%" class="text-center"><?= Yii::t('atpay', 'amount(rial)') ?> </th>
               </tr>
               </thead>
               <tbody>
               <tr>
                   <td scope="row"><?= (new amintado\base\AmintadoFunctions())->convertdatetime($model->date) ?> </td>
                   <td><?= $model->description ?></td>
                   <td class="text-center"><?= number_format(intval($model->price), 0, ',', ','); ?> </td>
               </tr>
               <tr>
                   <td scope="row" colspan="2" class="text-right"><?= Yii::t('atpay', 'sum') ?></td>
                   <td class="text-center"><?= number_format(intval($model->price), 0, ',', ','); ?> </td>
               </tr>
               </tbody>
           </table>
       </div>
    </div>
</div>
