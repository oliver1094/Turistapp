<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Itinerary;
use app\models\CatEvent;

/**
 * ItinerarySearch represents the model behind the search form about `app\models\Itinerary`.
 */
class ItinerarySearch extends Itinerary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_FkTbl_User', 'i_FkTbl_Event'], 'integer'],
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
        $query = Itinerary::find()->where(['i_FkTbl_User'=> Yii::$app->user->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }    
        return $dataProvider;
    }
}
