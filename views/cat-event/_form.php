<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
/* @var $form yii\widgets\ActiveForm */
?>


<?php if ($model->isNewRecord): ?>
<div class="col-md-6">
<?php endif ?>
    <div class="cat-event-form">

    <?php if (Yii::$app->session->hasFlash('eventFormSubmitted')): ?>

        <div class="alert alert-success">
            El evento se ha creado/actualizado correctamente.
        </div>

        <?= Html::a('Volver a mis eventos', 'my-events', ['title' => 'Go']) ?>

        
            
            <?php else: ?>

        <?php $form = ActiveForm::begin(); ?>

        

        <?= $form->field($model, 'vc_EventName')->textInput(['maxlength' => true]) ?>   

        <?= $form->field($model, 'tx_DescriptionEvent')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'vc_EventAddress')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'vc_EventCity')->textInput(['maxlength' => true]) ?>
        

        <?= $form->field($model, 'dt_EventStart')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
        ]) ?>

        <?= $form->field($model, 'dt_EventEnd')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
        ]) ?>

   
        

        <?= $form->field($model, 'dc_EventCost')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'dc_TransportCost')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Registrar Evento' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php endif ?>

