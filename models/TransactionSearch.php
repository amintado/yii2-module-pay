<?php

namespace amintado\pay\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amintado\pay\models\Transaction;

/**
 * amintado\pay\models\TransactionSearch represents the model behind the search form about `amintado\pay\models\Transaction`.
 */
 class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'invoice', 'lock', 'created_by', 'updated_by', 'deleted_by', 'restored_by'], 'integer'],
            [['date', 'description', 'UUID', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
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
    public function search($uid)
    {
        $query = Transaction::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        $this->load($params);
        $query->where(['uid'=>$uid]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'date' => $this->date,
            'price' => $this->price,
            'invoice' => $this->invoice,
            'lock' => $this->lock,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'restored_by' => $this->restored_by,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'UUID', $this->UUID]);

        return $dataProvider;
    }


     /**
      * Creates data provider instance with search query applied
      *
      * @param array $params
      *
      * @return ActiveDataProvider
      */
     public function searchMy($params)
     {
         $query = Transaction::find();

         $dataProvider = new ActiveDataProvider([
             'query' => $query,
         ]);

         $this->load($params);
         $query->where(['uid'=>Yii::$app->user->id]);
         if (!$this->validate()) {
             // uncomment the following line if you do not want to return any records when validation fails
             // $query->where('0=1');
             return $dataProvider;
         }

         $query->andFilterWhere([
             'id' => $this->id,
             'uid' => $this->uid,
             'date' => $this->date,
             'price' => $this->price,
             'invoice' => $this->invoice,
             'lock' => $this->lock,
             'created_at' => $this->created_at,
             'updated_at' => $this->updated_at,
             'created_by' => $this->created_by,
             'updated_by' => $this->updated_by,
             'deleted_by' => $this->deleted_by,
             'restored_by' => $this->restored_by,
         ]);

         $query->andFilterWhere(['like', 'description', $this->description])
             ->andFilterWhere(['like', 'UUID', $this->UUID]);

         return $dataProvider;
     }
}
