<?php

namespace app\controllers;

use Yii;
use app\models\CatEvent;
use app\models\CatEventSearch;
use app\models\CatUser;
use app\models\Itinerary;
use app\models\EvtMap;
use app\models\EvtComment;
use app\models\EvtImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CatEventController implements the CRUD actions for CatEvent model.
 */
class CatEventController extends Controller
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
                        'actions' => ['create', 'my-events','update','delete'],
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

    /**
     * Show the event of the user.
     * @return mixed
     */
    public function actionMyEvents()
    {
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
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
        $evtComments = new EvtComment();
        $images=null;
        if(!empty($model->evtImages)){
            foreach ($model->evtImages as $image) {
                $images[]= '<a href="../files/'.$image->vc_DirectoryName .'">
                    <img src="../files/' .$image->vc_DirectoryName .
                     '"/ width="512"  height="448" style="margin:auto; max-height: 448px; min-height: 448px; max-width: 512px;"></a>';
            }
        } 
        $evtComments->getComments($model->evtComments , $model->iFkTblUsers);
        return $this->render('view', [
            'model' => $model,
            'images'=> $images,
            'commentsAll'=>$evtComments->commentsAll,
            'score'=>$evtComments->score,
            'firstName'=>$evtComments->firstName,
            'idUserComment'=>$evtComments->idUserComment,
            'media'=>$evtComments->media
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
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->eventFile = UploadedFile::getInstances($model, 'eventFile');
            $this->uploadImages($model);
            return $this->redirect(['view', 'id' => $model->i_Pk_Event]);
        }
        return $this->render('create', [
            'model' => $model,
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
            $this->uploadImages($model);
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
        EvtImage::deleteImages($event->evtImages);
        $event->delete();
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

    /**
     * Makes sure that the user have the permition to do actions
     * if not then is redirected to the view of the event
     * that the user is the owner of the event.
     * @param string $id
     * @return mixed
     */
    public function allowed($id)
    {
        if ($this->permition($id)) {
                return true;
        } else {
            return $this->redirect(['cat-event/view', 'id' => $id]);
        }
    }

    /**
     * Finds the CatEvent model based on its primary key value and validates
     * that the user is the owner of the event.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return mixed
     */
    public function permition($id)
    {
        $event = CatEventController::findModel($id);
        if ($event->i_FkTbl_User == Yii::$app->user->getId() || Yii::$app->user->can('admin')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verify if there is images to upload and uploaded it
     * @param event $model
     */
    private function uploadImages($model)
    {
        if (!empty($model->eventFile)) {
            $model->upload();
        }
    }
}
