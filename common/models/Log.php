<?php

namespace common\models;

use Yii;
use dektrium\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $event
 * @property integer $subject_id
 * @property integer $object_id
 * @property integer $created_at
 *
 * @property Activities $activity
 * @property User $user
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'event', 'created_at'], 'required'],
            [['event', 'user_id', 'subject_id', 'object_id'], 'integer'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User'),
            'event' => Yii::t('app', 'Event Code'),
            'subject_id' => Yii::t('app', 'Subject'),
            'object_id' => Yii::t('app', 'Object'),
            'created_at' => Yii::t('app', 'Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function logEvent($event, $subject=null, $object=null)
    {
        $this->user_id = \Yii::$app->user->id;
        $this->event = $event;
        $this->created_at = time();
        $this->save();

        
        if(!\Yii::$app->user->isGuest){
            $user = User::findOne(\Yii::$app->user->id);
            $user->last_activity_time = time();
            $user->save();
        }        
    }

    public function eventCode()
    {
        $eventCode = [];

        switch ($this->event) {
            case 1: $eventCode['name'] = 'account_created'; break;
            case 2: $eventCode['name'] = 'account_logged_in'; break;
            case 3: $eventCode['name'] = 'account_registered'; break;
            case 5: $eventCode['name'] = 'account_logged_out'; break;
            case 6: $eventCode['name'] = 'account_deactivated'; break;
            case 10: $eventCode['name'] = 'account_password_reset_request'; break;
            case 11: $eventCode['name'] = 'account_email_updated'; break;
            case 12: $eventCode['name'] = 'account_username_updated'; break;
            case 13: $eventCode['name'] = 'account_updated'; break;
            case 19: $eventCode['name'] = 'account_contacted_us'; break;
            case 43: $eventCode['name'] = 'service_visited'; break;
            case 45: $eventCode['name'] = 'service_bookmarked'; break;
            case 46: $eventCode['name'] = 'service_unbookmarked'; break;
            case 47: $eventCode['name'] = 'service_shared'; break;
            case 54: $eventCode['name'] = 'object_visited'; break;
            case 70: $eventCode['name'] = 'industry_visited'; break;
            case 153: $eventCode['name'] = 'account_activated'; break;
            case 154: $eventCode['name'] = 'account_email_verified'; break;
            case 155: $eventCode['name'] = 'account_phone_verified'; break;
            case 156: $eventCode['name'] = 'account_location_verified'; break;
            case 182: $eventCode['name'] = 'account_password_reset'; break;            
            default: $eventCode['name'] = 'unknown_event'; break;
        }

        return $eventCode;
    }

    public function eventText()
    {
        $eventText = [];

        switch ($this->event) {            
            case 43: 
            case 45: 
            case 46: 
            case 47: 
                $service = \common\models\CcServices::find()->where(['id'=>$this->subject_id])->one();
                $eventText['name'] = Html::a($service->name, Url::to(['services/view', 'id'=>$this->subject_id])); break;
            case 54: $eventText['name'] = 'object_visited'; break;
            case 70: $eventText['name'] = 'industry_visited'; break;         
            default: $eventText['name'] = 'unknown_event'; break;
        }

        return $eventText;
    }
}
