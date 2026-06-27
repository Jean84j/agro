<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SiteErrors;

/**
 * SearchSiteErrors represents the model behind the search form of `common\models\SiteErrors`.
 */
class SiteErrorsSearch extends SiteErrors
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ip_user', 'url_page', 'user_agent', 'client_from', 'date_visit', 'status_serv', 'other'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = SiteErrors::find()->orderBy('date_visit DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ip_user', $this->ip_user])
            ->andFilterWhere(['like', 'url_page', $this->url_page])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'client_from', $this->client_from])
            ->andFilterWhere(['like', 'date_visit', $this->date_visit])
            ->andFilterWhere(['like', 'status_serv', $this->status_serv])
            ->andFilterWhere(['like', 'other', $this->other]);

        return $dataProvider;
    }
}
