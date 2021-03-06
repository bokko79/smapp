<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcServiceActionPropertyValues;

/**
 * CcServiceActionPropertyValuesSearch represents the model behind the search form about `common\models\CcServiceActionPropertyValues`.
 */
class CcServiceActionPropertyValuesSearch extends CcServiceActionPropertyValues
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_action_property_id', 'action_property_value_id'], 'integer'],
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
        $query = CcServiceActionPropertyValues::find();

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
            'service_action_property_id' => $this->service_action_property_id,
            'action_property_value_id' => $this->action_property_value_id,
        ]);

        return $dataProvider;
    }
}
