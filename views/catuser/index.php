<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\UsrUsertype;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CatuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista de usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('userDeleteSubmitted')): ?>
    <div class="alert alert-success">
        Se ha eliminado correctamente al usuario.
    </div>
<?php endif ?>

<div class="catuser-index animated fadeInDown">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="ibox-content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'vc_FirstName',
                'vc_LastName',
            [
                'attribute' => 'iFkUserType.vc_NameUserType',
                'value' => 'iFkUserType.vc_NameUserType',
                'filter'=> Html::activeDropDownList(
                    $searchModel, 'vc_NameUserType', ArrayHelper::map(
                        UsrUsertype::find()->asArray()->all(),
                        'vc_NameUserType',
                        'vc_NameUserType'
                    ),
                    ['class'=>'form-control','prompt'=>'--All--']
                ),                
            ],
            'i_Pk_User',
            'vc_Email:email',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ])?>
    </div>

</div>
