<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $user_id
 * @property string $user_type_id
 * @property string $first_name
 * @property string $last_name
 * @property string $hash_password
 * @property string $email
 * @property string $phone
 * @property string $company_name
 *
 * @property Comments[] $comments
 * @property Events[] $events
 * @property Itinerario[] $itinerarios
 * @property UserType $userType
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
            [['user_type_id', 'first_name', 'last_name', 'hash_password', 'email'], 'required'],
            [['user_type_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 120],
            [['hash_password', 'email', 'company_name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['email'], 'email'],  
            [['phone'], 'integer']                      
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_type_id' => 'Tipo de usuario',
            'first_name' => 'Name',
            'last_name' => 'Apellido',
            'hash_password' => 'Contraseña',
            'email' => 'E-mail',
            'phone' => 'Teléfono',
            'company_name' => 'Nombre de compañía',
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
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItinerarios()
    {
        return $this->hasMany(Itinerario::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }
}
