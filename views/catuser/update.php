<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
   'modelClass' => 'Catuser',
]) . ' ' . $model->i_Pk_User;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catusers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_Pk_User, 'url' => ['view', 'id' => $model->i_Pk_User]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
