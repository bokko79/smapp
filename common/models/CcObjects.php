<?php

namespace common\models;

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
class CcObjects extends \yii\db\ActiveRecord
{

    public $imageFile; 

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['object_id', 'level', 'favour', 'file_id'], 'integer'],
            [['class'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Ime predmeta'),
            'level' => Yii::t('app', 'Level'), 
            'object_id' => Yii::t('app', 'Parent ID'),
            'class' => Yii::t('app', 'Klasa'),
            'favour' => Yii::t('app', 'Da li je moguće snimiti?'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            if($this->file and $this->file_id != 2 and file_exists(Yii::getAlias('images/objects/thumbs/'.$this->file->ime)) and file_exists(Yii::getAlias('images/objects/'.$this->file->ime))){
                unlink(Yii::getAlias('images/objects/thumbs/'.$this->file->ime));
                unlink(Yii::getAlias('images/objects/'.$this->file->ime));
            }
           
            $fileName = $this->id . '_' . time();
            $this->imageFile->saveAs('images/objects/' . $fileName . '1.' . $this->imageFile->extension);         
            
            $image = new \common\models\Files();
            $image->ime = $fileName . '.' . $this->imageFile->extension;
            $image->type = 'image';
            $image->date = date('Y-m-d H:i:s');
            
            $thumb = 'images/objects/'.$fileName.'1.'.$this->imageFile->extension;
            Image::thumbnail($thumb, 400, 300)->save(Yii::getAlias('images/objects/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]);                
            Image::thumbnail($thumb, 80, 64)->save(Yii::getAlias('images/objects/thumbs/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]); 
            
            $image->save();

            if($image->save()){
                $this->file_id = $image->id;
                $this->imageFile = null;
                $this->save();
            }

            unlink(Yii::getAlias($thumb));
            
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectIssues()
    {
        //return $this->hasMany(CcObjectIssues::className(), ['object_id' => 'id']);
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
    public function getT()
    {
        return $this->hasMany(CcObjectsTranslation::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        // return $this->hasMany(CcServices::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CcObjects::className(), ['id' => 'object_id'])->orderBy(['name' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(CcObjects::className(), ['object_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiblings()
    {
        return $this->hasMany(CcObjects::className(), ['object_id' => 'object_id'])->andWhere('id != '.$this->id)->orderBy(['name' => SORT_ASC]);
        //return $this->parent->children;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicesObjectContainers()
    {
        //return $this->hasMany(CcServiceObjectContainers::className(), ['object_container_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        $tags = CcTags::find()->where('lang_code="SR" and entity_id='.$this->id .' and entity="object"')->all();

        return $tags ? $tags : false;        
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        $models = [];
        if ($objectProperties = $this->getProperties()){
            foreach ($objectProperties as $key => $objectProperty) {
                if($objectProperty->property_type=='models' and $objectPropertyValues = $objectProperty->objectPropertyValues){
                    foreach ($objectPropertyValues as $objectPropertyValue){
                        if($object = $objectPropertyValue->object and !in_array($objectPropertyValue->object, $models)){
                            $models[] = $object;
                        }                        
                    }
                }
            }
        }
        return $models;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        $parts = [];
        if ($objectProperties = $this->getProperties()){
            foreach ($objectProperties as $key => $objectProperty) {
                if(($objectProperty->property_type=='parts' or $objectProperty->property_type=='owner') and $objectPropertyValues = $objectProperty->objectPropertyValues){
                    foreach ($objectPropertyValues as $objectPropertyValue){
                        if($object = $objectPropertyValue->object and !in_array($objectPropertyValue->object, $parts)){
                            $parts[] = $object;
                        }                        
                    }
                }
            }
        }
        return $parts;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectContainers()
    {
        $containers = [];

        if ($objectPropertyValues = $this->objectPropertyValues){
            foreach ($objectPropertyValues as $key => $objectPropertyValue){
                if($objectPropertyValue->value_type=='part' && $object = $objectPropertyValue->objectProperty->object){
                    if($object->id!=$this->id and !in_array($object->id, $containers)){
                        $containers[] = $object;
                    }
                }
            }
        }
        return $containers;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContainers()
    {
        $containers = [];

        if ($objectContainers = $this->objectContainers){
            foreach ($objectContainers as $key => $objectContainer){               
                $containers[] = $objectContainer;
            }
        }

        foreach ($this->getPath($this) as $path){
            if ($objectContainerspp = $path->objectContainers){
                foreach ($objectContainerspp as $key => $objectContainerpp){  
                    if(!in_array($objectContainerpp, $containers)){
                        $containers[] = $objectContainerpp;
                    }                          
                }
            }
        }
        return $containers;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMolds()
    {
        $molds = [];

        if ($objectPropertyValues = $this->objectPropertyValues){
            foreach ($objectPropertyValues as $key => $objectPropertyValue){
                if($objectPropertyValue->value_type=='model' && $object = $objectPropertyValue->objectProperty->object){
                    if($object->id!=$this->id and !in_array($object->id, $molds)){
                        $molds[] = $object;
                    }                    
                }
            }
        }
        return $molds;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectProperties()
    {
        return $this->hasMany(CcObjectProperties::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPropertyValues()
    {
        return $this->hasMany(CcObjectPropertyValues::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObjects()
    {
        return $this->hasMany(UserObjects::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderObjectModels()
    {
        return $this->hasMany(OrderServiceObjectModels::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationObjectModels()
    {
        return $this->hasMany(PresentationObjectModels::className(), ['object_model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        /*$object_translation = CcObjectsTranslation::find()->where('lang_code="SR" and object_id='.$this->id)->one();
        if($object_translation) {
            return $object_translation;
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
    public function getSCaseName()
    {
        return Yii::$app->operator->sentenceCase($this->tName); 
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
    public function getTNameDat()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_dat;
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
    public function getTNameInst()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_inst;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNamePl()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_pl;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNamePlGen()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_pl_gen;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTGender()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->name_gender;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHint()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->hint;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTDescription()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->description;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isModel()
    {
        return $this->class=='model' ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isPart()
    {
        return $this->class=='part' ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isAbstract()
    {
        return $this->class=='abstract' ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isObject()
    {
        return $this->class=='object' ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPath($object)
    {
        $path = [];
        $level = $object->level;
        $parent = $object->parent;
        
        if ($level>1)
        {            
            $path[$level-1] = $parent;     
            $path = array_merge($this->getpath($parent), $path);
        }

        return $path;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    { 
        $properties = [];
        $owner = [];
        $check = [];

        // properties of an object
        if($objectProperties = $this->objectProperties){
            foreach($objectProperties as $objectProperty){
                if(!in_array($objectProperty, $properties)){
                    $objectProperty->inheritance = 'own';
                    $properties[] = $objectProperty;                    
                    $check[] = $objectProperty->property_id;                   
                }                
            }
        }

        // protected properties of parent classes (inherited)
        // public properties of parent classes
        // default value from the nearest parent class
        if($this->getPath($this)){
            foreach (array_reverse($this->getPath($this)) as $key => $objectpp) {
                if($objectPropertiespp = $objectpp->objectProperties){
                    foreach($objectPropertiespp as $objectPropertypp){
                        if($objectPropertypp->property_class!='private' and !in_array($objectPropertypp, $properties) and !in_array($objectPropertypp->property_id, $check)){
                            $objectPropertypp->inheritance = 'inherited';
                            $properties[] = $objectPropertypp;
                            $check[] = $objectPropertypp->property_id;
                        }
                    }
                }                    
            }
        }

        // protected and public properties of molds
        if($molds = $this->molds){
            foreach (array_reverse($molds) as $key => $mold) {
                if($objectPropertiesmm = $mold->objectProperties){
                    foreach($objectPropertiesmm as $objectPropertymm){
                        if($objectPropertymm->property_class!='private' and !in_array($objectPropertymm, $properties) and !in_array($objectPropertymm->property_id, $check)){
                            $objectPropertymm->inheritance = 'inherited';
                            $properties[] = $objectPropertymm;
                            $check[] = $objectPropertymm->property_id;
                        }
                    }
                }                    
            }
        }

        // public properties of containers
        if($containers = $this->containers){
            foreach (array_reverse($containers) as $key => $container) {
                if($objectPropertiescc = $container->objectProperties){
                    foreach($objectPropertiescc as $objectPropertycc){
                        if($objectPropertycc->property_class=='public' and !in_array($objectPropertycc, $properties) and !in_array($objectPropertycc->property_id, $check)){
                            $objectPropertycc->inheritance = 'inherited';
                            $properties[] = $objectPropertycc;
                            $check[] = $objectPropertycc->property_id;
                        }
                    }
                }                    
            }
        }

        return $properties;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllProperties()
    { 
        $properties = [];
        $owner = [];

        // properties of an object
        if($objectProperties = $this->objectProperties){
            foreach($objectProperties as $objectProperty){
                $objectProperty->inheritance = 'own';
                $properties[] = $objectProperty;   
            }
        }

        // protected properties of parent classes (inherited)
        // public properties of parent classes
        // default value from the nearest parent class
        if($this->getPath($this)){
            foreach (array_reverse($this->getPath($this)) as $key => $objectpp) {
                if($objectPropertiespp = $objectpp->objectProperties){
                    foreach($objectPropertiespp as $objectPropertypp){
                        if($objectPropertypp->property_class!='private'/* and !in_array($objectPropertypp, $properties) and !in_array($objectPropertypp->property_id, $check)*/){
                            $objectPropertypp->inheritance = 'inherited';
                            $properties[] = $objectPropertypp;
                        }
                    }
                }                    
            }
        }

        // protected and public properties of molds
        if($molds = $this->molds){
            foreach (array_reverse($molds) as $key => $mold) {
                if($objectPropertiesmm = $mold->objectProperties){
                    foreach($objectPropertiesmm as $objectPropertymm){
                        if($objectPropertymm->property_class!='private'/* and !in_array($objectPropertymm, $properties) and !in_array($objectPropertymm->property_id, $check)*/){
                            $objectPropertymm->inheritance = 'inherited';
                            $properties[] = $objectPropertymm;
                        }
                    }
                }                    
            }
        }

        // public properties of containers
        if($containers = $this->containers){
            foreach (array_reverse($containers) as $key => $container) {
                if($objectPropertiescc = $container->objectProperties){
                    foreach($objectPropertiescc as $objectPropertycc){
                        if($objectPropertycc->property_class=='public'/* and !in_array($objectPropertycc, $properties) and !in_array($objectPropertycc->property_id, $check)*/){
                            $objectPropertycc->inheritance = 'inherited';
                            $properties[] = $objectPropertycc;
                        }
                    }
                }                    
            }
        }

        return $properties;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getTNameWithMedia()
    {
        $image = yii\helpers\Html::img('@web/images/objects/'.$this->file->ime, ['style'=>'width:100%; height:110px; margin: 5px 0 10px']);
        
        return c($this->tName) . $image;         
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameWithHint()
    {
        if ($this->hint!=null) {
            return $this->label . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$this->tHint.'">
                 <i class="fa fa-question-circle gray-color"></i>
                </span>'; 
        } else {
            return $this->label;
        }               
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNameWithMedia()
    {
        $image = \yii\helpers\Html::img('@web/images/cards/info/info_docs'.rand(0, 9).'.jpg', ['style'=>'width:100%; height:110px; margin: 5px 0 10px']);
        if ($this->tHint!=null) {
            return $this->tName . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$this->tHint.'">
                 <i class="fa fa-question-circle gray-color"></i>
                </span>' . $image; 
        } else {
            return $this->tName . $image;
        } 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllActions()
    { 
        $actions = [];

        // object is model of service object
        if($objectPropertyValues = $this->objectPropertyValues){
            foreach($objectPropertyValues as $objectPropertyValue){
                if($serviceObjectPropertyValues = $objectPropertyValue->serviceObjectPropertyValues){
                    foreach($serviceObjectPropertyValues as $serviceObjectPropertyValue){
                        $actions[] = $serviceObjectPropertyValue->service;
                    }
                }
            }
        }

        // object is model of a model service object
        if($models = $this->models){
            foreach ($models as $model){
                if($objectPropertyValues = $this->objectPropertyValues){
                    foreach($objectPropertyValues as $objectPropertyValue){
                        if($serviceObjectPropertyValues = $objectPropertyValue->serviceObjectPropertyValues){
                            foreach($serviceObjectPropertyValues as $serviceObjectPropertyValue){
                                $actions[] = $serviceObjectPropertyValue->service;
                            }
                        }
                    }
                }
            }
        }              

        return $actions;
    }
}
