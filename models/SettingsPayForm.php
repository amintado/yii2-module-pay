<?php

namespace amintado\pay\models;

use Yii;
use yii\base\Model;

/**
 * This is the base model class for table "{{%pay_settings}}".
 *
 * @property string $factor_logo
 */
class SettingsPayForm extends Model
{

    public $factor_logo,$telephone,$address,$payIR_API;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factor_logo','address','telephone','payIR_API'],'string','max'=>500]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'factor_logo' => Yii::t('atpay', 'factor logo'),
            'address' => Yii::t('atpay', 'address'),
            'telephone' => Yii::t('atpay', 'telephone'),
            'payIR_API' => Yii::t('atpay', 'payIR_API'),
        ];
    }
}
