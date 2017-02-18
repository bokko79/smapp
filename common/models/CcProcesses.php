<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_processes".
 *
 * @property string $id
 * @property string $name
 *
 * @property CcProcessPhases[] $ccProcessPhases
 */
class CcProcesses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_processes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcProcessTasks()
    {
        return $this->hasMany(CcProcessTasks::className(), ['process_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        $action_translation = Translations::find()->where('lang_code="SR" and entity="process" and entity_id='.$this->id)->one();
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
}
