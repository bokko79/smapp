<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_process_task_files".
 *
 * @property string $id
 * @property string $process_task_id
 * @property string $file_id
 * @property string $type
 *
 * @property CcProcesses $processTask
 * @property Files $file
 */
class CcProcessTaskFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_process_task_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_task_id', 'file_id'], 'required'],
            [['process_task_id', 'file_id'], 'integer'],
            [['type'], 'string'],
            [['process_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcProcesses::className(), 'targetAttribute' => ['process_task_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],
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
            'file_id' => 'File ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTask()
    {
        return $this->hasOne(CcProcesses::className(), ['id' => 'process_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }
}
