<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evt_comment".
 *
 * @property string $i_FkTbl_Event
 * @property string $i_FkTbl_User
 * @property string $txt_EventComment
 * @property string $i_Score
 *
 * @property CatEvent $iFkTblEvent
 * @property CatUser $iFkTblUser
 */
class EvtComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evt_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_FkTbl_Event', 'i_FkTbl_User', 'txt_EventComment', 'i_Score'], 'required'],
            [['i_FkTbl_Event', 'i_FkTbl_User', 'i_Score'], 'integer'],
            [['txt_EventComment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_FkTbl_Event' => 'I  Fk Tbl  Event',
            'i_FkTbl_User' => 'I  Fk Tbl  User',
            'txt_EventComment' => ' Event Comment',
            'i_Score' => 'I  Score',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblEvent()
    {
        return $this->hasOne(CatEvent::className(), ['i_Pk_Event' => 'i_FkTbl_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblUser()
    {
        return $this->hasOne(CatUser::className(), ['i_Pk_User' => 'i_FkTbl_User']);
    }
}
