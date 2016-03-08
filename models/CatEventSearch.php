<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatEvent;

/**
 * CatEventSearch represents the model behind the search form about `app\models\CatEvent`.
 */
class CatEventSearch extends CatEvent
{
    /**
     * @inheritdoc
     */

    public $vc_NameUser;
    public function rules()
    {
        return [
            [['i_Pk_Event', 'i_FkTbl_User'], 'integer'],
            [['vc_EventName', 'tx_DescriptionEvent','vc_EventAddress', 'vc_EventCity', 'dt_EventStart', 'dt_EventEnd','vc_NameUser'], 'safe'],
            [['dc_EventCost', 'dc_TransportCost'], 'number'],
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
        $query = CatEvent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['iFkTblUser']);

        $dataProvider->sort->attributes['vc_NameUser'] = [
            'asc' => ['cat_user.vc_FirstName' => SORT_ASC],
            'desc' => ['cat_user.vc_FirstName' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'i_Pk_Event' => $this->i_Pk_Event,
            'i_FkTbl_User' => $this->i_FkTbl_User,           
            'dt_EventStart' => $this->dt_EventStart,
            'dt_EventEnd' => $this->dt_EventEnd,
            'dc_EventCost' => $this->dc_EventCost,
            'dc_TransportCost' => $this->dc_TransportCost,
        ]);

        $query->andFilterWhere(['like', 'vc_EventName', $this->vc_EventName])
            ->andFilterWhere(['like', 'tx_DescriptionEvent', $this->tx_DescriptionEvent])
            ->andFilterWhere(['like', 'cat_user.vc_FirstName', $this->vc_NameUser])
            ->andFilterWhere(['like', 'vc_EventAddress', $this->vc_EventAddress])
            ->andFilterWhere(['like', 'vc_EventCity', $this->vc_EventCity]);

        return $dataProvider;
    }
}
