<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = Yii::t('app', 'Registro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-create  animated fadeInDown">
<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
	<div class="ibox-title">
	<h3>Registro</h3>
	</div>

		<div class="ibox-content" style="display: block;">
    

    <?= $this->render('formRegister', [
        'model' => $model,
    ]) ?>
    </div>
    
    </div>
    </div>
</div>
</div>
