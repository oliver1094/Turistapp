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
 *
 * @property CatEvent $iFkTblEvent
 */
class EvtMap extends \yii\db\ActiveRecord
{
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
            [['i_FkTbl_Event'], 'required'],
            [['i_FkTbl_Event'], 'integer'],
            [['vc_Latitude', 'vc_Longitude'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_Map' => 'I  Pk  Map',
            'i_FkTbl_Event' => 'I  Fk Tbl  Event',
            'vc_Latitude' => 'Vc  Latitude',
            'vc_Longitude' => 'Vc  Longitude',
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
