<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Cambio de contraseña de: '. ' ' . $model->vc_FirstName . ' ' . $model->vc_LastName) ;
if(Yii::$app->user->can('admin')){
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lista de usuarios'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = ['label' => $model->vc_FirstName, 'url' => ['view', 'id' => $model->i_Pk_User]];
$this->params['breadcrumbs'][] = 'Cambiar contraseña';
?>
<div class="catuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formChangePass', [
        'model' => $model,
    ]) ?>

</div>
