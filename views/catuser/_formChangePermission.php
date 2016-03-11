<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catuser-form">

    <?php $form = ActiveForm::begin(); ?>       

    <?= $form->field($modelAu, 'item_name')->dropDownList(
		ArrayHelper::map(
			AuthItem::find()->all(),			
			'name',
			'name'
		), array('prompt'=> Yii::t('app', 'Por favor selecciona un rol'),)) ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Actualizar permisos'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>