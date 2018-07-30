<?php echo $this->Form->create("MaterialAdditionalEntry", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Material Pembantu di Gudang") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Dummy.no_entry", __("Nomor Barang Masuk"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("Dummy.no_entry", array("div" => array("class" => "col-md-3"), "value" => "AUTO GENERATE", "label" => false, "class" => "form-control", "disabled"));
                        ?>
                        <?php
                        echo $this->Form->label("MaterialAdditionalEntry.material_additional_supplier_id", __("Pemasok Material Pembantu"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("MaterialAdditionalEntry.material_additional_supplier", array("div" => array("class" => "col-md-3"), "empty" => "", "label" => false, "class" => "form-control", "type" => "text", "readonly", "disabled"));
                        echo $this->Form->input("MaterialAdditionalEntry.material_additional_supplier_id", array("div" => array("class" => "col-md-3"), "empty" => "", "label" => false, "class" => "form-control", "type" => "hidden", "readonly"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("MaterialAdditionalEntry.purchase_order_material_additional_id", __("Nomor PO Pembelian Material Pembantu"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("MaterialAdditionalEntry.purchase_order_material_additional", array("div" => array("class" => "col-md-3"), "empty" => "", "label" => false, "class" => "form-control", "type" => "text", "disabled"));
                        echo $this->Form->input("MaterialAdditionalEntry.purchase_order_material_additional_id", array("div" => array("class" => "col-md-3"), "empty" => "", "label" => false, "class" => "form-control", "type" => "hidden"));
                        ?>
                        <?php
                        echo $this->Form->label("MaterialAdditionalEntry.dt", __("Tanggal Input"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("MaterialAdditionalEntry.dt", array("type" => "text", "div" => array("class" => "col-md-3"), "value" => date("Y-m-d H:i:s"), "label" => false, "class" => "form-control datetime"));
                        ?>
                    </div>
                </div>
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu") ?></h6>
                    </div>
                    <table width="100%" class="table table-hover table-bordered stn-table">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th width="300px">Nama</th>
                                <th width="250px">Barang Datang</th>
                                <th width="250px">Jumlah Diorder</th>
                                <th width="250px">Kekurangan</th>
								<th width="250px">Tanggal Barang Masuk</th>
                            </tr>
                        </thead>
                        <tbody id="target-data-PO">
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                            </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
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
    $(document).ready(function () {
        var purchaseOrderID = getParameterByName("id");
        $("#target-data-PO").html("");
        $.ajax({
            url: BASE_URL + "admin/material_additional_entries/get_purchase_order_data/" + purchaseOrderID,
            type: "GET",
            dataType: "JSON",
            data: {},
            success: function (response) {
                if (response != null && response != "") {
                    var i = 1;
//                    console.log(response);
                    $("#MaterialAdditionalEntryPurchaseOrderMaterialAdditionalId").val(response.PurchaseOrderMaterialAdditional.id);
                    $("#MaterialAdditionalEntryMaterialAdditionalSupplierId").val(response.PurchaseOrderMaterialAdditionalDetail[0].PurchaseOrderMaterialAdditional.MaterialAdditionalSupplier.id);
                    $("#MaterialAdditionalEntryPurchaseOrderMaterialAdditional").val(response.PurchaseOrderMaterialAdditional.po_number);
                    $("#MaterialAdditionalEntryMaterialAdditionalSupplier").val(response.PurchaseOrderMaterialAdditionalDetail[0].PurchaseOrderMaterialAdditional.MaterialAdditionalSupplier.name);
                    $.each(response.PurchaseOrderMaterialAdditionalDetail, function (index, value) {
                        var name = value.MaterialAdditional.name+" "+value.MaterialAdditional.size;
                        var price = value.price;
                        var unit = value.MaterialAdditional.MaterialAdditionalUnit.uniq;
                        var quantity = value.quantity_remaining;
                        var po_material_additional_detail_id = value.id;
                        var material_additional_id = value.material_additional_id;
                        var templatePO = $("#tmpl-data-PO").html();
                        Mustache.parse(templatePO);
                        var options = {
                            i: i,
                            n: index,
                            id: material_additional_id,
                            po_detail_id: po_material_additional_detail_id,
                            name: name,
                            unit: unit,
                            price: IDR(price),
                            quantity: ic_number_reverse(ic_kg(quantity)),
                        };
                        var rendered = Mustache.render(templatePO, options);
                        $("#target-data-PO").append(rendered);
                        i++;
						reloadDatePicker();
                    });
                } else {
                    var templatePO = $("#tmpl-data-empty").html();
                    Mustache.parse(templatePO);
                    var options = {};
                    var rendered = Mustache.render(templatePO, options);
                    $("#target-data-PO").append(rendered);
                }
            }
        });
    });

    function getParameterByName(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function calcSelisih(n) {
        var input = $("input#quantityRemaining" + n).val();
        var quantity = $("input#quantity" + n).val();
        var selisih = parseFloat(quantity - input);
        if (selisih < 0) {
            alert("Input Material Melebihi jumlah barang yang dipesan!");
            $("input#quantityRemaining" + n).val("0");
        }else{
			$("input#total" + n).val(ic_number_reverse(ic_kg(selisih)));
		}
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-data-PO">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <input type="text" class="form-control" value="{{name}}" name="data[MaterialAdditionalEntryDetail][{{i}}][name]" readonly>
    <input type="hidden" class="form-control" name="data[MaterialAdditionalEntryDetail][{{i}}][material_additional_id]" value="{{id}}">
    <input type="hidden" class="form-control" name="data[MaterialAdditionalEntryDetail][{{i}}][po_material_additional_detail_id]" value="{{po_detail_id}}">
    </select>
    </td>
    <td class="text-center">
    <div class="input-group" style = "width:100%;">
    <input type='number' class='form-control text-right isdecimaldollar' name="data[MaterialAdditionalEntryDetail][{{i}}][quantity_entry]" id="quantityRemaining{{i}}" onkeyup="calcSelisih({{i}})" value="0"/>
    <span class="input-group-addon" style = "width:50px; text-align: left">{{unit}}</span>
    </div>
    </td>    
    <td>
    <div class="input-group" style = "width:100%;">
    <input type='text' class='form-control text-right' id="quantity{{i}}" value="{{quantity}}" disabled/>
    <span class="input-group-addon" style = "width:50px; text-align: left">{{unit}}</span>
    </div>            
    </td>    
    <td>
    <div class="input-group" style = "width:100%;">
    <input type='text' class='form-control text-right' id="total{{i}}" value="" readonly/>
    <span class="input-group-addon" style = "width:50px; text-align: left">{{unit}}</span>
    </div> 
    </td>
    <td>
    <div class="input-group" style = "width:100%;">
    <input type='text' class='form-control datetime' name="data[MaterialAdditionalEntryDetail][{{i}}][entry_date]" id="" value=""/>
    </div>
	</td>
    </tr>    
</script>
<script type="x-tmpl-mustache" id="tmpl-data-empty">
    <tr>
    <td colspan="5" class="text-center">Tidak Ada Data</td>
    </tr>
</script>