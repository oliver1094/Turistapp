<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = $model->i_Pk_User;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catusers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
<?php endif ?>