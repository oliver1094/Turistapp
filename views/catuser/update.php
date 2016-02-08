<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatUser */

$this->title = 'Update Cat User: ' . ' ' . $model->i_Pk_User;
$this->params['breadcrumbs'][] = ['label' => 'Cat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_User, 'url' => ['view', 'id' => $model->i_Pk_User]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
