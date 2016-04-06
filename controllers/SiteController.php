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

    /**
     * behavoirs of the model.
     * @return mixed
     */
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

    /**
     * Lists all CatEvent models.
     * @return mixed
     */
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

    /**
     * Lists important events.
     * @return mixed
     */
    public function actionIndex()
    {
        $mainEvents = EvtComment::find()->orderBy('i_Score DESC')->limit(10)->all();
        $arrayMainEvents=[];
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
            $arrayMainEvents[]=$model;
        }
        return $this->render('index',['arrayMainEvents'=>$arrayMainEvents]);
    }

    /**
     * Log in a user.
     * @return mixed
     */
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

    /**
     * Log out a user.
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * To send an email to de administrator.
     * @return mixed
     */
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

    /**
     * To see the about page.
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
