<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact animated fadeInDown">

<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">

    <div class="ibox-title">
    <h3>Contacto</h3>
    </div>

    <div class="ibox-content" style="display: block;">

<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Gracias por contactarnos, le responderemos a la brevedad posible
        </div>
 <?php else: ?>

    <?php $form = ActiveForm::begin(['id' => 'contact-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'inputOptions' => ['class' => 'form-control col-sm-10'],
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-2\">{error}</div>",
        ],
    ]); ?>

                    
    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'email') ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'subject') ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-3">{input}</div></div>',
    ]) ?>

    <div class="hr-line-dashed"></div>
                    
    <div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
            
        
        <?= Html::a ( 'Cancelar', $url = Url::to('index'), $options = ['class'=>'btn btn-white'] ) ?>
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>

    </div>
    </div>

    <?php ActiveForm::end(); ?>

           
    </div>

</div>
</div>
</div>
        
<?php endif; ?>

</div>
