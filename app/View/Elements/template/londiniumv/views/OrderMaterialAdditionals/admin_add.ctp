<?php echo $this->Form->create("OrderMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Order Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("OrderMaterialAdditional.purchase_order_material_additional_id", __("Nomor PO"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("OrderMaterialAdditional.purchase_order_material_additional_id", array("div" => array("class" => "col-md-3"),"label" => false,"class"=>"select-full", "empty" => "" , "placeholder" => "- Pilih Nomor PO -","onchange"=>"generatePOMaterialEntry()","id"=>"purchaseOrderMaterialEntryId"));
                        ?>
                        <?php
                        echo $this->Form->label("OrderMaterialAdditional.po_date", __("Tanggal PO"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("OrderMaterialAdditional.po_date", array("div" => array("class" => "col-md-3"), 'type'=>'text',"label" => false, "class" => "form-control", "disabled"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("OrderMaterialAdditional.material_additional_supplier_id", __("Pemasok Material Pembantu"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("OrderMaterialAdditional.material_additional_supplier_id", array("div" => array("class" => "col-md-3"),"empty" => "", "placeholder" => "- Pilih Pemasok -","label" => false,"class" => "select-full", "disabled"));
                        ?>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel panel-default">
                        <div class="panel-body" id="materialList">
                            <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Ikan") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                <th width="1%" style="text-align: center;">No</th>
                                <th width="25%" style="text-align: center;">Nama</th>
                                <th width="20%" style="text-align: center;">Harga</th>
                                <th width="15%" style="text-align: center;">Jumlah</th>
                                <th width="20%" style="text-align: center;">Total</th>
                                <th width="5%" style="text-align: center;">Aksi</th>
                                </thead>
                                <tbody id="target-material-data">

                                </tbody>
                                <tfoot>
                                    <p class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'material-data', '')" data-n="1"></p>
                                <td colspan="4" align="right">
                                    <strong>Grand Total</strong>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" id="GrandTotal" name="data[OrderMaterialAdditional][total]" value="0" readonly>
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </td>
                                <td></td>
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
<?php echo $this->Form->end() ?>
<?php
$listMaterial = [];
foreach ($materialAdditional as $material) {
    $listMaterial[] = [
        "id" => $material["MaterialAdditional"]["id"],
        "label" => $material["MaterialAdditional"]["name"],
    ];
}
?>
<script>
    var count = 1;
    var countMaterial = 0;
    var listMaterial = <?= json_encode($listMaterial) ?>;
    $(document).ready(function () {
        //addThisRow(".firstrunclick", 'material-data', '');
    });

    function generatePOMaterialEntry(){
        $("tr.material-data-input").html("");
        var id = $('#purchaseOrderMaterialEntryId').val();
        $.ajax({
            url: BASE_URL + "admin/purchase_order_material_additionals/get_data_po_material_additional/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                //http://localhost/chenwoo/admin/purchase_order_material_additionals/get_data_po_material_additional/8
                var request = data.data;
                    $("select#OrderMaterialAdditionalMaterialAdditionalSupplierId").select2("val",request['PurchaseOrderMaterialAdditional']['material_additional_supplier_id']);
//                $("input#TransactionEntrySupplierId").val(request['MaterialEntry']['supplier_id']);
//                $("input#TransactionEntryMaterialCategoryId").val(request['MaterialEntry']['material_category_id']);
                for(i=0;i<request['PurchaseOrderMaterialAdditionalDetail'].length;i++){
                    addThisRow(".firstrunclick", 'material-data',"");
                    $("input#OrderMaterialAdditionalPoDate").val(cvtTanggal(request['PurchaseOrderMaterialAdditional']['po_date']));
                    $("select#OrderMaterialAdditionalDetail"+(i+1)+"MaterialAdditionalId").select2("val",request['PurchaseOrderMaterialAdditionalDetail'][i]['material_additional_id']);
                    $("input#OrderMaterialAdditionalDetail"+(i+1)+"Price").val(0);
                    $("input#OrderMaterialAdditionalDetail"+(i+1)+"Quantity").val(request['PurchaseOrderMaterialAdditionalDetail'][i]['quantity']);
                    $("input#TotalMaterial"+(i+1)).val(0);
                    countMaterial++;
                }
            }
        });
    }
    
    function updateGrandTotal() {
        var grandTotal = 0;
        for(i=0;i<countMaterial;i++){
            grandTotal+= parseInt($("input#TotalMaterial"+(i+1)).val());
        }
        $("input#GrandTotal").val(grandTotal);
    }

    function updateTotal(n) {
        var total = 0;
        if (document.getElementById("OrderMaterialAdditionalDetail" + n + "Quantity").value != null && document.getElementById("OrderMaterialAdditionalDetail" + n + "Price").value != null) {
            
            $quantity = document.getElementById("OrderMaterialAdditionalDetail" + n + "Quantity").value;
            $price = document.getElementById("OrderMaterialAdditionalDetail" + n + "Price").value;
            document.getElementById("TotalMaterial" + n).value = IDR(parseInt(parseInt($quantity.replaceAll('.', '')) * parseInt($price.replaceAll('.', ''))));
        }
        $('input.TotalMaterial').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt.replaceAll('.', ''));
        });
        $("input.auto-calculate-grand-total-produk-data").val(IDR(total));
    }

    function showDetails(n) {
        document.getElementById("weight_material_details" + n).innerHTML = "";
        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
        $("#weight_material_details" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan (Sesuai Nota Timbang):</h6></div>");
        for (i = 0; i < count; i++) {
            $("#weight_material_details" + n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='Ikan " + (i + 1) + "' class='form-control isDecimal beratTimbangan" + n + "" + i + "' name='data[TransactionMaterialEntry][" + n + "][TransactionMaterialEntryDetail][" + i + "][weight]' id='beratTimbangan" + n + "" + i + "Weight' onkeyup='calculateWeight(" + n + ")'><span class='input-group-addon'>Kg</span></div></div>");
        }

    }

//    function calculateWeight(n) {
//        var total = 0;
//        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
//        for (i = 0; i < count; i++) {
//            if ($("input.beratTimbangan" + n + i).val() != "") {
//                total += parseInt($("input.beratTimbangan" + n + i).val());
//            }
//
//        }
//        $("input.totalWeight" + n).val(total);
//        $("input.totalRemainingWeight" + n).val(total);
//    }

    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e,n) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        $("tr#material-detail-data-input"+n).remove();
        count--;
        //$("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
        fixNumber(tbody);
        updateTotal(0);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            //$(this).find(".qtyIdx").attr("id", "TransactionMaterialEntry" + i + "Weight");
            //$(this).find(".qtyPrice").attr("id", "TransactionMaterialEntry" + i + "Price");
            //$(this).find(".TotalMaterial").attr("id", "TotalMaterial" + i);
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
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[OrderMaterialAdditionalDetail][{{n}}][material_additional_id]' class='select-full' id='OrderMaterialAdditionalDetail{{n}}MaterialAdditionalId'>
    <option value='0'>-Pilih Material Pembantu-</option>
    {{#listMaterial}}
    <option value="{{id}}">{{label}}</option>
    {{/listMaterial}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type='text' name="data[OrderMaterialAdditionalDetail][{{n}}][price]" class='form-control isdecimal PurchaseOrderAdditionalMaterialDetailPrice text-right' value="0" id="OrderMaterialAdditionalDetail{{n}}Price" onkeyup='updateTotal({{n}})'/>
    <span class="input-group-addon">.00</span>
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name="data[OrderMaterialAdditionalDetail][{{n}}][quantity]" class='form-control text-right PurchaseOrderAdditionalMaterialDetailQuantity' id="OrderMaterialAdditionalDetail{{n}}Quantity"  onkeyup='updateTotal({{n}})' readonly/>
    <span class="input-group-addon">Pcs</span>
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type='text' name="data[OrderMaterialAdditionalDetail][Total]" class='form-control text-right TotalMaterial' value="0" id="TotalMaterial{{n}}" readonly/>
    <span class="input-group-addon">.00</span>
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