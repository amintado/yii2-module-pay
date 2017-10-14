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
        <div class="col-sm-8">
            <h2><?= Yii::t('atpay', 'Transaction').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
<?=             
             Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('atpay', 'PDF'), 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('atpay', 'Will open the generated PDF file in a new window')
                ]
            )?>
            <?= Html::a(Yii::t('atpay', 'Save As New'), ['save-as-new', 'id' => $model->id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a(Yii::t('atpay', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('atpay', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('atpay', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'u.username',
            'label' => Yii::t('atpay', 'Uid'),
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
    <div class="row">
        <h4>Users<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUsers = [
        ['attribute' => 'id', 'visible' => false],
        'username',
        'hash_id',
        'fullname',
        'RoleID',
        'Image',
        'auth_key',
        'access_token',
        'password_hash',
        'password_reset_token',
        'email',
        'status',
        'IsPrivate',
        'LastLoginIP',
        'imei',
        'UUID',
        ['attribute' => 'lock', 'visible' => false],
        'mode',
        'VerificationCode',
    ];
    echo DetailView::widget([
        'model' => $model->u,
        'attributes' => $gridColumnUsers    ]);
    ?>
</div>
