<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = 'Create Catuser';
$this->params['breadcrumbs'][] = ['label' => 'Catusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
