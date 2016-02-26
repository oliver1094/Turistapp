<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sys_comment".
 *
 * @property string $i_Pk_Score
 * @property string $i_Fk_User
 * @property integer $i_Score
 * @property string $vc_CommentSys
 *
 * @property CatUser $iFkUser
 */
class SysComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_Fk_User', 'i_Score','vc_CommentSys'], 'required'],
            [['i_Fk_User', 'i_Score'], 'integer'],
            [['vc_CommentSys'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_Score' => 'I  Pk  Score',
            'i_Fk_User' => 'I  Fk  User',
            'i_Score' => 'Score',
            'vc_CommentSys' => 'Comments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkUser()
    {
        return $this->hasOne(CatUser::className(), ['i_Pk_User' => 'i_Fk_User']);
    }
}
