<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserType;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJs('

    function showCompanyName()
    {
        $("[name=\'Users[company_name]\']").removeAttr("disabled");
        $(".field-users-company_name").show();
    }
    
    function hideCompanyName()
    {
        $("[name=\'Users[company_name]\']").attr("disabled","disabled");
        $(".field-users-company_name").hide();
    }

    function toggleStudentId()
    {
        var registrationType = $("[name=\'Users[user_type_id]\']:checked").val();
        switch(registrationType)
        {
            case "1": hideCompanyName(); break;
            case "2": showCompanyName(); break;
            
        }
    }

    
     $("input[type=radio][name=\'Users[user_type_id]\']").change(function(){
            toggleStudentId();
     });

    


'); ?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'user_type_id')->radioList(
        ArrayHelper::map(
            UserType::find()->all(),
            'id',
            'name'
        )
    ) ?>

    

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hash_password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['minlength' => true, 'maxlength' => true]) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
