<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `common\models\Orders`.
 */
class OrdersSearch extends Orders
{ public $fullname;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by','created_at'], 'integer'],
            [['created_at'], 'string'],
            [['total_price'], 'number'],
            [['firstname', 'lastname','fullname','email', 'transaction_id', 'pappal_order_id', 'created_at'], 'safe'],
        ];
    }
    // public function attributes(){

    //     return array_merge(parent::attributes(),['fullname']);
    // }
public function fields(){
    return array_merge(parent::fields(),[
        'fullname'=>function(){

            return $this->firstname .''. $this->lastname;
        }


    ]);
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
        $query = Orders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        $dataProvider->sort->attributes['fullname'] = [
            'label' => 'Full Name',
            'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
            'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
        ];
        $this->load($params);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->fullname) {
            $query->andWhere("CONCAT(firstname, ' ', lastname) LIKE :fullname", ['fullname' => "%{$this->fullname}%"]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'pappal_order_id', $this->pappal_order_id]);

        return $dataProvider;
    }
}
