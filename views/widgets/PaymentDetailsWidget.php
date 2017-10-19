<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/19/2017
 * Time: 9:18 AM
 */
/**
 * @var $sumAmounts
 * @var $CountZeroUsers
 * @var $allUsers
 * @var $rationZeroUsersToAll
 */
?>

<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('atpay', 'Total inventory of users') ?> </span>
                <span class="info-box-number"><?= $sumAmounts ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('atpay', 'Number of users with inventory 0') ?> </span>
                <span class="info-box-number"><?= $CountZeroUsers ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-4">

        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-percent"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('atpay', 'Percentage of users without inventory to the total') ?></span>
                <span class="info-box-number"><?= $rationZeroUsersToAll ?>%</span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?= $rationZeroUsersToAll ?>%"></div>
                </div>
                <span class="progress-description">
                   <?= Yii::t('atpay', '{percent} of users do not have inventory',['percent'=>$rationZeroUsersToAll.'%']) ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
</div>
<div class="row">

</div>




