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
    public $vc_NewPass;
    public $vc_RepeatPass;
    public $vc_ActualPass;

    const SCENARIO_PASSCHANGE = 'passchange';
    const SCENARIO_UPDATE = 'update';

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PASSCHANGE] = ['vc_ActualPass', 'vc_NewPass', 'vc_RepeatPass'];
        $scenarios[self::SCENARIO_UPDATE] = ['vc_FirstName','vc_LastName','vc_Email','vc_Phone','vc_CompanyName'];
        return $scenarios;
    }

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
            [['vc_FirstName', 'vc_LastName', 'vc_HashPassword', 'vc_Email','i_Fk_UserType'], 'required', 'message' => 'Campo requerido'],
            [['vc_FirstName', 'vc_LastName', 'vc_Email'], 'required', 'on' => self::SCENARIO_UPDATE , 'message' => 'Campo requerido'],
            [['vc_NewPass', 'vc_RepeatPass', 'vc_ActualPass'], 'required', 'on' => self::SCENARIO_PASSCHANGE , 'message' => 'Campo requerido'],
            [['i_Fk_UserType'], 'integer'],
            [['i_Fk_UserType','i_isActive'], 'integer'],
            [['vc_FirstName', 'vc_LastName'], 'string', 'max' => 120],
            [['vc_FirstName', 'vc_LastName'], 'match', 'pattern' => '/^[a-zA-Záéíóú” “]+$/', 'message' => 'No se aceptan números o simbolos'],
            [['vc_HashPassword', 'vc_Email', 'vc_CompanyName'], 'string', 'max' => 100],
            [['vc_HashPassword'], 'string', 'min'=>6 ,'max' => 25],
            [['vc_NewPass'], 'string', 'min'=>6,'max' => 25, 'on' => self::SCENARIO_PASSCHANGE ],
            ['vc_ActualPass','findPasswords', 'on' => self::SCENARIO_PASSCHANGE ],
            ['vc_RepeatPass','compare','compareAttribute'=>'vc_NewPass', 'on' => self::SCENARIO_PASSCHANGE ],
            [['vc_Email'], 'unique', 'message' => 'Este correo ya está en uso'],
            [['vc_Email'], 'email', 'message' => 'Correo invalido'],  
            ['vc_Email', 'filter', 'filter' => 'trim'],
            [['vc_Phone'], 'string', 'min'=>10,'max' => 10],
            [['vc_Phone'], 'integer', 'message' => 'Teléfono invalido: sólo se aceptan números'],
            [['vc_Token'], 'string', 'max' => 150],
            ['repeatpass','compare','compareAttribute'=>'vc_HashPassword', 'message' => 'La contraseña no coincide'] 
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
            'repeatpass' => 'Confirmar contraseña',
            'vc_NewPass' => 'Nueva contraseña',
            'vc_RepeatPass' => 'Repetir nueva contraseña',
            'vc_ActualPass' => 'Contraseña actual',
        ];
    }

    /**
     * Makes relations with tables of user model
     * @param string $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if (Yii::$app->user->isGuest) {
                $this->i_Fk_UserType = 1;
            }    
            if ($this->isNewRecord) {
                if (Yii::$app->user->can('admin')) {
                    $this->i_isActive = 1;    
                    $this->vc_HashPassword = Yii::$app->getSecurity()->generatePasswordHash($this->vc_HashPassword);                    
                } else {  
                    $this->i_Fk_UserType = 1;
                    $this->i_isActive = 0;
                    $this->vc_Token = Yii::$app->getSecurity()->generateRandomString();
                    $this->vc_HashPassword = Yii::$app->getSecurity()->generatePasswordHash($this->vc_HashPassword);                    
                }
            } elseif (!empty($this->vc_NewPass)) {
                $this->vc_HashPassword = Yii::$app->getSecurity()->generatePasswordHash($this->vc_NewPass);              
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

    /**
     * @return string
     */
    public function getAuthKey() {
        return $this->vc_HashPassword;   
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->i_Pk_User;
    }

    /**
     * @return boolean
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
        
    }

    /**
     * @return CatUser
     */
    public static function findIdentity($id) {
        return self::findOne($id);
    }

    /**
     * @param string $token, $type
     * @return mixed
     */
    public static function findIdentityByAccessToken($token, $type = null) 
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function userlastid()
    {
        $lastUsurio = self::find()    
        ->orderBy('i_Pk_User Desc')
        ->one();
        $id = $lastUsurio->i_Pk_User;
        return $id;
    }

    /**
     * @param string $email
     * @return string
     */
    public static function findByEmail($email){
        return self::findOne(['vc_Email'=>$email,'i_isActive' => 1]);
    }
    
    /**
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password,$this->vc_HashPassword);
    }
    
    /**
     * @param string $attribute, $params
     */
    public function findPasswords($attribute, $params)
    {
        $actualPass = self::findOne(['i_Pk_User'=>Yii::$app->user->getId()])->vc_HashPassword;
        $matchPass = Yii::$app->getSecurity()->validatePassword($this->vc_ActualPass, $actualPass);
        if (!$matchPass) {
            $this->addError($attribute,'La contraseña actual es incorrecta');
        }
    }
}
