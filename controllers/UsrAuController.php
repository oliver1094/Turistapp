<?php

namespace app\controllers;

use Yii;
use app\models\Catuser;
use app\models\Au;
use app\models\CatuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsrAuController for Au model.
 */
class UsrAuController 
{
	/**
     * Creates a new Au model.
     * @return Au model
     */
	public function create($model){
		$modelAu = new Au();
		$modelAu->user_id = $model->i_Pk_User;            
        if ($model->i_Fk_UserType == 1) {
        	$modelAu->item_name = 'turista';
        }
        if ($model->i_Fk_UserType == 2) {
        	$modelAu->item_name = 'empresa';
        }
        if ($model->i_Fk_UserType == 3) {
        	$modelAu->item_name = 'admin';
        }
        return $modelAu;
	}

	/**
     * Register a new Au model.
     * @return Au model
     */
	public function register($model)
	{
		$modelAu = new Au();
        $modelAu->item_name = "turista";
        $modelAu->user_id = $model->userlastid();          
        $modelAu->created_at = $model->vc_Email;

        $idUser = urlencode($model->i_Pk_User);
        $token = urlencode($model->vc_Token);                            
        $subject = "Confirmar Registro";
        $body = "<p>Gracias por registrarse en Turistapp, para acompletar su registro siga las siguientes instrucciones: </p>";  
        $body .= "<p>Haga click en el siguiente enlace para poder confirmar su registro en la plataforma Turistapp </p>";
        $body .= "<br><a href='http://localhost/Turistapp/web/catuser/confirm?id=".$idUser."&token=".$token."'>Confirmar registro</a>";

        Yii::$app->mailer->compose()
        	->setTo($model->vc_Email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send(); 

        return $modelAu;                 
	}


	 /**
     * Change the permissions of a Catuser model.
     * @param string $id
     * @return mixed
     */
	public function changePermission($model, $item_name)
    {   
        switch ($item_name) {
            case 'admin':
                $model->i_Fk_UserType = 3;                
            break;
            case 'turista':
                $model->i_Fk_UserType = 1;
                break;
            case 'empresa':
                $model->i_Fk_UserType = 2;
            break;
        }
        return $model; 
    }

	/**
     * Finds the Au model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Au the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModelAu($id)
    {
        if (($model = Au::findone(['user_id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
