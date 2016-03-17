<?php

namespace app\controllers;

use Yii;
use app\models\CatEvent;
use app\models\CatEventSearch;
use app\models\CatUser;
use app\models\Itinerary;
use app\models\EvtMap;
use app\models\EvtComment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CatEventController implements the CRUD actions for CatEvent model.
 */
class CatEventController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'my-events','update','delete','report'],
                        'roles' => ['empresa','admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view'],
                        'roles' => ['turista','admin','empresa','@','?'],
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
     * Lists all CatEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionMyEvents()
    {
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
        
        //Ver solo los eventos del Organizador
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId()])->i_Pk_User;
        $queryParams["CatEventSearch"]["i_FkTbl_User"] = $userID;
        $searchModel = new CatEventSearch();
        $dataProvider = $searchModel->search($queryParams);
        
        return $this->render('my-events', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatEvent model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $itinerary=new Itinerary();
        $model = $this->findModel($id);
        //Obtengo el id del usuario logueado y verifico que sea un turista (esto para que pueda agregar el evento al itinerario)
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;
        $images=null;
        if(!empty($model->evtImages)){
            foreach ($model->evtImages as $image) {
                $images[]= '<a href="../files/'.$image->vc_DirectoryName .'">
                    <img src="../files/' .$image->vc_DirectoryName . '"/ width="560"  height="445" style="margin:auto; max-height: 445px"></a>';
            }
        }
        

        try{
            if($itinerary->load(Yii::$app->request->post()) && $itinerary->save()){
?> 
<?= '<script> alert("Event added to itinerary")</script>'?>
<?php    
            }
        }catch (\yii\db\IntegrityException $integrityException){
?> 
<?= '<script> alert("You already have this event")</script>' ?>
<?php       
        }
        
        return $this->render('view', [
            'model' => $model,
            'userID' => $userID,
            'images'=> $images
        ]);
    }

    /**
     * Creates a new CatEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatEvent();
        $evtmap = new EvtMap();
        if ($model->load(Yii::$app->request->post())) {
            $model->eventFile = UploadedFile::getInstances($model, 'eventFile');
            $valid = true;
            $valid = $valid && $model->validate();
            if ($valid) {
                $model->save(false);
                if ($valid && !empty($model->eventFile)) {
                        $model->upload();
                }

                if ($evtmap->load(Yii::$app->request->post()) && !empty($evtmap->vc_Latitude)) {
                    $evtmap->i_FkTbl_Event = $model->i_Pk_Event;
                    $evtmap->save();
                    Yii::$app->session->setFlash('eventFormSubmitted');
                    return $this->refresh();
                }
            }
            return $this->redirect(['view', 'id' => $model->i_Pk_Event]);
        }

        return $this->render('create', [
            'model' => $model,
            'evtmap' => $evtmap,
        ]);
        
    }

    /**
     * Updates an existing CatEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->allowed($id);
        $model = $this->findModel($id);
        $evtmap = new EvtMap();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->eventFile = UploadedFile::getInstances($model, 'eventFile');
            if (!empty($model->eventFile)) {
                $model->upload();
            }
            Yii::$app->session->setFlash('eventFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
                'evtmap' => $evtmap,
            ]);
        }
    }

    /**
     * Deletes an existing CatEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->allowed($id);
        $event= $this->findModel($id);
        if (!empty($event->evtImages)) {
            foreach ($event->evtImages as $image) {
                unlink(getcwd().'/files/' .$image->vc_DirectoryName);
            }
        }
        $event->delete();
        return $this->redirect(['index']);
    }

    public function actionReport(){
        $model = new CatEvent();
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId()])->i_Pk_User; 
        $events = CatEvent::find()->where(['i_FkTbl_User'=> $userID])->all();
        $namesEvents='';
        $scoresEvents='';
        $numberOfTourist='';
        $namesEventsArray=[];
        $earnings=[];
        $totalEarnings=0;
        
        foreach($events as $element ){
            
            if(!$element->vc_EventName==null || $element->vc_EventName==''){
                $namesEvents .= "'". $element->vc_EventName . "',";
                $namesEventsArray[] = $element->vc_EventName;
            }else{
                $namesEvents .= 'Evento sin nombre,';
                $namesEventsArray[] = 'Evento sin nombre';
            }
            
            if(EvtComment::findOne(['i_FkTbl_Event'=>$element->i_Pk_Event])){
                $scoresEvents .= EvtComment::findOne(['i_FkTbl_Event'=>$element->i_Pk_Event])->i_Score . ',';
            }else{
                $scoresEvents .= '0,';
            }
      
            $earnings []= count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) * $element->dc_EventCost;
            $totalEarnings += count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) * $element->dc_EventCost;
            $numberOfTourist .= count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) .',';
           
        }
        
        return $this->render('report', [
            'namesEventsArray' => $namesEventsArray,
            'earnings' => $earnings,
            'totalEarnings' => $totalEarnings,
            'namesEvents' => $namesEvents,
            'scoresEvents' => $scoresEvents,
            'numberOfTourist' => $numberOfTourist
        ]);
        
    }
    
    
    /**
     * Finds the CatEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CatEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatEvent::findOne($id)) !== null) {
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
    public function allowed($id){
        $event = CatEventController::findModel($id);
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
