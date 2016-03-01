<?php

namespace app\controllers;

use Yii;
use app\models\CatEvent;
use app\models\CatEventSearch;
use app\models\CatUser;
use app\models\Itinerary;
use app\models\EvtMap;
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
                        'actions' => ['create', 'my-events'],
                        'roles' => ['empresa','admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view'],
                        'roles' => ['turista','admin','empresa'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','delete'],
                        'roles' => ['admin','empresa'],
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
        $gps = new EvtMap();
        $model = $this->findModel($id);
        //Obtengo el id del usuario logueado y verifico que sea un turista (esto para que pueda agregar el evento al itinerario)
        $userID = CatUser::findOne(['i_Pk_User'=>Yii::$app->user->getId(), 'i_Fk_UserType'=>1])->i_Pk_User;
        //$gps = EvtMap::find()->where(['i_FkTbl_Event' => $model->i_Pk_Event])->one();

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
            'userID' => $userID
            //'gps' => $gps,
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
        $model = $this->findModel($id);
        $evtmap = new EvtMap();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
