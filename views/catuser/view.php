<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatUser */

$this->title = $model->i_Pk_User;
$this->params['breadcrumbs'][] = ['label' => 'Cat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->i_Pk_User], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_Pk_User',
            'i_Fk_UserType',
            'vc_FirstName',
            'vc_LastName',
            'vc_HashPassword',
            'vc_Email:email',
            'vc_Phone',
            'vc_CompanyName',
        ],
    ]) ?>

</div>
