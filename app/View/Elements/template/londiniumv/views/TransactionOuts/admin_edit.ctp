<?php echo $this->Form->create("Satuan", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Transaction Out") ?>
                    </h6>
                </div>
                <div id="materialList">
                    <div class="form-group">
                            <?php
                            echo $this->Form->label("TransactionEntry.1.material_id", __("Nama Material 1"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("TransactionEntry.1.material_id", array("div" => array("class" => "col-md-4"), "empty" => "- Pilih Material -", "label" => false, "class" => "form-control"));
                            ?>
                            <?php
                            echo $this->Form->label("TransactionEntry.1.quantity", __("Jumlah Material 1"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("TransactionEntry.1.quantity", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <input name="Button" type="button" onclick="addMaterial()" class="btn btn-success" value="<?= __("Tambah Material") ?>">
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
<script>
    var count=2;
    var data_material_no = [];
    var data_material_nama = [];
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + "admin/materials/get_material",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for(i=0;i<data.length;i++){
                    //alert(data[i]['Material']['id']);
                    data_material_no.push(data[i]['Material']['id']);
                    data_material_nama.push(data[i]['Material']['name']);
                }
            }
        });
    });
    function addMaterial(){
        var list_materials = "<select name='data[TransactionEntry]["+count+"][material_id]' class='form-control' id='TransactionEntry1MaterialId'>";
        list_materials += "<option value='0'>-Pilih Material-</option>";
        for(i=0;i<data_material_no.length;i++){
            list_materials += "<option value='"+data_material_no[i]+"'>"+data_material_nama[i]+"</option>";
        }
        list_materials+= "</select>";
        $("#materialList").append("<div class='form-group'><label for='TransactionEntryMaterial[" + count + "]id' class='col-md-2 control-label'>Nama Material "+count+"</label><div class='col-md-4'>"+list_materials+"</div><label for='TransactionEntryMaterial[" + count + "]id' class='col-md-2 control-label'>Jumlah Material "+count+"</label><div class='col-md-4'><input type='input' name='data[TransactionEntry][" + count + "][quantity]' class='form-control' id='TransactionEntryMaterial[" + count + "]quantity'/></div></div>");
        count++;
    }
</script>
<?php echo $this->Form->end() ?>