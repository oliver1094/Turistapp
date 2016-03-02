<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use app\models\EvtImage;

/**
 * This is the model class for table "cat_event".
 *
 * @property string $i_Pk_Event
 * @property string $i_FkTbl_User
 * @property string $vc_EventName
 * @property string $tx_DescriptionEvent
 * @property string $vc_EventAddress
 * @property string $vc_EventCity
 * @property string $dt_EventStart
 * @property string $dt_EventEnd
 * @property string $dc_EventCost
 * @property string $dc_TransportCost
 *
 * @property CatUser $iFkTblUser
 * @property EvtComment[] $evtComments
 * @property CatUser[] $iFkTblUsers
 * @property EvtImage[] $evtImages
 * @property EvtMap[] $evtMaps
 * @property UsrItinerary[] $usrItineraries
 * @property CatUser[] $iFkTblUsers0
 */
class CatEvent extends \yii\db\ActiveRecord
{

    public $eventFile;
    public $fileNameAttached;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'vc_EventName','tx_DescriptionEvent', 'vc_EventAddress', 'vc_EventCity', 'dt_EventStart', 'dt_EventEnd', 'dc_EventCost'], 'required'],
            [['i_FkTbl_User'], 'integer'],
            ['vc_EventName', 'match', 'pattern' => "/^[0-9A-Záéíóúñ” “]+$/i", 'message' => 'Sólo se aceptan letras y números'],
            [['vc_EventAddress','tx_DescriptionEvent'],'match', 'pattern' => "/^[0-9A-Záéíóúñ#” “]+$/i", 'message' => 'Sólo se aceptan letras y números'],
            [['dt_EventStart', 'dt_EventEnd'], 'safe'],        
            [['dc_EventCost', 'dc_TransportCost'], 'number'],
            [['vc_EventName', 'fileNameAttached'], 'string', 'max' => 120],            
            [['vc_EventAddress', 'vc_EventCity'], 'string', 'max' => 150],
            [['tx_DescriptionEvent'], 'string'],
            [['vc_EventCity'], 'match', 'pattern' => '/^[a-zA-Záéíóúñ” “]+$/', 'message' => 'Sólo se aceptan letras'],
            [['eventFile'], 'file', 'skipOnEmpty' => true, 'extensions'=>'png,jpg,jpeg,bmp', 'maxFiles' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_Event' => 'id evento',
            'i_FkTbl_User' => 'id Usuario',
            'vc_EventName' => 'Nombre de evento',
            'tx_DescriptionEvent' => 'Descripción del evento',
            'vc_EventAddress' => 'Dirección de evento',
            'vc_EventCity' => 'Ciudad',
            'dt_EventStart' => 'Fecha de inicio',
            'dt_EventEnd' => 'Fecha de finalización',
            'dc_EventCost' => 'Costo de evento',
            'dc_TransportCost' => 'Costo de transporte',
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
    public function getEvtComments()
    {
        return $this->hasMany(EvtComment::className(), ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblUsers()
    {
        return $this->hasMany(CatUser::className(), ['i_Pk_User' => 'i_FkTbl_User'])->viaTable('evt_comment', ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvtImages()
    {
        return $this->hasMany(EvtImage::className(), ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvtMaps()
    {
        return $this->hasMany(EvtMap::className(), ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsrItineraries()
    {
        return $this->hasMany(UsrItinerary::className(), ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblUsers0()
    {
        return $this->hasMany(CatUser::className(), ['i_Pk_User' => 'i_FkTbl_User'])->viaTable('usr_itinerary', ['i_FkTbl_Event' => 'i_Pk_Event']);
    }

    public function beforeSave($insert)
    {
         if(parent::beforeSave($insert)) {
             $user = CatUser::findOne(\Yii::$app->user->identity->id);
             $this->i_FkTbl_User = $user->id;
             return true;
         }
         return false;
     }

    public function upload(){
        foreach ($this->eventFile as $file){
            $this->fileNameAttached = uniqid() . '.' . $file->extension;
            FileHelper::createDirectory ( 'files/', $mode = 509, $recursive = false );
            $file->saveAs('files/'.$this->fileNameAttached);
            $evtImages = new EvtImage();
            $evtImages->i_FkTbl_Event = $this->i_Pk_Event;
            $evtImages->vc_DirectoryName = $this->fileNameAttached;
            $evtImages->save();
        }
    }
 
}