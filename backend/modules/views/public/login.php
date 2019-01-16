<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<!DOCTYPE html>
<html class="login-bg">
<head>
    <title>商城 - 后台管理</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" type="text/css" href="css/elements.css" />
    <link rel="stylesheet" type="text/css" href="css/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="css/lib/font-awesome.css" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="css/compiled/signin.css" type="text/css" media="screen" />


    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>

    <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                    'template' => '{input}{error}',
            ],
    ]); ?>
    <div class="span4 box">
        <div class="content-wrap">
            <h6>商城 - 后台管理</h6>
            <?= $form->field($model,"adminuser")->textInput(['class'=>'span12','placeholder'=>'管理员账号'])?>
            <?= $form->field($model,"adminpass")->passwordInput(['class'=>'span12','placeholder'=>'管理员密码'])?>

            <a href="#" class="forgot">忘记密码?</a>

            <?= $form->field($model,'rememberMe')->checkbox([
                    'id' => 'remember-me',
                    'template' => '<div class="remember">{input}<label for="remember-me">记住我</label></div>'
            ]);?>

            <?= Html::submitButton('登录',['class'=>"btn-glow primary login"]);?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>


</div>

<!-- scripts -->
<script src="js/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/theme.js"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
    $(function () {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function (e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('img/bgs/" + bg + "')");
        });

    });
</script>

</body>
</html>