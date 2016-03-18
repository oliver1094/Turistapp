<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = $model->vc_FirstName . ' ' . $model->vc_LastName;
if(Yii::$app->user->can('admin')){
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lista de usuarios'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox-content" style="display: block;">

<?php if (Yii::$app->session->hasFlash('userUpdatePassSubmitted')): ?>
    <div class="alert alert-success">
        Se ha cambiado la contraseña correctamente.
    </div>
<?php elseif (Yii::$app->session->hasFlash('userUpdateSubmitted')): ?>
    <div class="alert alert-success">
        Se ha cambiado la información de la cuenta correctamente.
    </div>
<?php endif ?>

<div class="catuser-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin') || $model->i_Pk_User == Yii::$app->user->getId()): ?>
    <p>

        <?= Html::a(Yii::t('app', 'Cambiar información'), ['update', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cambiar contraseña'), ['update-pass', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cambiar permiso'), ['change-permission', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar cuenta'), ['delete', 'id' => $model->i_Pk_User], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estas seguro de que deseas eliminar tu cuenta?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                      
                'label' => 'Tipo de usuario',
                'value' => $model->iFkUserType->vc_NameUserType
            ],
            'vc_FirstName',
            'vc_LastName',
            'vc_Email:email',
            'vc_Phone',
            [                      
                'label' => 'Nombre de la compañía',
                'value' => $model->vc_CompanyName,
                'visible' => Yii::$app->user->can('empresa') || Yii::$app->user->can('admin')
            ],
        ],
    ]) ?>
    <?php else: ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'i_Pk_User',
            'i_Fk_UserType',
            'vc_FirstName',
            'vc_LastName',
            'vc_HashPassword',
            'vc_Email:email',
            'vc_Phone',
            'vc_CompanyName',
        ],
    ]) ?>

</div>
</div>
<?php endif ?>