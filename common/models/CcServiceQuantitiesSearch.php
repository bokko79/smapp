<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcServiceQuantities;

/**
 * CcServiceQuantitiesSearch represents the model behind the search form about `common\models\CcServiceQuantities`.
 */
class CcServiceQuantitiesSearch extends CcServiceQuantities
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'amount_default', 'amount_min', 'amount_max', 'consumer_default', 'consumer_min', 'consumer_max'], 'integer'],
            [['amount_step', 'consumer_step'], 'number'],
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
        $query = CcServiceQuantities::find();

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
            'service_id' => $this->service_id,
            'amount_default' => $this->amount_default,
            'amount_min' => $this->amount_min,
            'amount_max' => $this->amount_max,
            'amount_step' => $this->amount_step,
            'consumer_default' => $this->consumer_default,
            'consumer_min' => $this->consumer_min,
            'consumer_max' => $this->consumer_max,
            'consumer_step' => $this->consumer_step,
        ]);

        return $dataProvider;
    }
}
