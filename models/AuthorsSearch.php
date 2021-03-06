<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Authors;

/**
 * AuthorsSearch represents the model behind the search form about `app\models\Authors`.
 */
class AuthorsSearch extends Authors
{
    public $fullName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname'], 'safe'],
            [['fullName'], 'safe']
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
    /*public function search($params)
    {
        $query = Authors::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname]);

        return $dataProvider;
    }*/

    public function search($params)
    {
        $query = Authors::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullName' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
                'firstname',
                'lastname'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'firstname', $this->firstname]);
        $query->andFilterWhere(['like', 'lastname', $this->lastname]);

        /* Настроим правила фильтрации */

        // фильтр по имени
        $query->andWhere('firstname LIKE "%' . $this->fullName . '%" ' .
            'OR lastname LIKE "%' . $this->fullName . '%"'
        );

        return $dataProvider;
    }
}
