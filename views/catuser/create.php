<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatUser */

$this->title = 'Create Cat User';
$this->params['breadcrumbs'][] = ['label' => 'Cat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
