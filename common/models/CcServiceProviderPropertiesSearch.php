<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcServiceProviderProperties;

/**
 * CcServiceIndustryPropertiesSearch represents the model behind the search form about `common\models\CcServiceIndustryProperties`.
 */
class CcServiceProviderPropertiesSearch extends CcServiceProviderProperties
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'provider_property_id', 'input_type', 'value_min', 'value_max', 'display_order', 'multiple_values', 'specific_values', 'read_only', 'required'], 'integer'],
            [['value_default', 'pattern'], 'safe'],
            [['step'], 'number'],
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
        $query = CcServiceProviderProperties::find();

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
            'provider_property_id' => $this->provider_property_id,
            'input_type' => $this->input_type,
            'value_min' => $this->value_min,
            'value_max' => $this->value_max,
            'step' => $this->step,
            'display_order' => $this->display_order,
            'multiple_values' => $this->multiple_values,
            'specific_values' => $this->specific_values,
            'read_only' => $this->read_only,
            'required' => $this->required,
        ]);

        $query->andFilterWhere(['like', 'value_default', $this->value_default])
            ->andFilterWhere(['like', 'pattern', $this->pattern]);

        return $dataProvider;
    }
}
