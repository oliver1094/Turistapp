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
 * @property integer $i_isActive 
 * @property string $vc_Token 
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

    public $repeatpass;
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
            [['vc_FirstName', 'vc_LastName', 'vc_HashPassword', 'vc_Email'], 'required', 'message' => 'Campo requerido'],
            [['i_Fk_UserType','i_isActive'], 'integer'],
            [['vc_FirstName', 'vc_LastName'], 'string', 'max' => 120],
            [['vc_FirstName', 'vc_LastName'], 'match', 'pattern' => '/^[a-zA-Záéíóú” “]+$/'],
            [['vc_HashPassword', 'vc_Email', 'vc_CompanyName'], 'string', 'max' => 100],
            [['vc_HashPassword'], 'string', 'min'=>6],
            [['vc_Email'], 'unique'],
            [['vc_Email'], 'email'],  
            ['vc_Email', 'filter', 'filter' => 'trim'],
            [['vc_Phone'], 'string', 'min'=>10,'max' => 10],
            [['vc_Phone'], 'integer'],
            [['vc_Token'], 'string', 'max' => 150],
            ['repeatpass','compare','compareAttribute'=>'vc_HashPassword'] 
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
            'i_isActive' => 'Perfil activo',
            'vc_Token' => 'Token usuario',
            'repeatpass' => 'Confirmar contraseña'
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {

            if($this->isNewRecord)
            {
                

                $this->i_Fk_UserType = 1;
                $this->i_isActive = 0;
                $this->vc_Token = Yii::$app->getSecurity()->generateRandomString();
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
        return $this->vc_HashPassword;   
    }

    public function getId() {
        return $this->i_Pk_User;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
        
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {

        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
        
    }

    public function userlastid(){

        $lastUsurio = self::find()    
    ->orderBy('i_Pk_User Desc')
    ->one();
    $id = $lastUsurio->i_Pk_User;
        return $id;

    }




  //  SELECT TOP 1 *
//FROM Pedido
//ORDER BY Fecha DESC
    //fin metodos de la interfaz identity
    
    //--------Estos dos metodos utilice para el Login (ElÃ­as)---------
    
     public static function findByEmail($email){
        return self::findOne(['vc_Email'=>$email,'i_isActive' => 1]);
        
    }
    
    public function validatePassword($password){
        //return $this->hash_password ===$password;
        return Yii::$app->getSecurity()->validatePassword($password,$this->vc_HashPassword);
    }
    
    //---------------


}
