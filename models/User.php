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
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'user_type_id' => Yii::t('app', 'User Type ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'hash_password' => Yii::t('app', 'Hash Password'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'company_name' => Yii::t('app', 'Company Name'),
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

    public function getAuthKey() {
        
    }

    public function getId() {
        return $this-> user_id;
    }

    public function validateAuthKey($authKey) {
       
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException();
    }

    public static function findByEmail($email){
        return self::findOne(['email'=>$email]);
    }
    
    public function validatePassword($password){
        return $this->hash_password ===$password;
    }
}
