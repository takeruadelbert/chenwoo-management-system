<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="icon" type="image/gif/png" href="<?= Router::url("/img/logoicon.png", true) ?>">
        <title><?= $title?></title>
        <link type="text/css" rel="stylesheet" href="<?= Router::url("/login/chenwoo/css/bootstrap.css") ?>" />
        <link type="text/css" rel="stylesheet" href="<?= Router::url("/login/chenwoo/css/ripples.css") ?>" />
        <link type="text/css" rel="stylesheet" href="<?= Router::url("/login/chenwoo/css/download/font-awesome.css") ?>" />
        <link type="text/css" rel="stylesheet" href="<?= Router::url("/login/chenwoo/css/download/build.css") ?>" />
        <link type="text/css" rel="stylesheet" href="<?= Router::url("/login/chenwoo/css/custom/login.css") ?>" />
        <script src="<?= Router::url("/login/chenwoo/js/jquery-2.1.4.js") ?>"></script>
    </head>
    <body>
        <div class="row background">
            <div class="col-md-12 col-sm-12 col-xs-12 fit-screen">
                <div id="yourEl" class="col-md-12 col-sm-12 col-xs-12 boxOut-middleLogin">
                    <div class="col-md-12 col-sm-12 col-xs-12 box-middleContent flex">
                        <div class="row">
                            <div class="boxOut-loginContent center-block">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 boxOut-titleUp">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 box-textTitle font-oswaldBold center">
                                                CHENWOOFISHERY
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 box-textTitle font-oswaldBold center">
                                                MANAGEMENT SYSTEM
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                echo $this->fetch("content");
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 box-bottomShadow">

                        <div class="col-md-12 col-sm-12 col-xs-12 footer-top font-PoppinsSemiBold center flex">
                            <?= _APP_REFERENCE_NAME ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 box-bottomFooter font-PoppinsLight center flex">
                            &copy; <?= $this->StnAdmin->copyrightYear(_APP_START) ?> - <?= _APP_CORPORATE_FULL ?>  |  Developed & Maintenance by&nbsp;<a target="_blank" style="color:white" href="<?= _DEVELOPER_WEBSITE ?>"><?= _DEVELOPER_NAME ?></a></div>
                    </div>
                    <div class="box-support center">
                        <div class="button-support font-PoppinsLight center center-block flex">
                            <a target="_blank" href="<?= _DEVELOPER_WEBSITE ?>">Bantuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>    
    <script src="<?= Router::url("/login/chenwoo/js/bootstrap.js") ?>"></script>
    <script src="<?= Router::url("/login/chenwoo/js/material.js") ?>"></script>
    <script src="<?= Router::url("/login/chenwoo/js/ripples.js") ?>"></script>
</html>