<?php
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
AppAsset::register($this);

// 加载adminlte
dmstr\web\AdminLteAsset::register($this);
$this->title = 'sting';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DRVSKY</title>
<?php $this->head() ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</head>
<body class="layout-top-nav">
<?php $this->beginBody() ?>
<div class="wrapper">

    <div>
        <!-- <header class="header" ng-include ng-controller="HeaderController" src="'templates/home/header.html'">
        </header>-->

        <div class="container">
            <div ui-view>
            </div>
        </div>
    </div>

    <footer class="footer" ng-include ng-controller="FooterController" src="'templates/home/footer.html'">
    </footer>
</div>

<script src="lib/requirejs/require.min.js"></script>
<script src="js/bootstrap.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
