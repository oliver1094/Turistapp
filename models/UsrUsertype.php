<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usr_usertype".
 *
 * @property string $i_Pk_UserType
 * @property string $vc_NameUserType
 *
 * @property CatUser[] $catUsers
 */
class UsrUsertype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usr_usertype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vc_NameUserType'], 'required'],
            [['vc_NameUserType'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_UserType' => 'I  Pk  User Type',
            'vc_NameUserType' => 'Vc  Name User Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatUsers()
    {
        return $this->hasMany(CatUser::className(), ['i_Fk_UserType' => 'i_Pk_UserType']);
    }
}
