<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EvtComment */

$this->title = 'Create Evt Comment';
$this->params['breadcrumbs'][] = ['label' => 'Evt Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
       'userID' => $userID,
    	'eventID'=>$eventID
    ]) ?>

</div>
