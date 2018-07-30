<?= $this->Form->create() ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 boxOut-user">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-username">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group label-floating">
                            <div class="input-group">
                                <div class="boxOut-username">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <div class="input-logo input-password" style=""></div>
                                        </div>
                                        <?= $this->Form->input('User.password', ['placeholder' => 'Password', 'label' => false, 'div' => false, "class" => "form-control input-fieldKomfirmasi font-PoppinsLight", "type" => "password"]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group label-floating">
                            <div class="input-group">
                                <div class="boxOut-password">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <div class="input-logo input-password" style=""></div>
                                        </div>
                                        <?= $this->Form->input('User.repeat_password', ['placeholder' => 'Ulangi Password', 'label' => false, 'div' => false, "class" => "form-control input-fieldPassword font-PoppinsLight", "type" => "password"]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->element("login/chenwoo/flash"); ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-buttonLogin">
                <button type="submit" class="btn button-login font-PoppinsSemiBold">Ganti Password</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-buttonLupa box-lupaPassword">
                <a href="<?= Router::url("/admin") ?>"><button type="button" class="btn button-lupa font-PoppinsSemiBold">Login</button></a>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<style>
    .error-message{
        display:none;
    }
</style>