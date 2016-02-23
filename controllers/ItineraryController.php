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
                        'roles' => ['admin','turista'],
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
        
        //Obtengo el id del usuario logueado y verifico que sea un turista
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;
        // Obtengo los eventos del turista logueado de la tabla itinerary
        $events = Itinerary::find()->where(['i_FkTbl_User'=> $userID])->all();
       
        
        $tasks = [];
        foreach ($events as $eve){    
            $event = new \yii2fullcalendar\models\Event();
            $event->id = CatEvent::findOne($eve->i_FkTbl_Event)->i_Pk_Event;
            $event->title = CatEvent::findOne($eve->i_FkTbl_Event)->vc_EventName;
            $event->start = CatEvent::findOne($eve->i_FkTbl_Event)->dt_EventStart;
            //$event->end = CatEvent::findOne($eve->i_FkTbl_Event)->dt_EventEnd;
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
    public function actionCreate()
    {
        $model = new Itinerary();
        
        //Para que me muestre todos lo eventos registrados en el sistema
        $searchModel = new CatEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //Obtengo el id del usuario logueado y verifico que sea un turista
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;
        try{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'searchModel' => $searchModel, //Datos para mostrar todos los eventos registrados
                    'dataProvider' => $dataProvider, //Datos para mostrar todos los eventos registrados
                    'userID'=>$userID //Paso el Id del usuario logueado
                ]);
            }
        }  catch (\yii\db\IntegrityException $integrityException){
        ?> 
            <?= '<script> alert("You already have this event")</script>' ?>
        <?php
            return $this->render('create', [
                    'model' => $model,
                    'searchModel' => $searchModel, //Datos para mostrar todos los eventos registrados
                    'dataProvider' => $dataProvider, //Datos para mostrar todos los eventos registrados
                    'userID'=>$userID //Paso el Id del usuario logueado
                    
                ]);
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
        
        //Obtengo el id del usuario logueado y veirifco que sea un turista
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'userID'=>$userID //Paso el id del usuario logueado para que pueda realizar los cambios
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