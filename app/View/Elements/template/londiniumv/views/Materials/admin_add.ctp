<?php echo $this->Form->create("Material", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Material") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class = "row">
                <div class = "col-md-6">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Material.name", __("Nama"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("Material.name", array("div" => array("class" => "col-md-9"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                </div>
                <div class = "col-md-6">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Material.material_category_id", __("Kategori"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("Material.material_category_id", array("div" => array("class" => "col-md-9"), "label" => false, "class" => "select-full", "empty" => "- Pilih Material Category -"));
                        ?>
                    </div>  
                </div>  
            </div>
            <div class="stn-table">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th align="center" valign="middle" width="1%">No</th>
                            <th align="center" valign="middle" width="40%">Nama Material Detail</th>
                            <th align="center" valign="middle" width="40%">Satuan Material Detail</th>
                            <th align="center" valign="middle" width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="target-material-data">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'material-data', '')" data-n="0"><i class="icon-plus-circle"></i></a>
                            </td>
                        </tr>
                </table>
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
    var count = 2;
    var data_material_unit = [];
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + "admin/units/get_unit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (i = 0; i < data.length; i++) {
                    //alert(data[i]['Material']['id']);
                    data_material_unit.push({no: data[i]['Unit']['id'], label: data[i]['Unit']['name']});
                    if (i == data.length - 1) {
                        addThisRow(".firstrunclick", 'material-data', '')
                    }
                }
            }
        });
    });
    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        count--;
        fixNumber(tbody);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, data_material_unit: data_material_unit};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
    }
//    function addMaterialDetail(){
//        var list_units = "<select name='data[MaterialDetail]["+count+"][unit_id]' class='form-control' id='MaterialDetail1ProductUnitId'>";
//        list_units += "<option value='0'>-Pilih Satuan Detail Material-</option>";
//        for(i=0;i<data_material_unit_no.length;i++){
//            list_units += "<option value='"+data_material_unit_no[i]+"'>"+data_material_unit_nama[i]+"</option>";
//        }
//        list_units+= "</select>";
//        $("#materialDetailList").append("<div class='form-group'><label for='MaterialDetail[" + count + "]id' class='col-md-2 control-label'>Nama Material Detail "+count+"</label><div class='col-md-2'><input type='text' id='MaterialDetailName' name='data[MaterialDetail]["+count+"][name]' class='form-control'/></div><label for='MaterialDetail[" + count + "]id' class='col-md-2 control-label'>Satuan Detail Material "+count+"</label><div class='col-md-2'>"+list_units+"</div></div>"); //<label for='MaterialDetail[" + count + "]id' class='col-md-2 control-label'>Harga Material Detail "+count+"</label><div class='col-md-2'><input type='text' id='MaterialDetailPrice' name='data[MaterialDetail]["+count+"][price]' class='form-control'/></div>
//        count++;
//    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{n}}</td>
    <td><input type='text' id='ProductDetailName' name='data[MaterialDetail][{{n}}][name]' class='form-control'/></td>    
    <td class="text-center">
    <select name='data[MaterialDetail][{{n}}][unit_id]' class='select-full' id='MaterialDetailtUnitId'>
    <!--<option value='0'>-Pilih Satuan Material-</option>-->
    {{#data_material_unit}}
    <option value="{{no}}">{{label}}</option>
    {{/data_material_unit}}
    </select>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>    
    </tr>
</script>