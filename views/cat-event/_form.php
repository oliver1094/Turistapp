<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\CatEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->registerJs('
    var MaxInputs       = 8; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón
    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;
    var FieldCount = x-1; //para el seguimiento de los campos
    $(AddButton).click(function (e) {
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++;
            //agregar campo
            $(contenedor).append(\'<div><button id="eliminar" type="button" class="btn btn-danger">&times;</button><input type="file" name="CatEvent[eventFile][]"></div>\');
            x++; //text box increment
        }
        });
     $("body").on("click",".btn-danger", function(e){ //click en eliminar campo
        if( x > 1 ) {
            $(this).parent("div").remove(); //eliminar el campo
            x--;
        }
        return false;
    });
');
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

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

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

        <a id="agregarCampo" class="btn btn-info" >Agregar Archivo</a>
        <div id="contenedor">
            <div class="added">
            </div>
        </div>
        <br>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Registrar Evento' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php endif ?>

