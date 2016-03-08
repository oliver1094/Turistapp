<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catuser;

/**
 * CatuserSearch represents the model behind the search form about `app\models\Catuser`.
 */
class CatuserSearch extends Catuser
{
    /**
     * @inheritdoc
     */
    public $vc_NameUserType;
    public function rules()
    {
        return [
            [['i_Pk_User', 'i_Fk_UserType'], 'integer'],
            [['vc_FirstName', 'vc_LastName', 'vc_HashPassword', 'vc_Email', 'vc_Phone', 'vc_CompanyName','vc_NameUserType'], 'safe'],
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
        $query = Catuser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['iFkUserType']);

        $dataProvider->sort->attributes['vc_NameUserType'] = [
            'asc' => ['usr_usertype.vc_NameUserType' => SORT_ASC],
            'desc' => ['usr_usertype.vc_NameUserType' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'i_Pk_User' => $this->i_Pk_User            

        ]);

        $query->andFilterWhere(['like', 'vc_FirstName', $this->vc_FirstName])
            ->andFilterWhere(['like', 'vc_LastName', $this->vc_LastName])
            ->andFilterWhere(['like', 'vc_HashPassword', $this->vc_HashPassword])
            ->andFilterWhere(['like', 'vc_Email', $this->vc_Email])
            ->andFilterWhere(['like', 'vc_Phone', $this->vc_Phone])
            ->andFilterWhere(['like', 'usr_usertype.vc_NameUserType', $this->vc_NameUserType])
            ->andFilterWhere(['like', 'vc_CompanyName', $this->vc_CompanyName]);

        return $dataProvider;
    }
}
