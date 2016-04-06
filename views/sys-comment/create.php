<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SysComment */

$this->title = 'Calificar plataforma';
if(Yii::$app->user->can('admin')){
	$this->params['breadcrumbs'][] = ['label' => 'Sys Comments', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-comment-create animated fadeInDown">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userID' => $userID 
    ]) ?>

</div>
