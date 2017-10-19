<?php

namespace amintado\pay\models;

use Yii;

/**
 * This is the base model class for table "{{%pay_settings}}".
 *
 * @property integer $setting_id
 * @property string $setting_key
 * @property string $setting_value
 */
class Settings extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_key', 'setting_value'], 'required'],
            [['setting_value'], 'string'],
            [['setting_key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pay_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => Yii::t('atpay', 'Setting ID'),
            'setting_key' => Yii::t('atpay', 'Setting Key'),
            'setting_value' => Yii::t('atpay', 'Setting Value'),
        ];
    }
}
