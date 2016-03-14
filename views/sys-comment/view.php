<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SysComment */

?>
<div class="sys-comment-view">

    <br><br>
    <div class="alert alert-success">
           Gracias por tu calificación
    </div>
 
    <?= Html::a('Volver al inicio', Url::to(['site/index']), ['title' => 'Go']) ?>

</div>
