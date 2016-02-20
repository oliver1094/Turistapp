<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EvtMap;

/**
 * EvtMapSearch represents the model behind the search form about `app\models\EvtMap`.
 */
class EvtMapSearch extends EvtMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_Pk_Map', 'i_FkTbl_Event'], 'integer'],
            [['vc_Latitude', 'vc_Longitude', 'vc_EventTag', 'vc_TransportTag', 'vc_LatitudeTransport', 'vc_LongitudeTransport'], 'safe'],
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
        $query = EvtMap::find();

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
            'i_Pk_Map' => $this->i_Pk_Map,
            'i_FkTbl_Event' => $this->i_FkTbl_Event,
        ]);

        $query->andFilterWhere(['like', 'vc_Latitude', $this->vc_Latitude])
            ->andFilterWhere(['like', 'vc_Longitude', $this->vc_Longitude])
            ->andFilterWhere(['like', 'vc_EventTag', $this->vc_EventTag])
            ->andFilterWhere(['like', 'vc_TransportTag', $this->vc_TransportTag])
            ->andFilterWhere(['like', 'vc_LatitudeTransport', $this->vc_LatitudeTransport])
            ->andFilterWhere(['like', 'vc_LongitudeTransport', $this->vc_LongitudeTransport]);

        return $dataProvider;
    }
}
