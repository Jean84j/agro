<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Report;
use yii\db\Expression;

/**
 * ReportSearch represents the model behind the search form of `common\models\Report`.
 */
class ReportSearch extends Report
{
    public $products_order;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products_order'], 'safe'],
            [['id', 'price_delivery'], 'integer'],
            [['order_status_id', 'order_pay_ment_id', 'platform', 'number_order', 'date_order', 'date_delivery', 'number_order_1c', 'date_payment', 'type_payment', 'fio', 'tel_number', 'address', 'comments', 'delivery_service', 'ttn'], 'safe'],
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

        $query = Report::find()
            ->joinWith('reportItems')
            ->groupBy('report.id') // важно!
            ->orderBy(['date_order' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'price_delivery' => $this->price_delivery,
            'order_status_id' => $this->order_status_id,
            'order_pay_ment_id' => $this->order_pay_ment_id,
        ]);

        $query->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'number_order', $this->number_order])
            ->andFilterWhere(['like', 'date_order', $this->date_order])
            ->andFilterWhere(['like', 'number_order_1c', $this->number_order_1c])
            ->andFilterWhere(['like', 'type_payment', $this->type_payment])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'tel_number', $this->tel_number])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'delivery_service', $this->delivery_service])
            ->andFilterWhere(['like', 'ttn', $this->ttn])
            ->andFilterWhere(['like', 'report_item.product_name', $this->products_order]);

        $this->filterDateField($query, 'date_delivery', $this->date_delivery);
        $this->filterDateField($query, 'date_payment', $this->date_payment);


        return $dataProvider;
    }

    protected function filterDateField($query, $attribute, $value)
    {
        if (empty($value)) {
            return;
        }

        if (preg_match('/^(\d{2})-(\d{2})$/', $value, $matches)) {
            $formattedDate = date('Y') . "-{$matches[2]}-{$matches[1]}";
            $query->andFilterWhere(['like', $attribute, $formattedDate]);

        } elseif (preg_match('/^(\d{2})-(\d{4})$/', $value, $matches)) {
            $formattedDate = "{$matches[2]}-{$matches[1]}";
            $query->andWhere([
                'like',
                new Expression("DATE_FORMAT($attribute, '%Y-%m')"),
                $formattedDate
            ]);

        } else {
            $query->andFilterWhere(['like', $attribute, $value]);
        }
    }

}
