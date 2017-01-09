<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_units".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $sign
 * @property string $sign_htmlfree
 * @property integer $conversion_unit
 * @property string $conversion_value
 * @property string $measurement
 */
class CcUnits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'sign', 'sign_htmlfree', 'conversion_unit'], 'required'],
            [['conversion_unit'], 'integer'],
            [['conversion_value'], 'number'],
            [['measurement'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 30],
            [['sign'], 'string', 'max' => 25],
            [['sign_htmlfree'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'sign' => 'Sign',
            'sign_htmlfree' => 'Sign Htmlfree',
            'conversion_unit' => 'Conversion Unit',
            'conversion_value' => 'Conversion Value',
            'measurement' => 'Measurement',
        ];
    }
}
