<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_process_task_requirements".
 *
 * @property string $id
 * @property string $process_task_id
 * @property string $required_task
 * @property integer $priority
 *
 * @property CcProcessTasks $processTask
 * @property CcProcesses $requiredTask
 */
class CcProcessTaskRequirements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_process_task_requirements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_task_id', 'required_task', 'priority'], 'required'],
            [['process_task_id', 'required_task', 'priority'], 'integer'],
            [['process_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcProcessTasks::className(), 'targetAttribute' => ['process_task_id' => 'id']],
            [['required_task'], 'exist', 'skipOnError' => true, 'targetClass' => CcProcesses::className(), 'targetAttribute' => ['required_task' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'process_task_id' => 'Process Task ID',
            'required_task' => 'Required Task',
            'priority' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTask()
    {
        return $this->hasOne(CcProcessTasks::className(), ['id' => 'process_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequiredTask()
    {
        return $this->hasOne(CcProcessTasks::className(), ['id' => 'required_task']);
    }
}
