<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcServices;

/**
 * CcServicesSearch represents the model behind the search form about `common\models\CcServices`.
 */
class CcServicesSearch extends CcServices
{
    public $tag_id;
    public $product_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'industry_id', 'action_id', 'object_id', 'unit_id', 'file_id', 'service_type', 'file', 'amount', 'consumer', 'consumer_children', 'location', 'coverage', 'shipping', 'geospecific', 'time', 'duration', 'frequency', 'availability', 'installation', 'tools', 'turn_key', 'support', 'ordering', 'pricing', 'terms', 'labour_type', 'process', 'hit_counter'], 'integer'],
            [['name', 'industry_class', 'object_class', 'object_ownership', 'dat', 'status'], 'safe'],
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
        $query = CcServices::find();

        //$query->joinWith(['t t']);
        //$query->joinWith(['object', 'products']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 2,
            ],
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
            'industry_id' => $this->industry_id,
            'action_id' => $this->action_id,
            'object_id' => $this->object_id,
            'unit_id' => $this->unit_id,
            'file_id' => $this->file_id,
            'service_type' => $this->service_type,
            'file' => $this->file,
            'amount' => $this->amount,
            'consumer' => $this->consumer,
            'consumer_children' => $this->consumer_children,
            'location' => $this->location,
            'coverage' => $this->coverage,
            'shipping' => $this->shipping,
            'geospecific' => $this->geospecific,
            'time' => $this->time,
            'duration' => $this->duration,
            'frequency' => $this->frequency,
            'availability' => $this->availability,
            'installation' => $this->installation,
            'tools' => $this->tools,
            'turn_key' => $this->turn_key,
            'support' => $this->support,
            'ordering' => $this->ordering,
            'pricing' => $this->pricing,
            'terms' => $this->terms,
            'labour_type' => $this->labour_type,
            'process' => $this->process,
            'hit_counter' => $this->hit_counter,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'object_class', $this->object_class])
            ->andFilterWhere(['like', 'object_ownership', $this->object_ownership])
            ->andFilterWhere(['like', 'dat', $this->dat])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
