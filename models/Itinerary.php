<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "usr_itinerary".
 *
 * @property string $i_FkTbl_User
 * @property string $i_FkTbl_Event
 *
 * @property CatUser $iFkTblUser
 * @property CatEvent $iFkTblEvent
 */
class Itinerary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usr_itinerary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_FkTbl_User', 'i_FkTbl_Event'], 'integer']
        ];
    }


    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_FkTbl_User' => 'ID Usuario',
            'i_FkTbl_Event' => 'ID Evento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblUser()
    {
        return $this->hasOne(CatUser::className(), ['i_Pk_User' => 'i_FkTbl_User']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblEvent()
    {
        return $this->hasOne(CatEvent::className(), ['i_Pk_Event' => 'i_FkTbl_Event']);
    }
}
