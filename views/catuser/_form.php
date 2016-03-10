<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UsrUsertype;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJs('

    function showCompanyName()
    {
        $("[name=\'Catuser[vc_CompanyName]\']").removeAttr("disabled");
        $(".field-catuser-vc_companyname").show();        
    }
    
    function hideCompanyName()
    {
        $("[name=\'Catuser[vc_CompanyName]\']").attr("disabled","disabled");
        $(".field-catuser-vc_companyname").hide();
    }

    function toggleStudentId()
    {
        var registrationType = $("[name=\'Catuser[i_Fk_UserType]\']:checked").val();
        switch(registrationType)
        {
            case "1": hideCompanyName(); break;
            case "2": showCompanyName(); break;
            
        }
    }

    hideCompanyName();
     $("input[type=radio][name=\'Catuser[i_Fk_UserType]\']").change(function(){
            toggleStudentId();
     });
     

    


'); ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <b>Sucedió algo inesperado:</b> No se ha podido cambiar la información correctamente, intentelo más tarde.
    </div>
<?php endif ?>

<div class="catuser-form">

    <?php $form = ActiveForm::begin(); ?>

    

        <?= $form->field($model, 'i_Fk_UserType')->radioList(
        ArrayHelper::map(
            UsrUsertype::find()->all(),
            'i_Pk_UserType',
            'vc_NameUserType'
        )
    ) ?>
    

    

    

    <?= $form->field($model, 'vc_FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_LastName')->textInput(['maxlength' => true]) ?>

<?php if ($model->isNewRecord): ?>

    <?= $form->field($model, 'vc_HashPassword')->passwordInput(['maxlength' => true]) ?>

<?php endif ?>

    <?= $form->field($model, 'vc_Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vc_CompanyName')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
