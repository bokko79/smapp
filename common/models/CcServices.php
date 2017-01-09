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
    public function getServiceObjectModels()
    {
        return $this->hasMany(CcServiceObjectModels::className(), ['service_id' => 'id']);
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
    public function getServiceObjectContainers()
    {
        return $this->hasMany(CcServiceObjectContainers::className(), ['service_id' => 'id']);
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
            $properties = $object->getProperties($object);
        }*/

        return $properties;
    }
}
