<?php echo $this->Form->create("RequestOrderMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Request Order Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("RequestOrderMaterialAdditionalTemp.ro_number", __("Nomor RO"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("RequestOrderMaterialAdditionalTemp.ro_number", array("div" => array("class" => "col-md-4"), 'type' => 'text', "label" => false, "value" => "AUTO GENERATE", "class" => " form-control", "disabled"));
                                ?>
                                <?php
                                echo $this->Form->label("RequestOrderMaterialAdditional.ro_date", __("Tanggal RO"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("RequestOrderMaterialAdditional.ro_date", array("div" => array("class" => "col-md-4"), 'type' => 'text', "label" => false, "value" => date('Y-m-d'), "class" => "datepicker form-control"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="panel panel-default">
                        <div class="panel-body" id="materialList">
                            <div class="table-responsive stn-table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu") ?></h6>
                                </div>
                                <table width="100%" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="1%" style="text-align: center;">No</th>
                                            <th width="25%" style="text-align: center;">Nama</th>
                                            <th width="15%" style="text-align: center;">Jumlah</th>
                                            <th width="1%" style="text-align: center;">Aksi</th>
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
                                    </tfoot>
                                </table>
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
</div>
<?php echo $this->Form->end() ?>
<?php
$listMaterial = [];
foreach ($materialAdditional as $material) {
    $listMaterial[] = [
        "id" => $material["MaterialAdditional"]["id"],
        "label" => $material["MaterialAdditional"]["name"]." ".$material["MaterialAdditional"]["size"],
        "uniq" => $material['MaterialAdditionalUnit']['uniq']
    ];
}
?>
<script>
    var count = 1;
    var listMaterial = <?= json_encode($listMaterial) ?>;
    $(document).ready(function () {
        addThisRow(".firstrunclick", 'material-data', '');
    });

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e, n) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        $("tr#material-detail-data-input" + n).remove();
        count--;
        fixNumber(tbody);
        updateTotal(0);
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

        var options = {i: 2, n: n, listMaterial: listMaterial};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        count++;
    }

    function changeUnit(e, n) {
        var unit = $(e).find(':selected').data("unit");
        $("span#unitJml" + n).html(unit);
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[RequestOrderMaterialAdditionalDetail][{{n}}][material_additional_id]' data-unit = "aaaa" class='select-full' onchange = "changeUnit(this,{{n}})">
    <option value='0' data-unit = " ">-Pilih Material Pembantu-</option>
    {{#listMaterial}}
    <option value="{{id}}" data-unit = "{{uniq}}">{{label}}</option>
    {{/listMaterial}}
    </select>
    </td>    
    <td class="text-center">
    <div class="input-group" style = "width:100%;">
    <input type='input' name="data[RequestOrderMaterialAdditionalDetail][{{n}}][quantity]" class='form-control text-right RequestOrderAdditionalMaterialDetailQuantity isdecimaldollar' id="RequestOrderAdditionalMaterialDetail{{n}}Quantity"  onkeyup='updateTotal({{n}})'/>
    <span class="input-group-addon unit" id="unitJml{{n}}" style = "width:50px; text-align:left;"></span>
    </div>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this),{{n}})">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>       
    </tr>
</script>