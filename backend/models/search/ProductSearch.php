<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductsBackend;
use yii\db\Query;

/**
 * ProductSearch represents the model behind the search form of `common\models\shop\Product`.
 */
class ProductSearch extends ProductsBackend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'category_id', 'label_id'], 'integer'],
            [['name', 'description', 'short_description', 'seo_title', 'seo_description'], 'safe'],
            [['price', 'old_price'], 'number'],
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
    public function search()
    {
        $request = Yii::$app->request;
        $params = $request->post();
        $paramsGrid = $request->get();
        $seoRules = Yii::$app->params['seoRules'];

        $query = ProductsBackend::find()
        ->orderBy(['date_public' => SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($params) {
            Yii::$app->session->set('product_search_params', $params);
        }

        $sessionParams = Yii::$app->session->get('product_search_params', []);
        if ($sessionParams) {
            $params = array_merge($params, $sessionParams);
        }
        if ($paramsGrid) {
            $params = array_merge($params, $paramsGrid);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'status_id' => $this->status_id,
            'category_id' => $this->category_id,
            'label_id' => $this->label_id,
            'brand_id' => $this->brand_id,
        ]);


        if (isset($params['minPrice'])) {
            $minPrice = $params['minPrice'];
        } else {
            $minPrice = Yii::$app->request->post('minPrice');
        }
        if (isset($params['maxPrice'])) {
            $maxPrice = $params['maxPrice'];
        } else {
            $maxPrice = Yii::$app->request->post('maxPrice');
        }

        $query->andFilterWhere(['>=', 'price', $minPrice])
            ->andFilterWhere(['<=', 'price', $maxPrice]);

        if (isset($params['category'])) {
            $query->andFilterWhere(['category_id' => $params['category']]);
        }

        if (isset($params['status'])) {
            $query->andFilterWhere(['status_id' => $params['status']]);
        }

        if (isset($params['brand'])) {
            $query->andFilterWhere(['brand_id' => $params['brand']]);
        }

        if (isset($params['labels'])) {
            $query->andFilterWhere(['label_id' => $params['labels']]);
        }

        if (isset($params['package'])) {
            $query->andFilterWhere(['package' => $params['package']]);
        }

        if (isset($params['date-update'])) {
            if ($params['date-update'] == 22) {
                $query->orderBy(['date_updated' => SORT_DESC]);
            } else {
                $query->orderBy(['date_updated' => SORT_ASC]);
            }
        }

        if (isset($params['filter-search']) && $params['filter-search'] != '') {
            $q = $params['filter-search'];
            $productId = (new Query())
                ->select('product_id')
                ->from('product_properties')
                ->where(['like', 'value', $q])
                ->union(
                    (new Query())
                        ->select('product_id')
                        ->from('product_properties_translate')
                        ->where(['like', 'value', $q])
                )
                ->column();

            if (!$productId) {
                Yii::$app->session->setFlash('warning', ' Запит "' . $q . '" не дав результатів!');
            }

            $query->andFilterWhere(['id' => $productId]);
        }

        if (isset($params['seo'])) {
            if ($params['seo'] == 'seo-title') {
                $query->andFilterWhere(['or',
                    ['<', 'CHAR_LENGTH(seo_title)', $seoRules['seo_title']['min']],
                    ['>', 'CHAR_LENGTH(seo_title)', $seoRules['seo_title']['max']]
                ]);
            }

            if ($params['seo'] == 'seo-description') {
                $query->andFilterWhere(['or',
                    ['<', 'CHAR_LENGTH(seo_description)', $seoRules['seo_description']['min']],
                    ['>', 'CHAR_LENGTH(seo_description)', $seoRules['seo_description']['max']]
                ]);
            }

            if ($params['seo'] == 'seo-h1') {
                $query->andFilterWhere(['or',
                    ['<', 'CHAR_LENGTH(h1)', $seoRules['seo_h1']['min']],
                    ['>', 'CHAR_LENGTH(h1)', $seoRules['seo_h1']['max']]
                ]);
            }

            if ($params['seo'] == 'non-h1') {
                $query->andWhere(['or',
                    ['is', 'h1', null],    // Проверка на NULL
                    ['=', 'h1', '']        // Проверка на пустую строку
                ]);
            }

            if ($params['seo'] == 'non-keyword') {
                $query->andWhere(['or',
                    ['is', 'keywords', null],    // Проверка на NULL
                    ['=', 'keywords', '']        // Проверка на пустую строку
                ]);
            }

            if ($params['seo'] == 'non-brand') {
                $query->andWhere(['or',
                    ['is', 'brand_id', null],
                ]);
            }

            if ($params['seo'] == 'non-h3') {
                $query->andWhere(['not like', 'description', '<h3>']);
            }

            if ($params['seo'] == 'product-description') {
                $query->andFilterWhere(['or',
                    ['<', 'CHAR_LENGTH(description)', 1000],
                ]);
            }

            if ($params['seo'] == 'product-short-description') {
                $query->andFilterWhere(['or',
                    ['<', 'CHAR_LENGTH(short_description)', 150],
                ]);
            }
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

        return $dataProvider;
    }
}
