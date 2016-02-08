<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'i_Pk_User',
            'i_Fk_UserType',
            'vc_FirstName',
            'vc_LastName',
            'vc_HashPassword',
            // 'vc_Email:email',
            // 'vc_Phone',
            // 'vc_CompanyName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
