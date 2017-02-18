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
            [['name'], 'string', 'max' => 64],
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
        $action_translation = Translations::find()->where('lang_code="SR" and entity="action" and entity_id='.$this->id)->one();
        if($action_translation) {
            return $action_translation;
        }
        return false;      
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTName()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameGen()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gen;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameDat()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_dat;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameAkk()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_akk;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameInst()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_inst;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamePl()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_pl;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamePlGen()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_pl_gen;
        }       
        return $this->name;   
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gender;
        }       
        return 'n';   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->description;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubtext()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->subtext;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHint()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->hint;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->title;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubtitle()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->subtitle;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNote()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->note;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddNote()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->additional_note;
        }       
        return $this->name;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSCaseName()
    {
        return c($this->tName); 
    }
}
