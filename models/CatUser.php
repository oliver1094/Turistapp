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
class Catuser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['vc_FirstName', 'vc_LastName'], 'match', 'pattern' => '/^[a-zA-Záéíóú” “]+$/'],
            [['vc_HashPassword', 'vc_Email', 'vc_CompanyName'], 'string', 'max' => 100],
            [['vc_HashPassword'], 'string', 'min'=>6,'max' => 25],
            [['vc_Email'], 'unique'],
            [['vc_Email'], 'email'],  
            ['vc_Email', 'filter', 'filter' => 'trim'],
            [['vc_Phone'], 'string', 'min'=>10,'max' => 10],
            [['vc_Phone'], 'integer']  
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_Pk_User' => 'id Usuario',
            'i_Fk_UserType' => 'Tipo de usuario',
            'vc_FirstName' => 'Nombre',
            'vc_LastName' => 'Apellido',
            'vc_HashPassword' => 'Contraseña',
            'vc_Email' => 'E-mail',
            'vc_Phone' => 'Teléfono',
            'vc_CompanyName' => 'Nombre de compañía',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
                $this->vc_HashPassword = Yii::$app->getSecurity()->generatePasswordHash($this->vc_HashPassword);
                //$this->auth_key = Yii::$app->getSecurity()->generatePasswordHash($this->hash_password);
                //$this->access_token = Yii::$app->getSecurity()->generateRandomString();
            }
            else
            {
                if(!empty($this->vc_HashPassword))
                {
                    $this->vc_HashPassword = Yii::$app->getSecurity()->generatePasswordHash($this->vc_HashPassword);
                }
            }
            return true;
        }
        return false;
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

    //metodos de la interfaz idenity
    public function getAuthKey() {
        
    }

    public function getId() {
        
    }

    public function validateAuthKey($authKey) {
        
    }

    public static function findIdentity($id) {
        
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }
    //fin metodos de la interfaz identity
    
    //--------Estos dos metodos utilice para el Login (ElÃ­as)---------
    
     public static function findByEmail($email){
        return self::findOne(['vc_Email'=>$email]);
    }
    
    public function validatePassword($password){
        //return $this->hash_password ===$password;
        return Yii::$app->getSecurity()->validatePassword($password,$this->vc_HashPassword);
    }
    
    //---------------


}
