<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UsrUsertype;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="confirmRegister">
	<?php if (Yii::$app->session->hasFlash('confirmUserRegister')): ?>
		<div class="alert alert-success">
            Gracias por registrarse en Turistapp, se ha completado su registro y ya puede entrar al sistema con su correo y contraseña.
        </div>

	<?php endif ?>

</div>