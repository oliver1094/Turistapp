<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Turistapp') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $items;
    if (!Yii::$app->user->isGuest){
        $items[]= ['label' => 'Home', 'url' => ['/site/index']];
        $items[]= ['label' => 'About', 'url' => ['/site/about']];
        $items[]= ['label' => 'Contact', 'url' => ['/site/contact']];
        $items[]= ['label' => Yii::t('app', 'Eventos'), 'url' => ['/cat-event/index']];
        $items[]= ['label' => Yii::t('app', 'Itinerario'),'url' => ['/itinerary/index']];
        $items[]= ['label' => Yii::t('app', 'Usuarios'),'url' => ['/catuser/index'] ];
        $items[]= ['label' => Yii::t('app', 'Mis eventos'),'url' => ['/cat-event/my-events'] ];
        $items[]= ['label' => 'Salir (' . Yii::$app->user->identity->vc_Email . ')',
                   'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']];
    } else {
        $items[]= ['label' => 'Home', 'url' => ['/site/index']];
        $items[]= ['label' => 'About', 'url' => ['/site/about']];
        $items[]= ['label' => 'Contact', 'url' => ['/site/contact']];
        $items[]= ['label' => Yii::t('app', 'Eventos'),'url' => ['/cat-event/index']];
        $items[]= ['label' => 'Registrarse','url' => ['/catuser/register']];
        $items[]= ['label' => 'Login','url' => ['/site/login']];
    }

    NavBar::begin([
        'brandLabel' => 'Turistapp',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
        /*Items[
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            !Yii::$app->user->isGuest ?
            [
                'label' => Yii::t('app', 'Eventos'),
                'url' => ['/cat-event/index']
            ],
            [
                'label' => Yii::t('app', 'Itinerario'),
                'url' => ['/itinerary/index'] 
            ],
            [
                'label' => Yii::t('app', 'Usuarios'),
                'url' => ['/catuser/index'] 
            ],
            [
                'label' => Yii::t('app', 'Mis eventos'),
                'url' => ['/cat-event/my-events'] 
            ],
            [
                'label' => 'Salir (' . Yii::$app->user->identity->vc_Email . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ]
            :
            [
                'label' => Yii::t('app', 'Eventos'),
                
                'url' => ['/cat-event/index']
            ],
            [
                'label' => 'Login',
                'url' => ['/site/login']
            ], end items/

            //Itinerario
            /*!Yii::$app->user->isGuest ?
            [
                'label' => Yii::t('app', 'Itinerario'),
                
                'url' => ['/itinerary/index'] 
               
            ]:
            [
                'label' => Yii::t('app', 'Eventos2xD'),
                
                'url' => ['/cat-event/index']
            ],*/
            
            
            //
            
            /*Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Salir (' . Yii::$app->user->identity->vc_Email . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],*/
        //],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Turistapp <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
