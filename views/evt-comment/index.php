<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SysCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'event Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create evt Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'i_FkTbl_Event',
            'i_FkTbl_User',
            'i_Score',
            'txt_EventComment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ])?>