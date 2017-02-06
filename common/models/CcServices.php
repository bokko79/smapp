<?php

namespace common\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "cc_services".
 *
 * @property integer $id
 * @property integer $industry_id
 * @property integer $action_id
 * @property string $object_id
 * @property integer $unit_id
 * @property string $file_id
 * @property string $name
 * @property integer $service_type
 * @property string $object_class
 * @property string $object_ownership
 * @property integer $file
 * @property integer $amount
 * @property integer $consumer
 * @property integer $consumer_children
 * @property integer $location
 * @property integer $coverage
 * @property integer $shipping
 * @property integer $geospecific
 * @property integer $time
 * @property integer $duration
 * @property integer $frequency
 * @property integer $availability
 * @property integer $installation
 * @property integer $tools
 * @property integer $turn_key
 * @property integer $support
 * @property integer $ordering
 * @property integer $pricing
 * @property integer $terms
 * @property integer $labour_type
 * @property integer $process
 * @property string $dat
 * @property string $status
 * @property string $hit_counter
 *
 *
 * @property CcRecommendedServices[] $ccRecommendedServices
 * @property CcRecommendedServices[] $ccRecommendedServices0
 * @property CcServiceProcesses[] $ccServiceProcesses
 * @property CcServiceRegulations[] $ccServiceRegulations
 * @property CcServiceSpecc[] $ccServiceSpecs
 * @property CcObjects $object
 * @property CcUnits $unit
 * @property CcActions $action0
 * @property CcIndustries $industry
 * @property User $addedBy
 * @property CcServicesTranslation[] $ccServicesTranslations
 * @property CcSimilarServices[] $ccSimilarServices
 * @property CcSimilarServices[] $ccSimilarServices0
 * @property OrderServices[] $orderServices
 * @property PromotionServices[] $promotionServices
 * @property ProviderServices[] $providerServices
 * @property ServiceComments[] $serviceComments
 * @property UserServices[] $userServices
 */
class CcServices extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['industry_id', 'action_id', 'object_id', 'unit_id', 'name', 'service_type'], 'required'],
            [['industry_id', 'action_id', 'object_id', 'unit_id', 'file_id', 'service_type', 'file', 'amount', 'consumer', 'consumer_children', 'location', 'coverage', 'shipping', 'geospecific', 'time', 'duration', 'frequency', 'availability', 'installation', 'tools', 'turn_key', 'support', 'ordering', 'pricing', 'terms', 'labour_type', 'process', 'hit_counter'], 'integer'],
            [['object_class', 'object_ownership', 'dat', 'status'], 'string'],
            [['name'], 'string', 'max' => 90],
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
            'industry_id' => Yii::t('app', 'Industry ID'),
            'action_id' => Yii::t('app', 'Action ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'name' => Yii::t('app', 'Name'),
            'service_type' => Yii::t('app', 'Service Type'),
            'object_class' => Yii::t('app', 'Object Class'),
            'object_ownership' => Yii::t('app', 'Object Ownership'),
            'file' => Yii::t('app', 'File'),
            'amount' => Yii::t('app', 'Amount'),
            'consumer' => Yii::t('app', 'Consumer'),
            'consumer_children' => Yii::t('app', 'Consumer Children'),
            'location' => Yii::t('app', 'Location'),
            'coverage' => Yii::t('app', 'Coverage'),
            'shipping' => Yii::t('app', 'Shipping'),
            'geospecific' => Yii::t('app', 'Geospecific'),
            'time' => Yii::t('app', 'Time'),
            'duration' => Yii::t('app', 'Duration'),
            'frequency' => Yii::t('app', 'Frequency'),
            'availability' => Yii::t('app', 'Availability'),
            'installation' => Yii::t('app', 'Installation'),
            'tools' => Yii::t('app', 'Tools'),
            'turn_key' => Yii::t('app', 'Turn Key'),
            'support' => Yii::t('app', 'Support'),
            'ordering' => Yii::t('app', 'Ordering'),
            'pricing' => Yii::t('app', 'Pricing'),
            'terms' => Yii::t('app', 'Terms'),
            'labour_type' => Yii::t('app', 'Labour Type'),
            'process' => Yii::t('app', 'Process'),
            'dat' => Yii::t('app', 'Dat'),
            'status' => Yii::t('app', 'Status'),
            'hit_counter' => Yii::t('app', 'Hit Counter'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            if($this->file and $this->file_id != 2){
                unlink(Yii::getAlias('images/services/thumbs/'.$this->file->ime));
                unlink(Yii::getAlias('images/services/'.$this->file->ime));
            }
           
            $fileName = $this->id . '_' . $this->name;
            $this->imageFile->saveAs('images/services/' . $fileName . '1.' . $this->imageFile->extension);         
            
            $image = new \common\models\Images();
            $image->ime = $fileName . '.' . $this->imageFile->extension;
            $image->type = 'image';
            $image->date = date('Y-m-d H:i:s');
            
            $thumb = 'images/services/'.$fileName.'1.'.$this->imageFile->extension;
            Image::thumbnail($thumb, 400, 300)->save(Yii::getAlias('images/services/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]);                
            Image::thumbnail($thumb, 80, 64)->save(Yii::getAlias('images/services/thumbs/'.$fileName.'.'.$this->imageFile->extension), ['quality' => 80]); 
            
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
    public function getRecommendedServices()
    {
        return $this->hasMany(CcRecommendedServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendedServices0()
    {
        return $this->hasMany(CcRecommendedServices::className(), ['rcmd_service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProcesses()
    {
        return $this->hasMany(CcServiceProcesses::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceRegulations()
    {
        return $this->hasMany(CcServiceRegulations::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProviderProperties()
    {
        return $this->hasMany(CcServiceProviderProperties::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceActionProperties()
    {
        return $this->hasMany(CcServiceActionProperties::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectProperties()
    {
        return $this->hasMany(CcServiceObjectProperties::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(CcObjects::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderingFlow()
    {
        return $this->hasOne(CcServiceOrderingFlow::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalization()
    {
        return $this->hasOne(CcServiceLocalization::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuantities()
    {
        return $this->hasOne(CcServiceQuantities::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(CcUnits::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(CcServiceUnits::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(CcActions::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry()
    {
        return $this->hasOne(CcIndustries::className(), ['id' => 'industry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarServices()
    {
        return $this->hasMany(CcSimilarServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimilarServices0()
    {
        return $this->hasMany(CcSimilarServices::className(), ['sim_service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderServices()
    {
        //return $this->hasMany(OrderServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentations()
    {
        //return $this->hasMany(Presentations::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotionServices()
    {
        //return $this->hasMany(PromotionServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderServices()
    {
        //return $this->hasMany(ProviderServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceComments()
    {
        return $this->hasMany(ServiceComments::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserServices()
    {
        return $this->hasMany(UserServices::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isBookmarked($user_id)
    {
        if($userServices = $this->userServices){
            foreach($userServices as $userService){
                if($userService->user_id == $user_id){
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function isActiveBookmark($user_id)
    {
        if($userServices = $this->userServices){
            foreach($userServices as $userService){
                if($userService->user_id == $user_id and $userService->status==1){
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return ($this->object->file) ? $this->object->file->ime : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAveragePrice()
    {
        return '2.499,99&nbsp;RSD/m<sup>2</sup>';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        /*$service_translation = CcServicesTranslation::find()->where('lang_code="SR" and service_id='.$this->id)->one();
        if($service_translation) {
            return $service_translation;
        }
        return false;  */      
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
    public function getSCaseName()
    {
        return c($this->tName); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTNote()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->note;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSubnote()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->note;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHintOrder()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->hint_order;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHintPresentation()
    {
        if($this->getTranslation()) {
            return $this->getTranslation()->hint_presentation;
        }       
        return false;   
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectModelsList()
    {
        $model_list = null; 

        if($service_object_models = $this->serviceObjectModels){
            $model_list = \yii\helpers\ArrayHelper::map($service_object_models, 'object_model_id', 'model');
        } else if($object_models = $this->object->models){
            $model_list = \yii\helpers\ArrayHelper::map($object_models, 'id', 'tNameWithMedia');
        }

        return $model_list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectContainersList($objectModels=[])
    {
        $model_list = null;
        //$objectModel = \common\models\
        if($service_object_containers = $this->serviceObjectContainers){
            if($objectModels and count($objectModels)==1){ // ako je selektovan jedan model, izlistaj kontejnere samo za njega
                $object_model = $objectModels[0]->objectModel;
                foreach($this->serviceObjectModels as $serviceObjectModel){
                    if($serviceObjectModel->object_model_id==$object_model->id){
                        //$serviceObjectModelContainers = $serviceObjectModel->serviceObjectModelContainers;
                        $model_list = \yii\helpers\ArrayHelper::map($serviceObjectModel->serviceObjectModelContainers, 'serviceObjectContainer.object_container_id', 'serviceObjectContainer.container');
                        break;
                    }
                }
            } else {
                $model_list = \yii\helpers\ArrayHelper::map($service_object_containers, 'object_container_id', 'container');
            }            
        }

        return $model_list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPropertiesList($objectModels=[])
    {
        $properties = [];
        $object = ($objectModels and count($objectModels)==1) ? $objectModels[0]->objectModel : $this->object;
        //$objectModel = \common\models\
        if($service_object_properties = $this->serviceObjectProperties){ // serviceObjectProperties override general objectProperties            
            foreach($service_object_properties as $service_object_property){
                /*foreach($object->getProperties($object) as $object_property){
                    if($service_object_property->object_property_id==$object_property->id){
                        $properties[] = $objectProperty;
                        break;
                    }
                }    */
                $properties[] = $service_object_property->objectProperty;                   
            }  

                  
        }/* else {
            $properties = $object->getProperties();
        }*/

        return $properties;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        switch ($this->service_type){
            case 1: $value = 'create'; break;
            case 2: $value = 'read'; break;
            case 3: $value = 'update'; break;
            case 4: $value = 'delete'; break;
            case 5: $value = 'rent'; break;
            case 6: $value = 'fix'; break;
            case 7: $value = 'deliver'; break;
            case 8: $value = 'replace'; break;
            case 9: $value = 'transport'; break;
            case 10: $value = 'show'; break;
            case 11: $value = 'perform'; break;
            case 12: $value = 'copy_paste'; break;
            case 13: $value = 'sell'; break;
            case 14: $value = 'prepare'; break;
            case 15: $value = 'install'; break;
            case 16: $value = 'book'; break;
            case 17: $value = 'organize'; break;
            case 18: $value = 'save'; break;
            case 19: $value = 'care'; break;
            case 20: $value = 'represent'; break;
            case 21: $value = 'buy'; break;
            default:
                $value = 'create';
                break;
        }
        return $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectOwnership()
    {
        switch ($this->object_ownership){
            case 1: $value = 'providers'; break;
            case 2: $value = 'users'; break;
            case 3: $value = 'providers multiple'; break;
            case 4: $value = 'users multiple'; break;
            case 5: $value = 'providers 2bcreated'; break;
            case 6: $value = 'users 2bcreated'; break;
            case 7: $value = 'providers intangible'; break;
            case 8: $value = 'users intangible'; break;
            default:
                $value = 'consumer';
                break;
        }
        return $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceFile()
    {
        switch ($this->file){
            case 1: $value = 'required'; break;
            case 2: $value = 'optional'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceAmount()
    {
        switch ($this->amount){
            case 1: $value = 'required'; break;
            case 2: $value = 'optional'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceConsumer()
    {
        switch ($this->consumer){
            case 1: $value = 'required'; break;
            case 2: $value = 'optional'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceConsumerChildren()
    {
        switch ($this->consumer_children){
            case 1: $value = 'required'; break;
            case 2: $value = 'optional'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceLocation()
    {
        switch ($this->location){
            case 1: $value = 'users'; break;
            case 2: $value = 'users start-end'; break;
            case 3: $value = 'users optional'; break;
            case 4: $value = 'users optional start-end'; break;
            case 5: $value = 'providers'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceCoverage()
    {
        switch ($this->coverage){
            case 1: $value = 'HQ only'; break;
            case 2: $value = 'city'; break;
            case 3: $value = 'region (up to 200km)'; break;
            case 4: $value = 'country'; break;
            case 5: $value = 'countries (up to 1000km)'; break;
            case 6: $value = 'worldwide'; break;
            default:
                $value = 'within';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceTime()
    {
        switch ($this->time){
            case 1: $value = 'required'; break;
            case 2: $value = 'asap'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceDuration()
    {
        switch ($this->duration){
            case 1: $value = 'required'; break;
            case 2: $value = 'optional'; break;
            case 3: $value = 'same as units'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceFrequency()
    {
        switch ($this->frequency){
            case 1: $value = 'once'; break;
            case 2: $value = 'return'; break;
            case 3: $value = 'frequently'; break;
            case 4: $value = 'indefinite'; break;
            default:
                $value = 'no';
                break;
        }
        return $value;
    }

    // service object models = SOM
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectModels()
    {
        $som = [];
        if($serviceObjectProperties = $this->serviceObjectProperties){
            foreach($serviceObjectProperties as $serviceObjectProperty){
                if($serviceObjectProperty->property_type=='object_models'){
                    if($serviceObjectPropertyValues = $serviceObjectProperty->serviceObjectPropertyValues){
                        foreach($serviceObjectPropertyValues as $serviceObjectPropertyValue){
                            if($serviceObjectPropertyValue->objectPropertyValue->object_id!=''){
                                $som[] = $serviceObjectPropertyValue->objectPropertyValue->object;
                            }
                        }
                    }/* else if($objectPropertyValues = $serviceObjectProperty->objectProperty->objectPropertyValues){
                        foreach($objectPropertyValues as $objectPropertyValue){
                            if($objectPropertyValue->object_id!=''){
                                $som[] = $objectPropertyValue->object;
                            }
                        }
                    }*/
                    break;
                }
            }
        }
        return $som;
    }

    // SOM models properties
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOMModelProperties($serviceObjectModel)
    {
        $somModelProperty = [];
        if($serviceObjectProperties = $this->serviceObjectProperties){
            foreach($serviceObjectProperties as $serviceObjectProperty){
                if($serviceObjectProperty->property_type=='models' and $serviceObjectProperty->objectProperty->object==$serviceObjectModel){                    
                    $somModelProperty[] = $serviceObjectProperty->objectProperty;
                }
            }
        }
        if($objectProperties = $serviceObjectModel->getProperties()){
            foreach($objectProperties as $objectProperty){
                if($objectProperty->property_type=='models' and !in_array($objectProperty, $somModelProperty)){                    
                    $somModelProperty[] = $objectProperty;
                }
            }
        }
        return $somModelProperty;
    }

    // SOM models
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOMModels($serviceObjectModel)
    {
        $somModels = [];
        if($SOMModelProperties = $this->getSOMModelProperties($serviceObjectModel)){
            foreach($SOMModelProperties as $SOMModelProperty){
                if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                    foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                        if($SOMModelPropertyValue->object){
                            $somModels[] = $SOMModelPropertyValue->object;
                        }
                    }
                }
            }
        }
        return $somModels;
    }

    // SOMFM properties: text, numeric (units), options, boolean, count, files, issues
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOMProperties($serviceObjectModel)
    {
        $somProperty = [];
        if($serviceObjectProperties = $this->serviceObjectProperties){
            foreach($serviceObjectProperties as $serviceObjectProperty){
                if(($serviceObjectProperty->property_type=='text' or $serviceObjectProperty->property_type=='numeric' or $serviceObjectProperty->property_type=='boolean' or $serviceObjectProperty->property_type=='issues' or $serviceObjectProperty->property_type=='value' or $serviceObjectProperty->property_type=='datetime' or $serviceObjectProperty->property_type=='general' or $serviceObjectProperty->property_type=='other' or $serviceObjectProperty->property_type=='count') and $serviceObjectProperty->objectProperty->object==$serviceObjectModel){                    
                    $somProperty[] = $serviceObjectProperty->objectProperty;
                }
            }
        }
        if($objectProperties = $serviceObjectModel->getProperties()){
            foreach($objectProperties as $objectProperty){
                if(($objectProperty->property_type=='text' or $objectProperty->property_type=='numeric' or $objectProperty->property_type=='boolean' or $objectProperty->property_type=='issues' or $objectProperty->property_type=='value' or $objectProperty->property_type=='datetime' or $objectProperty->property_type=='general' or $objectProperty->property_type=='other' or $objectProperty->property_type=='count') and !in_array($objectProperty, $somProperty)){
                    $somProperty[] = $objectProperty;
                }
            }
        }
        return $somProperty;
    }

    // SOMFM parts: boolean, countables
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOMParts($serviceObjectModel)
    {
        $somPartProperty = [];
        if($serviceObjectProperties = $this->serviceObjectProperties){
            foreach($serviceObjectProperties as $serviceObjectProperty){
                if(($serviceObjectProperty->property_type=='parts' or $serviceObjectProperty->property_type=='owner') and $serviceObjectProperty->objectProperty->object==$serviceObjectModel){                    
                    $somPartProperty[] = $serviceObjectProperty->objectProperty;
                }
            }
        }
        if($objectProperties = $serviceObjectModel->getProperties()){
            foreach($objectProperties as $objectProperty){
                if(($objectProperty->property_type=='parts' or $objectProperty->property_type=='owner') and !in_array($objectProperty, $somPartProperty)){                    
                    $somPartProperty[] = $objectProperty;
                }
            }
        }
        return $somPartProperty;
    }

    // SOMFM part models
    // SOMFMPFM properties: text, numeric (units), options, boolean, count, files, issues
    // ..continue with parts (parts of part)

    // SOMFM containers

    // SOMFM container models
    // SOMFMCM properties: text, numeric (units), options, boolean, count, files, issues
    // SOMFMCM parts: boolean, countables
    // SOMFMCM part models
    // SOMFMCMPM properties: text, numeric (units), options, boolean, count, files, issues
    // ...continue with container (containers of container)
}
