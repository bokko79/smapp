<?php

namespace common\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "cc_industries".
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
 * @property CcServices[] $ccServices
 * @property Provider[] $providers
 * @property ProviderServices[] $providerServices
 * @property UserServices[] $userServices
 */
class CcIndustries extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_industries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['category_id', 'file_id', 'hit_counter'], 'integer'],
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
            'name' => 'Ime delatnosti.',
            'category_id' => 'Kategorija uslužne delatnosti.',
            'file_id' => 'Slika delatnosti.',
            'status' => 'Status',
            'type' => 'Type',
            'hit_counter' => 'Broj poseta delatnosti.',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            if($this->file and $this->file_id != 2){
                unlink(Yii::getAlias('images/industries/thumbs/'.$this->file->ime));
                unlink(Yii::getAlias('images/industries/'.$this->file->ime));
            }
           
            $fileName = $this->id . '_' . $this->name;
            $this->imageFile->saveAs('images/industries/' . $fileName . '1.' . $this->imageFile->extension);         
            
            $image = new \common\models\Files();
            $image->ime = $fileName . '.' . $this->imageFile->extension;
            $image->type = 'image';
            $image->date = date('Y-m-d H:i:s');
            
            $thumb = 'images/industries/'.$fileName.'1.'.$this->imageFile->extension;
            Image::thumbnail($thumb, 400, 300)->save(Yii::getAlias('images/industries/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]);                
            Image::thumbnail($thumb, 80, 64)->save(Yii::getAlias('images/industries/thumbs/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]); 
            
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
    public function getActions()
    {
        return $this->hasMany(CcActions::className(), ['industry_id' => 'id']);
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
    public function getCategory()
    {
        return $this->hasOne(CcIndustries::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIcon()
    {
        //return $this->icon;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        //return $this->sector->color;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(CcServices::className(), ['industry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryProviders()
    {
        return $this->hasMany(CcIndustryProviders::className(), ['industry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        $industry_translation = Translations::find()->where('lang_code="SR" and entity="industry" and entity_id='.$this->id)->one();
        if($industry_translation) {
            return $industry_translation;
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
        return $this->name;   
    }

    public static function getAllIndustriesByCategories() 
    {

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
