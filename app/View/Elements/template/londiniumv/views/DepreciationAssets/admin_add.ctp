<?php echo $this->Form->create("DepreciationAsset", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>

<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Penyusutan Aset") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("DepreciationAsset.asset_property_id", __("Nama Aset"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("DepreciationAsset.asset_property_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full assetType", "empty" => "", "placeholder" => "- Pilih Aset -"));
                        ?>
                        <div class="col-md-2 control-label">
                            <label>Nominal Aset</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                </span>
                                <input type="text" label="false" class="form-control text-right amount" disabled>
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <div class="col-md-2 control-label">
                            <label>Nominal Aset Sekarang</label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                </span>
                                <input type="text" label="false" class="form-control text-right isdecimal currentNominal" name="data[DepreciationAsset][current_nominal]">
                                <span class="input-group-btn">
                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 control-label">
                        <label>Durasi Penyusutan</label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="number" label="false" class="form-control text-right duration" name="data[DepreciationAsset][depreciation_duration]">
                            <span class="input-group-btn">
                                <button class="btn btn-default rupiah" type="button">bulan</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2 control-label">
                        <label>Nominal Penyusutan (per Bulan)</label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default rupiah" type="button">Rp.</button>
                            </span>
                            <input type="text" label="false" class="form-control text-right depreciationAmount" readonly name="data[DepreciationAsset][depreciation_amount]">
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    $(document).ready(function() {
        $(".assetType").on("change", function() {
            var assetId = $(this).val();
            if(assetId != "" && assetId != null) {
                $.ajax({
                    url: BASE_URL + "/admin/depreciation_assets/get_nominal_asset/" + assetId,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function(data) {
                        $(".amount").val(IDR(data.AssetProperty.nominal));
                    }
                });
            }
        });
        
        $(".duration, .currentNominal").on("change keyup keypress", function(evt) {
            /* disbale the dot */
            var keycode = evt.charCode || evt.keyCode;
            if(keycode == 46) {
                return false;
            } else {
                var nominalPenyusutan;
                var duration = $(".duration").val() == "" ? 0 : $(".duration").val();
                var nominalAsset = parseInt(replaceAll($(".currentNominal").val(), ".", ""));
                if(duration == 0) {
                    nominalPenyusutan = 0; 
                } else {
                    nominalPenyusutan = parseInt(nominalAsset / duration);                    
                }
                $(".depreciationAmount").val(IDR(nominalPenyusutan));
            }
        });
        
        function replaceAll(str, find, replace) {
            return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
        }
    });
</script>
