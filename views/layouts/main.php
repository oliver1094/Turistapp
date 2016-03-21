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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Turistapp',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Acerca de', 'url' => ['/site/about']],
            ['label' => 'Contáctanos', 'url' => ['/site/contact']],
            [
                'label' => Yii::t('app', 'Calificar plataforma'),
                'url' => ['/sys-comment/create'],

                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Ver comentarios'),
                'url' => ['/sys-comment/index'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => Yii::t('app', 'Registrarse'),
                'url' => ['/catuser/register'],
                'visible' => Yii::$app->user->isGuest
            ],
             [
                'label' => Yii::t('app', 'Usuarios'),
                'url' => ['/catuser/index'],
                'visible' => Yii::$app->user->can('admin')
            ],
            [
                'label' => 'Eventos',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Lista de eventos'),
                        'url' => ['/cat-event/index']
                    ],
                    [
                        'label' => Yii::t('app', 'Mis eventos'),
                        'url' => ['/cat-event/my-events'],
                        'visible' => Yii::$app->user->can('empresa') || Yii::$app->user->can('admin')
                    ],
                    [
                        'label' => Yii::t('app', 'Itinerario'),
                        'url' => ['/itinerary/index'],
                        'visible' => Yii::$app->user->can('turista') || Yii::$app->user->can('admin')
                    ],
                    [
                        'label' => Yii::t('app', 'Ver reporte'),
                        'url' => ['/cat-event/report'],
                        'visible' => Yii::$app->user->can('empresa') || Yii::$app->user->can('admin')
                    ],
                ],
            ],
            [
                'label' => 'Sesión',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Perfil'),
                        'url' => ['/catuser/view', 'id' => Yii::$app->user->getId()],
                        'visible' => !Yii::$app->user->isGuest
                    ],
                     '<li class="divider"></li>',
                     Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/site/login']] :
                    [
                        'label' => 'Salir (' . Yii::$app->user->identity->vc_Email . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
                ],
            ],
        ],
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
        <p class="pull-left">&copy; Turisapp <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
