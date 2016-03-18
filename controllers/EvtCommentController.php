<?php

namespace app\controllers;

use Yii;
use app\models\CatUser;
use app\models\CatUserSearch;
use app\models\EvtComment;
use app\models\EvtCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CatEvent;
use app\models\CatEventSearch;

/**
 * EvtCommentController implements the CRUD actions for EvtComment model.
 */
class EvtCommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all EvtComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EvtCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EvtComment model.
     * @param string $i_FkTbl_Event
     * @param string $i_FkTbl_User
     * @return mixed
     */
    public function actionView($i_FkTbl_Event, $i_FkTbl_User)
    {
        return $this->render('view', [
            'model' => $this->findModel($i_FkTbl_Event, $i_FkTbl_User),
        ]);
    }

    /**
     * Creates a new EvtComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId()])->i_Pk_User;
        $model = new EvtComment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cat-event/view', 'id' => $model->i_FkTbl_Event]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'userID'=>$userID,
               'eventID'=>$eventID

            ]);
        }
    }

    /**
     * Updates an existing EvtComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $i_FkTbl_Event
     * @param string $i_FkTbl_User
     * @return mixed
     */
    public function actionUpdate($i_FkTbl_Event, $i_FkTbl_User)
    {
        $model = $this->findModel($i_FkTbl_Event, $i_FkTbl_User);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'i_FkTbl_Event' => $model->i_FkTbl_Event, 'i_FkTbl_User' => $model->i_FkTbl_User]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EvtComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $i_FkTbl_Event
     * @param string $i_FkTbl_User
     * @return mixed
     */
    public function actionDelete($i_FkTbl_Event, $i_FkTbl_User)
    {
        $this->findModel($i_FkTbl_Event, $i_FkTbl_User)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EvtComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $i_FkTbl_Event
     * @param string $i_FkTbl_User
     * @return EvtComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($i_FkTbl_Event, $i_FkTbl_User)
    {
        if (($model = EvtComment::findOne(['i_FkTbl_Event' => $i_FkTbl_Event, 'i_FkTbl_User' => $i_FkTbl_User])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
