<?php

namespace app\controllers;

use Yii;
use app\models\EvtImage;
use app\models\EvtImageSearch;
use app\models\CatEvent;
use app\controllers\CatEventController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EvtImageController implements the CRUD actions for EvtImage model.
 */
class EvtImageController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'delete', 'delete-all'],
                        'roles' => ['empresa','admin'],
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
     * Lists all EvtImage models.
     * @return mixed
     */
    public function actionIndex($id)
    {   
        CatEventController::allowed($id);     
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
        $eventID = CatEvent::findOne(['i_Pk_Event'=>$id])->i_Pk_Event;
        $queryParams["EvtImageSearch"]["i_FkTbl_Event"] = $eventID;
        $searchModel = new EvtImageSearch();
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'eventID' => $eventID,
        ]);
    }

    /**
     * Displays a single EvtImage model.
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
     * Creates a new EvtImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EvtImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_Image]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EvtImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        CatEventController::allowed($model->i_FkTbl_Event);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->i_Pk_Image]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EvtImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $image = $this->findModel($id);
        $eventID = $image->i_FkTbl_Event;
        CatEventController::allowed($eventID);
        unlink(getcwd().'/files/' .$image->vc_DirectoryName);
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'id' => $eventID]);
    }

    public function actionDeleteAll($id){
        CatEventController::allowed($id);
        $images = EvtImage::findAll(['i_FkTbl_Event'=>$id]);
        foreach ($images as $image) {
            unlink(getcwd().'/files/' .$image->vc_DirectoryName);
            $image->delete();
        }

        return $this->redirect(['cat-event/view', 'id' => $id]);
    }

    /**
     * Finds the EvtImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EvtImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EvtImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
