<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EvtImage;

/**
 * EvtImageSearch represents the model behind the search form about `app\models\EvtImage`.
 */
class EvtImageSearch extends EvtImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_Pk_Image', 'i_FkTbl_Event'], 'integer'],
            [['vc_DirectoryName'], 'safe'],
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
        $query = EvtImage::find();

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
            'i_Pk_Image' => $this->i_Pk_Image,
            'i_FkTbl_Event' => $this->i_FkTbl_Event,
        ]);

        $query->andFilterWhere(['like', 'vc_DirectoryName', $this->vc_DirectoryName]);

        return $dataProvider;
    }
}
