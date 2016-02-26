<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SysComment */

//$this->title = $model->i_Pk_Score;
$this->title = 'Thank you for your rating';
$this->params['breadcrumbs'][] = ['label' => 'Sys Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--         Html::a('Update', ['update', 'id' => $model->i_Pk_Score], ['class' => 'btn btn-primary'])
         Html::a('Delete', ['delete', 'id' => $model->i_Pk_Score], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) -->

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_Score',
            'vc_CommentSys:ntext',
        ],
    ]) ?>

</div>
