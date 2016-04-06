<?php

namespace app\controllers;

use Yii;
use app\models\CatEvent;
use app\models\CatUser;
use app\models\Itinerary;
use app\models\EvtComment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EvtReportController implements the actions for the report of CatEvent model.
 */
class EvtReportController extends Controller
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
                        'actions' => ['report'],
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
     * Show the report for the events of the user.
     * @return mixed
     */
    public function actionReport(){
        $model = new CatEvent();
        $events = CatEvent::find()->where(['i_FkTbl_User'=> Yii::$app->user->getId()])->all();
        $namesEvents='';
        $scoresEvents='';
        $numberOfTourist='';
        $namesEventsArray=[];
        $earnings=[];
        $totalEarnings=0;
        
        foreach($events as $element ){
            $namesEvents .= "'". $element->vc_EventName . "',";
            $namesEventsArray[] = $element->vc_EventName;
            
            if (EvtComment::findOne(['i_FkTbl_Event'=>$element->i_Pk_Event])) {
                $scoresEvents .= EvtComment::findOne(['i_FkTbl_Event'=>$element->i_Pk_Event])->i_Score . ',';
            } else {
                $scoresEvents .= '0,';
            }
            $earnings []= count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) * $element->dc_EventCost;
            $totalEarnings += count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) * $element->dc_EventCost;
            $numberOfTourist .= count(Itinerary::find()->where(['i_FkTbl_Event'=> $element->i_Pk_Event])->all()) .',';
        }
        return $this->render('../cat-event/report', [
            'namesEventsArray' => $namesEventsArray,
            'earnings' => $earnings,
            'totalEarnings' => $totalEarnings,
            'namesEvents' => $namesEvents,
            'scoresEvents' => $scoresEvents,
            'numberOfTourist' => $numberOfTourist
        ]);
    }

}