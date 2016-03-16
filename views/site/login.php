<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, rellene los siguientes campos para iniciar sesión:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class'=>'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email',['inputOptions'=>['placeholder'=>'Email']])->input('email') ?>

        <?= $form->field($model, 'password',['inputOptions'=>['placeholder'=>'Password']])->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-7\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
                        <a><small>Forgot password?</small></a>
                        <p class="text-muted text-center"><small>Do not have an account?</small></p>                        
                        <?= Html::a ( 'Crear una cuenta', $url = Url::to('../catuser/register'), $options = ['class'=>'btn btn-sm btn-white btn-block'] ) ?>
            </div>
        </div>



    <?php ActiveForm::end(); ?>
</div>
</div>
