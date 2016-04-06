<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Itinerary */

$this->title = 'Update Itinerary: ' . ' ' . $model->i_FkTbl_User;
$this->params['breadcrumbs'][] = ['label' => 'Itineraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_FkTbl_User, 'url' => ['view', 'i_FkTbl_User' => $model->i_FkTbl_User, 'i_FkTbl_Event' => $model->i_FkTbl_Event]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="itinerary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userID'=>$userID 
    ]) ?>

</div>
