<?php

namespace app\controllers;

use Yii;
use app\models\EvtMap;
use app\models\EvtMapSearch;
use app\models\CatEvent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EvtMapController implements the CRUD actions for EvtMap model.
 */
class EvtMapController extends Controller
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
                        'actions' => ['update','delete','create'],
                        'roles' => ['admin', 'empresa'],
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
     * Lists all EvtMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EvtMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EvtMap model.
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
     * Creates a new EvtMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new EvtMap();
        $model->i_FkTbl_Event = $id;
        $this->allowed($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cat-event/view', 'id' => $id]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing EvtMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->allowed($model->i_FkTbl_Event);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cat-event/view', 'id' => $model->i_FkTbl_Event]);
        } else {
            return $this->render('update', ['model' => $model,]);
        }
    }

    /**
     * Deletes an existing EvtMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idEvent = $this->findModel($id)->i_FkTbl_Event;
        $this->allowed($idEvent);
        $this->findModel($id)->delete();
        return $this->redirect(['cat-event/view', 'id' => $idEvent]);
    }

    /**
     * Finds the EvtMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EvtMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EvtMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the CatEvent model based on its primary key value and validates
     * that the user is the owner of the event.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function allowed($id){
        $event = CatEvent::findOne($id);
        if ($event == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($event->i_FkTbl_User == Yii::$app->user->getId() || Yii::$app->user->can('admin')) {
                return true;
        } else {
            return $this->redirect(['cat-event/view', 'id' => $id]);
        }
    }
}

