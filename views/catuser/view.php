<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Catuser */

$this->title = $model->i_Pk_User;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catusers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catuser-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')): ?>
    <p>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cambiar contraseña'), ['update-pass', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cambiar permiso'), ['change-permission', 'id' => $model->i_Pk_User], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->i_Pk_User], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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