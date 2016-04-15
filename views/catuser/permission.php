<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Actualizar permisos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lista de usuarios'), 'url' => ['catuser/index']];
$this->params['breadcrumbs'][] = ['label' => $model->vc_FirstName, 'url' => ['catuser/view', 'id' => $model->i_Pk_User]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-update">

	<?php if (Yii::$app->session->hasFlash('samePermission')): ?>
    	<div class="alert alert-danger">
            El usuario ya cuenta con el permiso seleccionado, intente de nuevo
        </div>
	<?php endif ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formChangePermission', [
        'model' => $model,
        'modelAu' => $modelAu,
    ]) ?>

</div>