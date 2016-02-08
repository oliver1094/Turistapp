<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_user".
 *
 * @property string $i_Pk_User
 * @property string $i_Fk_UserType
 * @property string $vc_FirstName
 * @property string $vc_LastName
 * @property string $vc_HashPassword
 * @property string $vc_Email
 * @property string $vc_Phone
 * @property string $vc_CompanyName
 *
 * @property CatEvent[] $catEvents
 * @property UsrUsertype $iFkUserType
 * @property EvtComment[] $evtComments
 * @property CatEvent[] $iFkTblEvents
 * @property UsrItinerary[] $usrItineraries
 * @property CatEvent[] $iFkTblEvents0
 */
class CatUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_Fk_UserType', 'vc_FirstName', 'vc_LastName', 'vc_HashPassword', 'vc_Email'], 'required'],
            [['i_Fk_UserType'], 'integer'],
            [['vc_FirstName', 'vc_LastName'], 'string', 'max' => 120],
            [['vc_HashPassword', 'vc_Email', 'vc_CompanyName'], 'string', 'max' => 100],
            [['vc_Phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_User' => 'I  Pk  User',
            'i_Fk_UserType' => 'I  Fk  User Type',
            'vc_FirstName' => 'Vc  First Name',
            'vc_LastName' => 'Vc  Last Name',
            'vc_HashPassword' => 'Vc  Hash Password',
            'vc_Email' => 'Vc  Email',
            'vc_Phone' => 'Vc  Phone',
            'vc_CompanyName' => 'Vc  Company Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatEvents()
    {
        return $this->hasMany(CatEvent::className(), ['i_FkTbl_User' => 'i_Pk_User']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkUserType()
    {
        return $this->hasOne(UsrUsertype::className(), ['i_Pk_UserType' => 'i_Fk_UserType']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvtComments()
    {
        return $this->hasMany(EvtComment::className(), ['i_FkTbl_User' => 'i_Pk_User']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblEvents()
    {
        return $this->hasMany(CatEvent::className(), ['i_Pk_Event' => 'i_FkTbl_Event'])->viaTable('evt_comment', ['i_FkTbl_User' => 'i_Pk_User']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsrItineraries()
    {
        return $this->hasMany(UsrItinerary::className(), ['i_FkTbl_User' => 'i_Pk_User']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblEvents0()
    {
        return $this->hasMany(CatEvent::className(), ['i_Pk_Event' => 'i_FkTbl_Event'])->viaTable('usr_itinerary', ['i_FkTbl_User' => 'i_Pk_User']);
    }
}
