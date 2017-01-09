<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property string $id
 * @property string $location_name
 * @property string $country
 * @property string $state
 * @property string $district
 * @property string $city
 * @property string $zip
 * @property string $mz
 * @property string $street
 * @property string $no
 * @property integer $floor
 * @property integer $apt
 * @property string $buzzer
 * @property string $lat
 * @property string $lng
 */
class Locations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zip', 'floor', 'apt'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['location_name'], 'string', 'max' => 128],
            [['country', 'state', 'district', 'city', 'mz', 'street'], 'string', 'max' => 64],
            [['no'], 'string', 'max' => 4],
            [['buzzer'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_name' => 'Location Name',
            'country' => 'Country',
            'state' => 'State',
            'district' => 'District',
            'city' => 'City',
            'zip' => 'Zip',
            'mz' => 'Mz',
            'street' => 'Street',
            'no' => 'No',
            'floor' => 'Floor',
            'apt' => 'Apt',
            'buzzer' => 'Buzzer',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }
}
