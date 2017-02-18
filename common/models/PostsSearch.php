<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `common\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'file_id', 'parent_id', 'comment_status', 'next_post', 'time', 'update_time'], 'integer'],
            [['lang_code', 'title', 'subtitle', 'content', 'excerpt', 'type', 'status'], 'safe'],
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
        $query = Posts::find();

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
            'profile_id' => $this->profile_id,
            'file_id' => $this->file_id,
            'parent_id' => $this->parent_id,
            'comment_status' => $this->comment_status,
            'next_post' => $this->next_post,
            'time' => $this->time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'lang_code', $this->lang_code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'excerpt', $this->excerpt])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
