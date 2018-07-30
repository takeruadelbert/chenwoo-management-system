<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 boxOut-user">
        <?= $this->Form->create("Account", array("action" => "login_utama_lupa_password")) ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-email">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group label-floating">
                            <div class="input-group">

                                <div class="boxOut-password">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <div class="input-logo input-password" style=""></div>
                                        </div>
                                        <?= $this->Form->input('User.email', ['placeholder' => 'Email', 'label' => false, 'div' => false,"class"=>"form-control input-fieldPassword font-PoppinsLight"]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- flash here -->
        <?= $this->element("login/chenwoo/flash"); ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 boxOut-buttonReset">
                <button type="submit" class="btn button-resetPassword font-PoppinsSemiBold">RESET PASSWORD</button>
            </div>
        </div>

        <?= $this->Form->end() ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-buttonReset box-login">
                <a href="<?= Router::url("/admin") ?>"><button type="button" class="btn button-reset font-sourceSansProBold">LOGIN</button></a>
            </div>
        </div>
    </div>
</div>