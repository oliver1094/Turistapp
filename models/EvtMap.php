<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evt_map".
 *
 * @property string $i_Pk_Map
 * @property string $i_FkTbl_Event
 * @property string $vc_Latitude
 * @property string $vc_Longitude
 * @property string $vc_EventTag
 * @property string $vc_TransportTag
 * @property string $vc_LatitudeTransport
 * @property string $vc_LongitudeTransport
 *
 * @property CatEvent $iFkTblEvent
 */
class EvtMap extends \yii\db\ActiveRecord
{

    public $searchbox;
    public $searchboxTransport;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evt_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_FkTbl_Event', 'vc_EventTag','vc_Latitude', 'vc_Longitude'], 'required', 'message' => 'Campo requerido'],
            [['i_FkTbl_Event'], 'integer'],
            [['vc_Latitude', 'vc_Longitude'], 'string', 'max' => 40],
            [['vc_EventTag', 'vc_TransportTag', 'vc_LatitudeTransport', 'vc_LongitudeTransport'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_Map' => Yii::t('app', 'I  Pk  Map'),
            'i_FkTbl_Event' => Yii::t('app', 'I  Fk Tbl  Event'),
            'vc_Latitude' => Yii::t('app', 'Vc  Latitude'),
            'vc_Longitude' => Yii::t('app', 'Vc  Longitude'),
            'vc_EventTag' => Yii::t('app', 'Event Tag'),
            'vc_TransportTag' => Yii::t('app', 'Transport Tag'),
            'vc_LatitudeTransport' => Yii::t('app', 'Vc  Latitude Transport'),
            'vc_LongitudeTransport' => Yii::t('app', 'Vc  Longitude Transport'),
            'searchbox' => Yii::t('app', 'Place'),
            'searchboxTransport' => Yii::t('app', 'Transport'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFkTblEvent()
    {
        return $this->hasOne(CatEvent::className(), ['i_Pk_Event' => 'i_FkTbl_Event']);
    }
}
