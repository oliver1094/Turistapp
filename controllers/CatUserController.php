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
                        'actions' => ['index','view','update','delete','create','update-pass'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?','admin'],
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
        //Nota de Javier: No sé que hace este código aquí, quitenlo si no lo usan.
        /*if (!\Yii::$app->user->isGuest) {
            return $this->render('../site/index');
        }*/

        $model = new Catuser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister()
    {
        //Nota de Javier: No sé que hace este código aquí, quitenlo si no lo usan.S
        /*if (!\Yii::$app->user->isGuest) {
            return $this->render('../site/index');
        }*/
            
            $model = new Catuser();
            $modelAu = new Au();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userid = $model->userlastid();
            $id = $userid;
            $modelAu->item_name = "turista";
            $modelAu->user_id = $id;
            
            if($modelAu->save()){
                return $this->redirect('../site/index');    
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

    public function actionUpdatePass($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Catuser::SCENARIO_PASSCHANGE;

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('password', [
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
