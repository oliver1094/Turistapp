<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EvtComment;
use app\models\CatEvent;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //$prueba='1';
        //$mainEvents = EvtComment::findAll(['i_Score'=>7]);
        $mainEvents = EvtComment::find()->orderBy('i_Score DESC')->limit(10)->all();
        $arrayMainEvents=[];
        
        //Prueba donde obtuve las 10 mejores eventos calificados
//        foreach ($mainEvents as $event){
//            $model = new EvtComment();
//            $model->i_FkTbl_Event = $event->i_FkTbl_Event;
//            //echo '<script language="javascript">alert("'.$event->i_Score.'");</script>'; 
//            $model->i_FkTbl_User = $event->i_FkTbl_User;
//            $model->txt_EventComment = $event->txt_EventComment;
//            $model->i_Score = $event->i_Score;
//            $arrayMainEvents[]=$model;
//        }
        //Ahora la información completa de los eventos
         foreach ($mainEvents as $event){
            $model = new CatEvent();
            $model->i_Pk_Event = CatEvent::findOne($event->i_FkTbl_Event)->i_Pk_Event;
            $model->i_FkTbl_User = CatEvent::findOne($event->i_FkTbl_Event)->i_FkTbl_User;
            $model->vc_EventName = CatEvent::findOne($event->i_FkTbl_Event)->vc_EventName;
            $model->tx_DescriptionEvent = CatEvent::findOne($event->i_FkTbl_Event)->tx_DescriptionEvent;
            $model->vc_EventAddress = CatEvent::findOne($event->i_FkTbl_Event)->vc_EventAddress;
            $model->vc_EventCity = CatEvent::findOne($event->i_FkTbl_Event)->vc_EventCity;
            $model->dt_EventStart = CatEvent::findOne($event->i_FkTbl_Event)->dt_EventStart;
            $model->dt_EventEnd = CatEvent::findOne($event->i_FkTbl_Event)->dt_EventEnd;
            $model->dc_EventCost = CatEvent::findOne($event->i_FkTbl_Event)->dc_EventCost;
            $model->dc_TransportCost = CatEvent::findOne($event->i_FkTbl_Event)->dc_TransportCost;
            //echo '<script language="javascript">alert("'.$event->i_Score.'");</script>'; 
            $arrayMainEvents[]=$model;
        }
        
        return $this->render('index',[
            //'mainEvents'=>$mainEvents,
            //'prueba'=>$prueba,
            'arrayMainEvents'=>$arrayMainEvents
        ]);
       
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact($model->email)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
