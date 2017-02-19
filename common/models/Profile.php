<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\models;

use dektrium\user\traits\ModuleTrait;
use yii\db\ActiveRecord;
use dektrium\user\models\Profile as BaseProfile;
use yii\imagine\Image;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $type
 * @property string $name
 * @property string $fullname
 * @property string $public_email
 * @property string $avatar_id
 * @property string $cover_photo
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $about
 * @property string $timezone
 * @property string $date_of_birth
 * @property integer $height
 * @property integer $weight
 * @property integer $age
 * @property string $marital_status
 * @property string $gender
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 * @property Posts[] $posts
 * @property User $user
 * @property Files $avatar
 * @property Files $coverPhoto
 * @property ProfileAccounts[] $profileAccounts
 * @property ProfileAvailability[] $profileAvailabilities
 * @property ProfileCertifications[] $profileCertifications
 * @property ProfileCourses[] $profileCourses
 * @property ProfileEducations[] $profileEducations
 * @property ProfileExperiences[] $profileExperiences
 * @property ProfileLicences[] $profileLicences
 * @property ProfileMembers[] $profileMembers
 * @property ProfilePatents[] $profilePatents
 * @property ProfileProjects[] $profileProjects
 * @property ProfileProviders[] $profileProviders
 * @property ProfilePublications[] $profilePublications
 * @property ProfileReferences[] $profileReferences
 * @property ProfileReviews[] $profileReviews
 * @property ProfileServices[] $profileServices
 * @property ProfileTerms $profileTerms
 */
class Profile extends BaseProfile
{
    use ModuleTrait;
    /** @var \dektrium\user\Module */
    protected $module;

    public $imageAvatar; 
    public $imageCover; 

    const BEFORE_CREATE   = 'beforeCreate';
    const AFTER_CREATE   = 'afterCreate';

    /** @inheritdoc */
    public function init()
    {
        $this->module = \Yii::$app->getModule('user');
        $this->on(self::BEFORE_CREATE, [$this, 'beforeCreate']);
        $this->on(self::AFTER_CREATE, [$this, 'afterCreate']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'type', 'avatar_id', 'cover_photo', 'height', 'weight', 'age'], 'integer'],
            [['about', 'marital_status', 'gender'], 'string'],
            [['date_of_birth'], 'safe'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['fullname'], 'string', 'max' => 256],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar_id' => 'id']],
            [['cover_photo'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['cover_photo' => 'id']],
            [['imageAvatar', 'imageCover'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'name' => 'Name',
            'fullname' => 'Fullname',
            'public_email' => 'Public Email',
            'avatar_id' => 'Avatar ID',
            'cover_photo' => 'Cover Photo',
            'gravatar_email' => 'Gravatar Email',
            'gravatar_id' => 'Gravatar ID',
            'location' => 'Location',
            'website' => 'Website',
            'about' => 'About',
            'timezone' => 'Timezone',
            'date_of_birth' => 'Date Of Birth',
            'height' => 'Height',
            'weight' => 'Weight',
            'age' => 'Age',
            'marital_status' => 'Marital Status',
            'gender' => 'Gender',
        ];
    }

    public function uploadAvatar()
    {
        if ($this->validate()) {

            if($this->avatar_id and file_exists(\Yii::getAlias('images/profile/'.$this->avatar->name))){
                unlink(\Yii::getAlias('images/profile/'.$this->avatar->name));
            }
           
            $fileName = $this->id . '_' . time();
            $this->imageAvatar->saveAs('images/profile/' . $fileName . '1.' . $this->imageAvatar->extension);         
            
            $image = new \common\models\Files();
            $image->name = $fileName . '.' . $this->imageAvatar->extension;
            $image->type = 'image';
            $image->created_at = time();
            
            $thumb = 'images/profile/'.$fileName.'1.'.$this->imageAvatar->extension;                          
            Image::thumbnail($thumb, 64, 64)->save(\Yii::getAlias('images/profile/'.$fileName.'.'.$this->imageAvatar->extension), ['quality' => 80]); 
            
            $image->save();

            if($image->save()){
                $this->avatar_id = $image->id;
                $this->imageAvatar = null;
                $this->save();
            }

            unlink(\Yii::getAlias($thumb));
            
            return true;
        } else {
            return false;
        }
    }

    public function uploadCoverPhoto()
    {
        if ($this->validate()) {

            if($this->cover_photo and file_exists(\Yii::getAlias('images/profile/'.$this->coverPhoto->name))){
                unlink(Yii::getAlias('images/profile/'.$this->coverPhoto->ime));
            }
           
            $fileName = $this->id . '_' . time();
            $this->imageCover->saveAs('images/profile/' . $fileName . '1.' . $this->imageCover->extension);         
            
            $image = new \common\models\Files();
            $image->name = $fileName . '.' . $this->imageCover->extension;
            $image->type = 'image';
            $image->created_at = time();
            
            $thumb = 'images/profile/'.$fileName.'1.'.$this->imageCover->extension;                          
            Image::thumbnail($thumb, 1200, 240)->save(\Yii::getAlias('images/profile/'.$fileName.'.'.$this->imageCover->extension), ['quality' => 80]); 
            
            $image->save();

            if($image->save()){
                $this->cover_photo = $image->id;
                $this->imageCover = null;
                $this->save();
            }

            unlink(\Yii::getAlias($thumb));
            
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoverPhoto()
    {
        return $this->hasOne(Files::className(), ['id' => 'cover_photo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileAccounts()
    {
        return $this->hasMany(ProfileAccounts::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileAvailabilities()
    {
        return $this->hasMany(ProfileAvailability::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileCertifications()
    {
        return $this->hasMany(ProfileCertifications::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileCourses()
    {
        return $this->hasMany(ProfileCourses::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileEducations()
    {
        return $this->hasMany(ProfileEducations::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileExperiences()
    {
        return $this->hasMany(ProfileExperiences::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileLicences()
    {
        return $this->hasMany(ProfileLicences::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileMembers()
    {
        return $this->hasMany(ProfileMembers::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfilePatents()
    {
        return $this->hasMany(ProfilePatents::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileProjects()
    {
        return $this->hasMany(ProfileProjects::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileProviders()
    {
        return $this->hasMany(ProfileProviders::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfilePublications()
    {
        return $this->hasMany(ProfilePublications::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileReferences()
    {
        return $this->hasMany(ProfileReferences::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileReviews()
    {
        return $this->hasMany(ProfileReviews::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileServices()
    {
        return $this->hasMany(ProfileServices::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileTerms()
    {
        return $this->hasOne(ProfileTerms::className(), ['profile_id' => 'id']);
    }

    /** @inheritdoc */
    public function beforeCreate($event)
    {
        $this->user_id = \Yii::$app->user->id;
    }

    /** @inheritdoc */
    public function afterCreate($event)
    {
        $profile_language = new ProfileLanguages();
        $profile_language->profile_id = $this->id;
        $profile_language->lang_code = 'SR';
        $profile_language->save();

        $profile_terms = new ProfileTerms();
        $profile_terms->profile_id = $this->id;
        $profile_terms->update_time = time();
        $profile_terms->save();        
    }
}
