<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_process_tasks".
 *
 * @property string $id
 * @property string $process_id
 * @property string $type
 * @property string $task_id
 *
 * @property CcProcesses $process
 */
class CcProcessTasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_process_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id'], 'required'],
            [['process_id', 'task_id', 'task_number'], 'integer'],
            [['type', 'name'], 'string'],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcProcesses::className(), 'targetAttribute' => ['process_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'process_id' => 'Process ID',
            'type' => 'Type',
            'task_id' => 'Task ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(CcProcesses::className(), ['id' => 'process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequirements()
    {
        return $this->hasMany(CcProcessTaskRequirements::className(), ['process_task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequiredTasks()
    {
        return $this->hasMany(CcProcessTaskRequirements::className(), ['required_task' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(CcProcessTaskFiles::className(), ['process_task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        $action_translation = Translations::find()->where('lang_code="SR" and entity="task" and entity_id='.$this->id)->one();
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
