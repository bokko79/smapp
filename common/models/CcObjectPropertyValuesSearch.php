<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcObjectPropertyValues;

/**
 * CcObjectPropertyValuesSearch represents the model behind the search form about `common\models\CcObjectPropertyValues`.
 */
class CcObjectPropertyValuesSearch extends CcObjectPropertyValues
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'object_property_id', 'property_value_id', 'object_id', 'file_id', 'selected_value', 'countable_value', 'default_part_no'], 'integer'],
            [['value_type', 'value_class'], 'safe'],
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
        $query = CcObjectPropertyValues::find();

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
            'object_property_id' => $this->object_property_id,
            'property_value_id' => $this->property_value_id,
            'object_id' => $this->object_id,
            'file_id' => $this->file_id,
            'selected_value' => $this->selected_value,
            'countable_value' => $this->countable_value,
            'default_part_no' => $this->default_part_no,
        ]);

        $query->andFilterWhere(['like', 'value_type', $this->value_type]);
        $query->andFilterWhere(['like', 'value_class', $this->value_class]);

        return $dataProvider;
    }
}
