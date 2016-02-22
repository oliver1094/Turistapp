<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SysComment;

/**
 * SysCommentSearch represents the model behind the search form about `app\models\SysComment`.
 */
class SysCommentSearch extends SysComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_Pk_Score', 'i_Fk_User', 'i_Score'], 'integer'],
            [['vc_CommentSys'], 'safe'],
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
        $query = SysComment::find();

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
            'i_Pk_Score' => $this->i_Pk_Score,
            'i_Fk_User' => $this->i_Fk_User,
            'i_Score' => $this->i_Score,
        ]);

        $query->andFilterWhere(['like', 'vc_CommentSys', $this->vc_CommentSys]);

        return $dataProvider;
    }
}
