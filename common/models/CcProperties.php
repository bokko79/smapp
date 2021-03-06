<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_properties".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $property_id
 * @property integer $specific_values
 * @property integer $translatable_values
 * @property string $class
 * @property string $description
 *
 * @property CcPropertyValues[] $ccPropertyValues
 * @property CcUnits $unit
 */
class CcProperties extends \yii\db\ActiveRecord
{
    public $name_akk;
    public $hint;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'property_id', 'specific_values', 'translatable_values'], 'integer'],
            [['name', 'name_akk'], 'string', 'max' => 64],
            [['class', 'description'], 'string', 'max' => 32],
            [['hint'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'id' => Yii::t('app', 'ID'),
           'name' => Yii::t('app', 'Name'),
           'type' => Yii::t('app', 'Type'),
           'property_id' => Yii::t('app', 'Property ID'),
           'specific_values' => Yii::t('app', 'Specific Values'),
           'translatable_values' => Yii::t('app', 'Translatable Values'),
           'class' => Yii::t('app', 'Class'),
           'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValues()
    {
        return $this->hasMany(CcPropertyValues::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(CcProperties::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CcProperties::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiblings()
    {
        return $this->parent->children;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectProperties()
    {
        return $this->hasMany(CcObjectProperties::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionProperties()
    {
        return $this->hasMany(CcActionProperties::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryProperties()
    {
        return $this->hasMany(CcIndustryProperties::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        $action_translation = Translations::find()->where('lang_code="SR" and entity="property" and entity_id='.$this->id)->one();
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
        return Yii::$app->operator->sentenceCase($this->tName); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function inputType($object_ownership='provider')
    {
        switch ($this->type) {
            case 1:
                $part = ($object_ownership=='user') ? '_number' : '_range';
                break;
            case 2:
                $part = ($object_ownership=='user') ? '_radio' : '_multiselect';
                break;
            case 21:
                $part = ($object_ownership=='user') ? '_radioButton' : '_checkboxButton';
                break;
            case 22:
                $part = '_radio';
            case 23:
                $part = '_radioButton';
                break;
            case 3:
                $part = ($object_ownership=='user') ? '_select' : '_multiselect';
                break;
            case 31:
                $part = ($object_ownership=='user') ? '_select2' : '_multiselect_select2';
                break;
            case 32:
                $part = ($object_ownership=='user') ? '_select_media' : '_multiselect_media';
                break;
            case 4:
                $part = '_multiselect';
                break;            
            case 41:
                $part = '_checkboxButton';
                break;
            case 42:
                $part = '_multiselect_select';
                break;
            case 43:
                $part = '_multiselect_select2';
                break;
            case 44:
                $part = '_multiselect_media';
                break;
            case 45:
                $part = '_multiselect_media_count';
                break;
            case 5:
                $part = '_checkbox';
                break;
            case 6:
                $part = ($object_ownership=='user') ? '_text' : null;
                break;
            case 7:
                $part = ($object_ownership=='user') ? '_textarea' : null;
                break;
            case 8:
                $part = '_slider';
                break;
            case 9:
                $part = '_range'; // with operator
                break;
            case 10:
                $part = '_date';
                break;
            case 11:
                $part = '_time';
                break;
            case 12:
                $part = '_datetime';
                break;
            case 13:
                $part = '_email';
                break;
            case 14:
                $part = '_url';
                break;
            case 15:
                $part = '_color';
                break;
            case 16:
                $part = '_date_range';
                break;
            case 99:
                $part = '_file';
                break;
            default:
                $part = '_text';
                break;
        }       
        return $part;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function inputTypePresentation($object_ownership='provider')
    {
        switch ($this->type) {
            case 1:
                $part = '_number';
                break;
            case 2:
                $part = ($object_ownership=='provider') ? '_radio' : '_multiselect';
                break;
            case 21:
                $part = ($object_ownership=='provider') ? '_radioButton' : '_checkboxButton';
                break;
            case 22:
                $part = '_radio';
            case 23:
                $part = '_radioButton';
                break;
            case 3:
                $part = ($object_ownership=='provider') ? '_select' : '_multiselect';
                break;
            case 31:
                $part = ($object_ownership=='provider') ? '_select2' : '_multiselect';
                break;
            case 32:
                $part = ($object_ownership=='provider') ? '_select_media' : '_multiselect';
                break;
            case 4:
                $part = '_multiselect';
                break;            
            case 41:
                $part = '_checkboxButton';
                break;
            case 42:
                $part = '_multiselect_select';
                break;
            case 43:
                $part = '_multiselect_select2';
                break;
            case 44:
                $part = '_multiselect_media';
                break;
            case 45:
                $part = '_multiselect_media_count';
                break;
            case 5:
                $part = '_checkbox';
                break;            
            case 6:
                $part = ($object_ownership=='provider') ? '_text' : null;
                break;
            case 7:
                $part = ($object_ownership=='provider') ? '_textarea' : null;
                break;
            case 8:
                $part = '_slider';
                break;
            case 9:
                $part = '_range';
                break;
            case 10:
                $part = '_date';
                break;
            case 11:
                $part = '_time';
                break;
            case 12:
                $part = '_datetime';
                break;
            case 13:
                $part = '_email';
                break;
            case 14:
                $part = '_url';
                break;
            case 15:
                $part = '_color';
                break;
            case 16:
                $part = '_date_range';
                break;
            case 99:
                $part = '_file';
                break;
            default:
                $part = '_text';
                break;
        }       
        return $part;
    } 
}
