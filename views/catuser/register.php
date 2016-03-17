<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Registrarse');
if(Yii::$app->user->can('admin')){
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lista de usuarios'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('formRegister', [
        'model' => $model,
    ]) ?>

</div>
