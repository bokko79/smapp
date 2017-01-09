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
            [['category_id', 'file_id', 'hit_counter'], 'integer'],
            [['status'], 'string'],
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
            'hit_counter' => 'Broj poseta delatnosti.',
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
    public function getActions()
    {
        //return $this->hasMany(CcActions::className(), ['industry_id' => 'id']);
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
    public function getSector()
    {
        //return $this->category->sector;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIcon()
    {
        //return $this->sector->icon;
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
    public function getT()
    {
        //return $this->hasMany(CcIndustriesTranslation::className(), ['industry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        //return $this->hasMany(CcServices::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        $cont = [];
        if($services = $this->services){
            foreach($services as $service){
                if($presentations = $service->presentations){
                    foreach($presentations as $presentation){
                        $cont[] = $presentation;
                    }
                }
            }
        }
        return $cont;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        $cont = [];
        if($services = $this->services){
            foreach($services as $service){
                if($orders = $service->orders){
                    foreach($orders as $order){
                        $cont[] = $order;
                    }
                }
            }
        }
        return $cont;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotions()
    {
        $cont = [];
        if($services = $this->services){
            foreach($services as $service){
                if($promotions = $service->promotionServices){
                    foreach($promotions as $promotion){
                        $cont[] = $promotion;
                    }
                }
            }
        }
        return $cont;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarIndustries()
    {
        //return $this->hasMany(CcSimilarIndustries::className(), ['industry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarIndustries0()
    {
        //return $this->hasMany(CcSimilarIndustries::className(), ['similar_industry_id' => 'id']);
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
        return $this->hasMany(ProviderServices::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserServices()
    {
        return $this->hasMany(UserServices::className(), ['provider_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        /*$industry_translation = \common\models\CsIndustriesTranslation::find()->where('lang_code="SR" and industry_id='.$this->id)->one();
        if($industry_translation) {
            return $industry_translation;
        }
        return false;   */     
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTName()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameGen()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gen;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameAkk()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_akk;
        }       
        return false;   
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

   /* public static function getAllIndustriesByCategories() {
        $options = [];
         
        $parents = CsCategories::find()->all();
        foreach($parents as $key => $p) {
            $children = self::find()->where("category_id=:parent_id", [":parent_id"=>$p->id])->all();
            $children = self::find()->where("category_id=:parent_id", [":parent_id"=>$p->id])->all(); 
            $options[$p->name] = yii\helpers\ArrayHelper::map($children, 'id', 'tName');

            /*$child_options = [];
            foreach($children as $child) {
                $child_options[$child->id] = $child->tName;
            }
            $options[$p->tName] = $child_options;
        }
        return $options;
    }*/

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
