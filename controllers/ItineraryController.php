<?php

namespace app\controllers;

use Yii;
use app\models\Itinerary;
use app\models\CatEvent;
use app\models\CatUser;
use app\models\CatEventSearch;
use app\models\ItinerarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ItineraryController implements the CRUD actions for Itinerary model.
 */
class ItineraryController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [   
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','delete'],
                        'roles' => ['turista'],
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
     * Lists all Itinerary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItinerarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $events = Itinerary::find()->where(['i_FkTbl_User'=> Yii::$app->user->getId()])->all();
        $tasks = [];
        
        foreach ($events as $eve){    
            $event = new \yii2fullcalendar\models\Event();
            $event->title = CatEvent::findOne($eve->i_FkTbl_Event)->vc_EventName;
            $event->start = CatEvent::findOne($eve->i_FkTbl_Event)->dt_EventStart;
            $event->url  = Url::to(['cat-event/view','id'=> CatEvent::findOne($eve->i_FkTbl_Event)->i_Pk_Event]);
            $tasks[] = $event;
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events'=>$tasks,
        ]);
    }

     
    
    /**
     * Displays a single Itinerary model.
     * @param string $i_FkTbl_User
     * @param string $i_FkTbl_Event
     * @return mixed
     */
    public function actionView($i_FkTbl_User, $i_FkTbl_Event)
    {
        return $this->render('view', [
            'model' => $this->findModel($i_FkTbl_User, $i_FkTbl_Event),
        ]);
    }

    /**
     * Creates a new Itinerary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Itinerary();
        $idUser = Yii::$app->user->getId();//CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId()])->i_Pk_User;
        $model->i_FkTbl_User = $idUser;
        $model->i_FkTbl_Event = $id;
        if (Itinerary::findOne(['i_FkTbl_User' => $idUser, 'i_FkTbl_Event' => $id])=== null) {
            if ($model->save()) {
                Yii::$app->session->setFlash('eventAdded');
                return $this->redirect(['cat-event/view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('eventNotAdded');
            return $this->redirect(['cat-event/view', 'id' => $id]);
        }
    }

    /**
     * Updates an existing Itinerary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $i_FkTbl_User
     * @param string $i_FkTbl_Event
     * @return mixed
     */
    public function actionUpdate($i_FkTbl_User, $i_FkTbl_Event)
    {
        $model = $this->findModel($i_FkTbl_User, $i_FkTbl_Event);
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'userID'=>$userID
            ]);
        }
    }

    /**
     * Deletes an existing Itinerary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $i_FkTbl_User
     * @param string $i_FkTbl_Event
     * @return mixed
     */
    public function actionDelete($i_FkTbl_User, $i_FkTbl_Event)
    {
        $this->findModel($i_FkTbl_User, $i_FkTbl_Event)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Itinerary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $i_FkTbl_User
     * @param string $i_FkTbl_Event
     * @return Itinerary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($i_FkTbl_User, $i_FkTbl_Event)
    {
        if (($model = Itinerary::findOne(['i_FkTbl_User' => $i_FkTbl_User, 'i_FkTbl_Event' => $i_FkTbl_Event])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
?>