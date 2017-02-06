<?php

namespace frontend\models;

use Yii;
use yii\imagine\Image;
use yii\helpers\Html;

/**
 * This is the model class for table "cc_objects".
 *
 * @property integer $id
 * @property string $name
 * @property string $object_id 
 * @property integer $level 
 * @property string $class
 * @property integer $favour
 * @property string $file_id
 *
 * @property CcObjects[] $ccObjects
 * @property Files $file
 * @property User $addedBy
 * @property CcServices[] $ccServices
 * @property UserObjects[] $userObjects
 */
class Objects extends \yii\elasticsearch\ActiveRecord
{
	/**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return ['id', 'name', 'parent'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(\common\models\CcServices::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\common\models\CcObjects::className(), ['id' => 'object_id'])->orderBy(['name' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(\common\models\CcObjects::className(), ['object_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectProperties()
    {
        return $this->hasMany(\common\models\CcObjectProperties::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPropertyValues()
    {
        return $this->hasMany(\common\models\CcObjectPropertyValues::className(), ['object_id' => 'id']);
    }
}
