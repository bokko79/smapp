<?php

namespace common\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "cc_providers".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $file_id
 * @property string $status
 * @property string $hit_counter
 *
 * @property Banners[] $banners
 * @property CcActions[] $ccActions
 * @property Images $image
 * @property User $addedBy
 * @property CcIndustriesTranslation[] $ccIndustriesTranslations
 * @property CcServices[] $ccServices
 * @property CcSimilarIndustries[] $ccSimilarIndustries
 * @property CcSimilarIndustries[] $ccSimilarIndustries0
 * @property CcSkills[] $ccSkills
 * @property Provider[] $providers
 * @property ProviderServices[] $providerServices
 * @property UserServices[] $userServices
 */
class CcProviders extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['file_id'], 'integer'],
            [['status', 'type'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ime provajdera',
            'file_id' => 'Slika provajdera',
            'status' => 'Status',
            'type' => 'Vrsta',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            if($this->file and $this->file_id != 2){
                unlink(Yii::getAlias('images/providers/thumbs/'.$this->file->ime));
                unlink(Yii::getAlias('images/providers/'.$this->file->ime));
            }
           
            $fileName = $this->id . '_' . $this->name;
            $this->imageFile->saveAs('images/providers/' . $fileName . '1.' . $this->imageFile->extension);         
            
            $image = new \common\models\Files();
            $image->ime = $fileName . '.' . $this->imageFile->extension;
            $image->type = 'image';
            $image->date = date('Y-m-d H:i:s');
            
            $thumb = 'images/providers/'.$fileName.'1.'.$this->imageFile->extension;
            Image::thumbnail($thumb, 400, 300)->save(Yii::getAlias('images/providers/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]);                
            Image::thumbnail($thumb, 80, 64)->save(Yii::getAlias('images/providers/thumbs/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]); 
            
            $image->save();

            if($image->save()){
                $this->file_id = $image->id;
                $this->imageFile = null;
                $this->save();
            }
            unlink(Yii::getAlias($thumb));
            
            return;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryProviders()
    {
        return $this->hasMany(CcIndustryProviders::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        $services = [];

        if($industryProviders = $this->industryProviders){
            foreach($industryProviders as $industryProvider){
                if($industryServices = $industryProvider->industry->allServices){
                    foreach($industryServices as $industryService){
                        $services[] = $industryService;
                    }
                }
            }
        }
        return $services;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderProperties()
    {
        return $this->hasMany(CcProviderProperties::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderServices()
    {
        return $this->hasMany(CcProviderServices::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        $action_translation = Translations::find()->where('lang_code="SR" and entity="provider" and entity_id='.$this->id)->one();
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
        if($this->tName) {
            return c($this->tName);
        }       
        return false;   
    }

    // count services    
    public function getCountServices() {
        return $this->services ? count($this->services) : 0;
    }
    // orders, active orders, successful orders
    // providers, active providers
    // presentations, active presentations
    // promotions, active promotions,
    // by location, by language, by time, by status
    // images, avatars, formats
    // special functions.. TBD
}
