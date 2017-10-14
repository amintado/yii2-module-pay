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
 * This is the base model class for table "{{%transaction}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $date
 * @property string $price
 * @property string $description
 * @property integer $invoice
 * @property string $UUID
 * @property string $lock
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @property string $restored_by
 *
 * @property \common\models\User $u
 */
class Transaction extends \yii\db\ActiveRecord
{
    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'restored_by' => \Yii::$app->user->id,
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'restored_by' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'u'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'invoice', 'lock', 'created_by', 'updated_by', 'deleted_by', 'restored_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
            [['description'], 'string', 'max' => 255],
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
        return '{{%transaction}}';
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
            'id' => Yii::t('atpay', 'ID'),
            'uid' => Yii::t('atpay', 'Uid'),
            'date' => Yii::t('atpay', 'Date'),
            'price' => Yii::t('atpay', 'Pay Price'),
            'description' => Yii::t('atpay', 'Description'),
            'invoice' => Yii::t('atpay', 'Invoice'),
            'UUID' => Yii::t('atpay', 'Uuid'),
            'lock' => Yii::t('atpay', 'Lock'),
            'restored_by' => Yii::t('atpay', 'Restored By'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'uid']);
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
