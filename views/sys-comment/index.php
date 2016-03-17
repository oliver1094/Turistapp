<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SysCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificaciones y Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'i_Score',
            'vc_CommentSys:ntext',
        ],
    ]); ?>

</div>
