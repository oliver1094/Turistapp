<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evt_image".
 *
 * @property string $i_Pk_Image
 * @property string $i_FkTbl_Event
 * @property string $vc_DirectoryName
 *
 * @property CatEvent $iFkTblEvent
 */
class EvtImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evt_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['i_FkTbl_Event', 'vc_DirectoryName'], 'required'],
            [['i_FkTbl_Event'], 'integer'],
            [['vc_DirectoryName'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_Image' => Yii::t('app', 'I  Pk  Image'),
            'i_FkTbl_Event' => Yii::t('app', 'I  Fk Tbl  Event'),
            'vc_DirectoryName' => Yii::t('app', 'Vc  Directory Name'),
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
