<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Follower;

/**
 * FollowerSearch represents the model behind the search form of `app\models\Follower`.
 */
class FollowerSearch extends Follower
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['follower_id', 'user_id', 'user_id_following'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Follower::find();

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
            'follower_id' => $this->follower_id,
            'user_id' => $this->user_id,
            'user_id_following' => $this->user_id_following,
        ]);

        return $dataProvider;
    }
}
