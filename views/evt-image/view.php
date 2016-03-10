<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EvtImage */

$this->title = $model->i_Pk_Image;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evt Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evt-image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->i_Pk_Image], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->i_Pk_Image], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_Pk_Image',
            'i_FkTbl_Event',
            'vc_DirectoryName',
        ],
    ]) ?>

</div>
