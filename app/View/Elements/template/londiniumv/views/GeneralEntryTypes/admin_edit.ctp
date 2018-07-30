<?php echo $this->Form->create("GeneralEntryType", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Kode Akun Buku Besar") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("GeneralEntryType.code", __("Kode"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.code", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control iscoa", "maxlength" => 11, 'readonly'));
                        ?>
                        <?php
                        echo $this->Form->label("GeneralEntryType.name", __("Nama"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", 'readonly'));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("GeneralEntryType.parent_id", __("Klasifikasi"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.parent_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "options" => $generalEntryTypes));
                        ?>
                        <?php
                        echo $this->Form->label("GeneralEntryType.currency_id", __("Mata Uang"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.currency_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "id" => "currency"));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <label>Saldo Awal</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default rupiah" type="button">Rp.</button>
                                <button class="btn btn-default dollar" type="button">$</button>
                            </span>
                            <?php
                            $is_readonly = "";
                            $nominal = 0;
                            $cash_ids = [2,3,4];
                            if(in_array($this->data['GeneralEntryType']['parent_id'], $cash_ids)) {                                
                                $is_readonly = "readonly";
                                $nominal = $this->data['GeneralEntryType']['initial_balance'];
                                if($this->data['GeneralEntryType']['currency_id'] == 1) {
                                    $nominal = str_replace(".00", "", $nominal);                                    
                                } else {
                                    $nominal = 0;
                                }
                            } else {
                                $nominal = $this->data['GeneralEntryType']['initial_balance'];
                            }
                            ?>
                            <input type="text" label="false" class="form-control text-right isdecimal" name="data[GeneralEntryType][initial_balance]" value="<?= $nominal ?>" <?= $is_readonly ?>>
                            <span class="input-group-btn">
                                <button class="btn btn-default rupiah" type="button">,00.</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    var currencyId = '<?= $this->data['Currency']['id'] ?>';
    $(document).ready(function() {
        if(currencyId == 1) {
            $(".dollar").hide();
            $(".rupiah").show();
        } else {
            $(".dollar").show();
            $(".rupiah").hide();
        }
        
        $("#currency").on("change", function() {
            if($(this).val() == 1) {
                $(".dollar").hide();
                $(".rupiah").show();
            } else {
                $(".dollar").show();
                $(".rupiah").hide();
            }
        });
    });
</script>