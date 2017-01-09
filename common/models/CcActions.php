<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_actions".
 *
 * @property integer $id
 * @property string $name
 * @property integer $object_mode
 * @property string $status
 *
 * @property CcActionsTranslation[] $ccActionsTranslations
 * @property CcMethods[] $ccMethods
 * @property CcServices[] $ccServices
 */
class CcActions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['object_mode'], 'integer'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Akcija usluge.',
            'object_mode' => 'Parametar koji označava da li akcija sadrži više usluga. 0 - Akcija ima samo jednu  uslugu; 1 - Akcija ima više od jedne usluge.',
            'status' => 'Status aktivnosti.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasMany(CcActionsTranslation::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionProperties()
    {
        return $this->hasMany(CcActionProperties::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(CcServices::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustries()
    {
        // uraditi da lista sve delatnosti u kojima se pojavljuje akcija
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        /*$action_translation = CcActionsTranslation::find()->where('lang_code="SR" and action_id='.$this->id)->one();
        if($action_translation) {
            return $action_translation;
        }
        return false; */       
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTName()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameGen()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gen;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameDat()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_dat;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameAkk()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_akk;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameInst()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_inst;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTGender()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gender;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSCaseName()
    {
        return c($this->tName); 
    }
}
