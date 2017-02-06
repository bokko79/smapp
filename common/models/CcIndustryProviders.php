<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_industry_providers".
 *
 * @property integer $id
 * @property integer $provider_id
 * @property integer $property_id
 * @property string $value_default
 * @property integer $value_min
 * @property string $value_max
 * @property string $step
 * @property string $pattern
 * @property integer $display_order
 * @property integer $multiple_values
 * @property integer $read_only
 * @property integer $required
 *
 * @property CcIndustries $industry
 * @property CcProviders $property
 */
class CcIndustryProviders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_industry_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['industry_id', 'provider_id'], 'required'],
            [['industry_id', 'provider_id', 'type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'industry_id' => Yii::t('app', 'Industry'),
            'provider_id' => Yii::t('app', 'Provider'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry()
    {
        return $this->hasOne(CcIndustries::className(), ['id' => 'industry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(CcProviders::className(), ['id' => 'provider_id']);
    }
}
