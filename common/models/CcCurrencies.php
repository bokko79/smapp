<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_currencies".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $state_id
 * @property string $rate
 */
class CcCurrencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'rate'], 'required'],
            [['state_id'], 'integer'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 30],
            [['code'], 'string', 'max' => 3],
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
            'code' => 'Code',
            'state_id' => 'State ID',
            'rate' => 'Rate',
        ];
    }
}
