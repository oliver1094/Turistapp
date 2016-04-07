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
            ['label' => 'Contáctanos', 'url' => ['/site/contact']],
            [
                'label' => Yii::t('app', 'Calificar plataforma'),
                'url' => ['/sys-comment/create'],
                'visible' => /* Can view loged in users only */ 
                    !Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Ver comentarios'),
                'url' => ['/sys-comment/index'],
                'visible' => /* Can view admin users only */ 
                    Yii::$app->user->can('admin')
            ],
            [
                'label' => Yii::t('app', 'Registrarse'),
                'url' => ['/catuser/register'],
                'visible' => /* Can view guest users only */ 
                    Yii::$app->user->isGuest
            ],
             [
                'label' => Yii::t('app', 'Usuarios'),
                'url' => ['/catuser/index'],
                'visible' => /* Can view admin users only */ 
                    Yii::$app->user->can('admin')
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
                        'visible' => /* Can view admins and empresa */ 
                            Yii::$app->user->can('empresa') || Yii::$app->user->can('admin')
                    ],
                    [
                        'label' => Yii::t('app', 'Itinerario'),
                        'url' => ['/itinerary/index'],
                        'visible' => /* Can view admins and turista */ 
                            Yii::$app->user->can('turista') || Yii::$app->user->can('admin')
                    ],
                    [
                        'label' => Yii::t('app', 'Ver reporte'),
                        'url' => ['/evt-report/report'],
                        'visible' => /* Can view admins and empresa */ 
                            Yii::$app->user->can('empresa') || Yii::$app->user->can('admin')
                    ],
                ],
            ],
            Yii::$app->user->isGuest ? /* Can view guest users only */
            ['label' => 'Login', 'url' => ['/site/login']] :
            [
                'label' => Yii::$app->user->identity->vc_Email,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Perfil'),
                        'url' => ['/catuser/view', 'id' => Yii::$app->user->getId()],
                        'visible' => /* Can view loged in users only */
                            !Yii::$app->user->isGuest
                    ],
                     '<li class="divider"></li>',
                    [
                        'label' => 'Cerrar sesión',
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
