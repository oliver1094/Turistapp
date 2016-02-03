<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $hash_password
 * @property string $email
 *
 * @property Comments[] $comments
 * @property Itinerario[] $itinerarios
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'hash_password', 'email'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 120],
            [['hash_password', 'email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'hash_password' => 'Hash Password',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItinerarios()
    {
        return $this->hasMany(Itinerario::className(), ['user_id' => 'user_id']);
    }
}
