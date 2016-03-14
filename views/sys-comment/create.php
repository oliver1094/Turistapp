<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SysComment */

$this->title = 'Calificar plataforma';
$this->params['breadcrumbs'][] = ['label' => 'Sys Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userID' => $userID //Le paso al formulario el id del usuario logueado
    ]) ?>

</div>
