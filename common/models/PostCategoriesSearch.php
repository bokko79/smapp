<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PostCategories;

/**
 * PostCategoriesSearch represents the model behind the search form about `common\models\PostCategories`.
 */
class PostCategoriesSearch extends PostCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_id', 'category_id'], 'integer'],
            [['category'], 'safe'],
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
        $query = PostCategories::find();

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
            'post_id' => $this->post_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}
