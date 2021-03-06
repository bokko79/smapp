<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcServiceObjectProperties;

/**
 * CcServiceObjectPropertiesSearch represents the model behind the search form about `common\models\CcServiceObjectProperties`.
 */
class CcServiceObjectPropertiesSearch extends CcServiceObjectProperties
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'object_property_id', 'unit_id', 'unit_imperial_id', 'required', 'read_only', 'property_type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CcServiceObjectProperties::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'object_property_id' => $this->object_property_id,
            'unit_id' => $this->unit_id,
            'unit_imperial_id' => $this->unit_imperial_id,
            'property_type' => $this->property_type,
            'required' => $this->required,
            'read_only' => $this->read_only,
        ]);

        return $dataProvider;
    }
}
