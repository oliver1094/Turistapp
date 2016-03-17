<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Actualizar permisos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lista de usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vc_FirstName, 'url' => ['view', 'id' => $model->i_Pk_User]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formChangePermission', [
        'model' => $model,
        'modelAu' => $modelAu,
    ]) ?>

</div>