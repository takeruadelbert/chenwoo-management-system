<?= $this->Form->create("Account", array("action" => "login_admin")) ?>
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
                                            <div class="input-logo input-username" style=""></div>
                                        </div>
                                        <?= $this->Form->input('username', ['placeholder' => 'Username', 'label' => false, 'div' => false,"class"=>"form-control input-fieldKomfirmasi font-PoppinsLight"]) ?>
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
                                         <?= $this->Form->input('password', ['placeholder' => 'Password', 'label' => false, 'div' => false,"class"=>"form-control input-fieldPassword font-PoppinsLight"]) ?>
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
                <button type="submit" class="btn button-login font-PoppinsSemiBold">LOGIN</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 boxCheckBox font-PoppinsLight text-center">
                <div class="checkbox edit-checbox">
                    <input id="promo" type="checkbox">
                    <label for="promo">
                        Biarkan saya tetap masuk
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 box-buttonLupa box-lupaPassword">
                <a href="<?= Router::url("/admin/lupa-password")?>"><button type="button" class="btn button-lupa font-PoppinsSemiBold">LUPA PASSWORD ?</button></a>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>