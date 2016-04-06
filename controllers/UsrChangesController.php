<?php

namespace app\controllers;

use Yii;
use app\models\Catuser;
use app\models\Au;
use app\controllers\UsrAuController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsrChangesController implements the actions of changes for Catuser model.
 */
class UsrChangesController extends Controller
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
                        'actions' => ['change-permission'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-pass'],
                        'roles' => ['@', 'admin'],
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
     * Update the password of a Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatePass($id)
    {
        $model = Catuser::findOne($id);
        $model->scenario = Catuser::SCENARIO_PASSCHANGE;
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendMailConfirmationPassChange($model);
            Yii::$app->session->setFlash('userUpdatePassSubmitted');
            return $this->redirect(['catuser/view', 'id' => $model->i_Pk_User]);
        } else {
            return $this->render('../catuser/password', ['model' => $model,]);
        }        
    }

     /**
     * Change the permissions of a Catuser model.
     * @param string $id
     * @return mixed
     */
    public function actionChangePermission($id)
    {
        $model = Catuser::findOne($id);
        $model->scenario = Catuser::SCENARIO_UPDATE;
        $modelAu = UsrAuController::findModelAu($id);        
        $modelAu->created_at = $model->vc_Email;
        $item_name = $modelAu->item_name;
        if ($modelAu->load(Yii::$app->request->post()) && $modelAu->item_name!==$item_name && $modelAu->save()) {
            $model = UsrAuController::changePermission($model, $modelAu->item_name);
            $model->save();
            return $this->redirect(['catuser/view', 'id' => $model->i_Pk_User]);
        } 
        if ($modelAu->item_name==$item_name && $modelAu->load(Yii::$app->request->post())) {  
            Yii::$app->session->setFlash('samePermission'); 
            return $this->render('../catuser/permission', [
                'modelAu' => $modelAu,
                'model' => $model,
            ]);
        }
        return $this->render('../catuser/permission', [
            'modelAu' => $modelAu,
            'model' => $model,
        ]);
    }

    /**
     * Sends an email confirming the change of the password
     * @param CatUser $model
     */
    private function sendMailConfirmationPassChange($model)
    {
        $subject = "Confirmación de cambio de contraseña";
        $body = "<p>Se ha cambiado de forma éxitosa su contraseña </p>".
        "<p>Si usted no ha realizado este cambio, pongase en contacto con nosotros en el siguiente enlace</p>".
        "<br><a href='http://localhost/Turistapp/web/site/contact'>Contacta con un administrador</a>";                            
        Yii::$app->mailer->compose()
            ->setTo($model->vc_Email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }

}