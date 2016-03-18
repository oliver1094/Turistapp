<?php

namespace app\controllers;

use Yii;
use app\models\Catuser;
use app\models\Au;
use app\models\CatuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatuserController implements the CRUD actions for Catuser model.
 */
class CatuserController extends Controller
{
    /**
     * behavoirs of the model.
     * @return mixed
     */
    public function behaviors()
    {
        return [
        'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    
                    [
                        'allow' => true,
                        'actions' => ['index','update','delete','create','update-pass','change-permission'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view','update','delete','update-pass'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?','admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@','admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm'],
                        'roles' => ['?'],
                    ],
                                        
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Catuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Catuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Catuser();
        $modelAu = new Au();
        $userid = Yii::$app->user->id;
        $userAdmin = $this->findModel($userid);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelAu->user_id = $model->i_Pk_User;            
            $modelAu->created_at = $userAdmin->vc_Email;
            switch ($model->i_Fk_UserType) {
                case 1:
                $modelAu->item_name = 'turista';
                if($modelAu->save()){
                    return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                }
                break;
                case 2:
                $modelAu->item_name = 'empresa';
                if($modelAu->save()){
                    return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                }
                break;
                case 3:
                $modelAu->item_name = 'admin';
                if($modelAu->save()){
                    return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                }
                break;
                
                default:
                    # code...
                    break;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Change a CatUser to active.
     * @param string $id, string $token
     * @return mixed
     */
    public function actionConfirm($id,$token){        

        $user = Catuser::findOne($id);

        if(Yii::$app->user->isGuest && !empty($user->vc_Token) && $token == $user->vc_Token )
        {
            $user->i_isActive = 1;
            if($user->update()){
                Yii::$app->session->setFlash('confirmUserRegister');
                return $this->render('confirmRegister');    
            }else{               
?> 
            <?= '<script> alert("Error al confirmar el registro")</script>' ?>

<?php   

            }        
        }
    }

    
    /**
     * Registration of a Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionRegister()
    {            
        $model = new Catuser();
        $modelAu = new Au();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userid = $model->userlastid();
            $id = $userid;
            $modelAu->item_name = "turista";
            $modelAu->user_id = $id;            
            if(Yii::$app->user->isGuest){
                            $idUser = urlencode($model->i_Pk_User);
                            $token = urlencode($model->vc_Token);                            
                            $subject = "Confirmar Registro";
                            $body = "<p>Gracias por registrarse en Turistapp, para acompletar su registro siga las siguientes instrucciones: </p>";                            
                            $body .= "<p>Haga click en el siguiente enlace para poder confirmar su registro en la plataforma Turistapp </p>";                               
                            $body .= "<br><a href='http://localhost/Turistapp/web/catuser/confirm?id=".$idUser."&token=".$token."'>Confirmar registro</a>";

                            //Enviamos el correo
                            Yii::$app->mailer->compose()
                             ->setTo($model->vc_Email)
                             ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                             ->setSubject($subject)
                             ->setHtmlBody($body)
                             ->send();
                        }
            if($modelAu->save()){
                Yii::$app->session->setFlash('userFormSubmitted');
                    return $this->refresh();                                        
            }
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Catuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Catuser::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('userUpdateSubmitted');
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('update', ['model' => $model,]);
        }
    }

    /**
     * Update the password of a Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatePass($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Catuser::SCENARIO_PASSCHANGE;
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendMailConfirmationPassChange($model);
            Yii::$app->session->setFlash('userUpdatePassSubmitted');
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('password', ['model' => $model,]);
        }        
    }

     /**
     * Change the permissions of a Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionChangePermission($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Catuser::SCENARIO_UPDATE;
        $modelAu = $this->findModelAu($id);        
        $modelAu->created_at = $model->vc_Email;
        $item_name = $modelAu->item_name;

        if ($modelAu->load(Yii::$app->request->post()) && $modelAu->item_name!==$item_name && $modelAu->save()) {
            
            switch ($modelAu->item_name) {
                case 'admin':
                    $model->i_Fk_UserType = 3;
                    if($model->update()){
                        return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                    }                    
                    break;
                case 'turista':
                    $model->i_Fk_UserType = 1;
                    if($model->update()){
                        return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                    }
                    break;
                case 'empresa':
                    $model->i_Fk_UserType = 2;
                    if($model->update()){
                        return $this->redirect(['view', 'id' => $model->i_Pk_User]);
                    }
                break;
                
                default:
                    
                    break;
            }
        } else {   
            if ($modelAu->item_name==$item_name && $modelAu->load(Yii::$app->request->post())) {
                ?> 
                <?= '<script> alert("El usuario ya cuenta con el permiso seleccionado, intente de nuevo")</script>' ?>
                <?php
                return $this->render('permission', [
                'modelAu' => $modelAu,
                'model' => $model,
            ]);
            } else {
                return $this->render('permission', [
                    'modelAu' => $modelAu,
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Catuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('userDeleteSubmitted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Catuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Catuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Au model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Au the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAu($id)
    {
        if (($model = Au::findone(['user_id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Sends an email confirming the change of the password
     * @param CatUser $model
     */
    private function sendMailConfirmationPassChange($model){
        $subject = "Confirmación de cambio de contraseña";
        $body = "<p>Se ha cambiado de forma éxitosa su contraseña </p>";                            
        $body .= "<p>Si usted no ha realizado este cambio, pongase en contacto con nosotros en el siguiente enlace</p>";                               
        $body .= "<br><a href='http://localhost/Turistapp/web/site/contact'>Contacta con un administrador</a>";
        Yii::$app->mailer->compose()
            ->setTo($model->vc_Email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }
}
