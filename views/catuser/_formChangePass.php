<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-success">
        <b>Sucedió algo inesperado:</b> No se ha podido cambiar la contraseña correctamente.
    </div>
<?php endif ?>

<div class="catuser-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>    


    <?= $form->field($model, 'vc_ActualPass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_NewPass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_RepeatPass')->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>