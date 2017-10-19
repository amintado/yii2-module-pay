<?php
/*******************************************************************************
 * Copyright (c) 2017.
 * this file created in printing-office project
 * framework: Yii2
 * license: GPL V3 2017 - 2025
 * Author:amintado@gmail.com
 * Company:shahrmap.ir
 * Official GitHub Page: https://github.com/amintado/printing-office
 * All rights reserved.
 ******************************************************************************/

namespace amintado\pay\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "{{%taban_invoice}}".
 *
 * @property integer $id
 * @property string $date
 * @property integer $uid
 * @property integer $status
 * @property string $price
 * @property string $discount
 * @property string $tax
 * @property string $paymentmethod
 * @property string $paydate
 * @property string $description
 * @property string $title
 * @property string $paycode
 * @property string $UUID
 * @property string $lock
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @property string $restored_by
 */
class Invoice extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    const STATUS_PAID=1;
    const STATUS_NOT_PAID=2;


    const PAYMENT_METHOD_ONLINE_PAYIR='PayIR';//online payment with cvv2



    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            ''
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'price', 'paymentmethod'], 'required'],
            [['id', 'uid', 'status', 'lock', 'created_by', 'updated_by', 'deleted_by', 'restored_by'], 'integer'],
            [['date', 'paydate', 'created_at', 'updated_at'], 'safe'],
            [['price', 'discount', 'tax'], 'number'],
            [['paymentmethod', 'description', 'title', 'paycode'], 'string', 'max' => 255],
            [['UUID'], 'string', 'max' => 32],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'date' => Yii::t('common', 'Date'),
            'uid' => Yii::t('common', 'Uid'),
            'status' => Yii::t('common', 'Status'),
            'price' => Yii::t('common', 'Price'),
            'discount' => Yii::t('common', 'Discount'),
            'tax' => Yii::t('common', 'Tax'),
            'paymentmethod' => Yii::t('common', 'Paymentmethod'),
            'paydate' => Yii::t('common', 'Paydate'),
            'description' => Yii::t('common', 'Description'),
            'title' => Yii::t('common', 'Title'),
            'paycode' => Yii::t('common', 'Paycode'),
            'UUID' => Yii::t('common', 'Uuid'),
            'lock' => Yii::t('common', 'Lock'),
            'restored_by' => Yii::t('common', 'Restored By'),
        ];
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }


}
