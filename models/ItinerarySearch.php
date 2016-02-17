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
        //Obtengo el id del usuario logueado y verifico que sea un turista
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;
        // Obtengo los eventos del turista logueado de la tabla itinerary
        //$query = Itinerary::find()->where(['i_FkTbl_User'=> $userID]);
        $query = Itinerary::find()->where(['i_FkTbl_User'=> $userID]);
        
        
        //$query = Itinerary::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //$query->andFilterWhere([
        //    'i_FkTbl_User' => $this->i_FkTbl_User,
        //    'i_FkTbl_Event' => $this->i_FkTbl_Event,    
        //]);
        
        
        return $dataProvider;
    }
}
