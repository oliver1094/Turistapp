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
    public function behaviors()
    {
        return [
        'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    
                    [
                        'allow' => true,
                        'actions' => ['index','view','update','delete','create'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?','admin'],
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
        if (!\Yii::$app->user->isGuest) {
            return $this->render('../site/index');
        }

        $model = new Catuser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionConfirm($id,$token){        

        $user = Catuser::findOne($id);

        if(Yii::$app->user->isGuest && !empty($user->vc_Token) && $token == $user->vc_Token )
        {
            //$user = Catuser::findOne($id);            
            //var_dump($user->i_isActive);            

            $user->i_isActive = 1;
            //$params = ['i_isActive'=>1];
            //$sql = $user->update('cat_user', ['i_isActive' => 0], 'i_Pk_User='.$id, $params);

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

    

    public function actionRegister()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->render('../site/index');
        }
            
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
}
