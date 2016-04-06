<?php

namespace app\controllers;

use Yii;
use app\models\Catuser;
use app\models\Au;
use app\models\CatuserSearch;
use app\controllers\UsrAuController;
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
                        'actions' => ['index','create'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view','update','delete'],
                        'roles' => ['@','admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register', 'confirm' ],
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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelAu= UsrAuController::create($model);
            $modelAu->save();
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('create', ['model' => $model,]);
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
            $modelAu= UsrAuController::register($model);
            $modelAu->save();
            Yii::$app->session->setFlash('userFormSubmitted');
            return $this->refresh();                                        
        } else {
            return $this->render('register', ['model' => $model,]);
        }
    }

     /**
     * Change a CatUser to active.
     * @param string $id, string $token
     * @return mixed
     */
    public function actionConfirm($id,$token)
    {        
        $user = Catuser::findOne($id);
        $user->scenario = Catuser::SCENARIO_UPDATE;
        $user->i_isActive = 1;
        if (Yii::$app->user->isGuest && !empty($user->vc_Token) && $token == $user->vc_Token && $user->save()) {
            Yii::$app->session->setFlash('confirmUserRegister');
            return $this->render('confirmRegister');    
        } else {               
            return $this->render('confirmRegister');
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

}
