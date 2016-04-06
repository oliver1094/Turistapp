<?php

namespace app\models;

use Yii;
use app\models\CatUser;

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

    public $commentsAll=null;
    public $score=null;
    public $idUserComment=null;
    public $cont=0;
    public $plus=0;
    public $media=0;
    public $firstName=null;

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
            [['i_FkTbl_Event', 'i_FkTbl_User', 'txt_EventComment', 'i_Score'], 'required', 'message' => 'Campo requerido'],
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
            'txt_EventComment' => ' Comentario Evento',
            'i_Score' => 'Score',
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

    /**
     * Gets the coments of the event
     * @param array $comments, $users
     */
    public function getComments($comments , $users){
        //Gets each comment and calculate the mean score
        foreach ($comments as $value) {
            $this->commentsAll[]=$value->txt_EventComment;
            $this->score[]=$value->i_Score;
            $plusStarts=$value->i_Score;
            $this->plus= $this->plus + $plusStarts;
            $this->cont=$this->cont + 1;
            $this->media=$this->plus/$this->cont;
            $this->idUserComment[]=$value->i_FkTbl_User;  
        }

        //Gets the names of the users that commented
        foreach ($users as $name) {
            $this->firstName[]=$name->vc_FirstName. " " . $name->vc_LastName ;   
        }
    }

}
