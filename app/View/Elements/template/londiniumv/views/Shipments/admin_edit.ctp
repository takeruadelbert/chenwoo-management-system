<?php echo $this->Form->create("Shipment", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Ubah Data Pengiriman") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-mail-send"></i> Data Pengiriman</a></li>
                        <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-box-remove"></i> Data Master Cartoon yang akan dikirim</a></li>
                    </ul>
                    <div class="tab-content pill-content">
                        <div class="tab-pane fade in active" id="justified-pill0">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-mail-send"></i><?= __("Data Pengiriman") ?></h6>
                            </div>
                            <br>
                            <div id="materialList">
                                <div class="form-group">
                                    <div class=" col-md-2 control-label label-required">
                                        <label>Nomor Penjualan</label>
                                    </div>
                                    <div class= "col-md-4">
                                        <div class="has-feedback">
                                            <input type="text" class="form-control" value = "<?= $this->data['Sale']['sale_no'] ?>" disabled>
                                            <input type="hidden" name="<?= $this->data['Shipment']['sale_id'] ?>" id="saleId">
                                        </div>
                                    </div>    
                                    <?php
                                    echo $this->Form->label("Shipment.shipment_number", __("Nomor Pengiriman"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.shipment_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>              
                                </div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Shipment.po_number", __("Nomor Purchase Order"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.po_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['po_number']));
                                    ?> 
                                    <?php
                                    echo $this->Form->label("Dummy.buyer", __("Nama Pembeli"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.buyer", array("div" => array("class" => "col-md-4"), "label" => false, "readonly", "class" => "form-control", "id" => "buyerName", "value" => $this->data['Sale']['Buyer']['company_name']));
                                    ?>     
                                </div>
                                <div class="form-group"> 
                                    <?php
                                    echo $this->Form->label("Shipment.shipment_agent_id", __("Agen Pengiriman"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.shipment_agent_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Agen Pengirim -"));
                                    ?>   
                                    <?php
                                    echo $this->Form->label("Shipment.shipment_date", __("Tanggal Pengiriman"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.shipment_date", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control datepicker"));
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Shipment.seal_number", __("Nomor Segel"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.seal_number", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control"));
                                    ?>  
                                    <?php
                                    echo $this->Form->label("Shipment.container_number", __("Nomor Kontainer"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.container_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Shipment.from_dock", __("Dermaga Asal"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.from_dock", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("Shipment.to_dock", __("Dermaga Tujuan"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Shipment.to_dock", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                                <div class="form-group" id = "reg">
                                    <?php
                                    echo $this->Form->label("Shipment.bl_number", __("Nomor B/L"), array("class" => "col-md-2 control-label", "id" => "blnumberId"));
                                    echo $this->Form->input("Shipment.bl_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("Shipment.fda_reg_no", __("Nomor FDA REG"), array("class" => "col-md-2 control-label", "id" => "fdaregnoId"));
                                    echo $this->Form->input("Shipment.fda_reg_no", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div> 
                        </div>
                        <div class="tab-pane fade" id="justified-pill1"> <div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="table-responsive stn-table">
                                            <div class="panel-heading" style="background:#2179cc">
                                                <h6 class="panel-title" style=" color:#fff"><i class="icon-box-remove"></i><?= __("Data Master Cartoon yang akan dikirim") ?></h6>
                                            </div>
                                            <table width="100%" class="table table-hover table-bordered">
                                                <thead>
                                                <th width="1%" style="text-align: center;">No</th>
                                                <th width="15%" style="text-align: center;">Nomor Box</th>
                                                <th width="34%" style="text-align: center;">Produk</th>
                                                <th width="15%" style="text-align: center;">Berat Bersih</th>
                                                <th width="15%" style="text-align: center;">Jumlah Kemasan dalam MC</th>
                                                <th width="20%" style="text-align: center;">Tanggal Dikemas</th>
                                                </thead>
                                                <tbody id = "target-installment">
                                                    <tr id="temp">
                                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    $(document).ready(function () {
        var saleId = <?= $this->data['Shipment']['sale_id'] ?>;
        var buyerTypeId = <?= $this->data['Sale']['Buyer']['buyer_type_id'] ?>;
        viewDataBoxes(saleId);
        if (buyerTypeId == 1) {
            $('#reg').hide();
        } else if (buyerTypeId == 2) {
            $('#reg').show();
        }
    });

    function viewDataBoxes(saleId) {
        $.ajax({
            url: BASE_URL + "sales/view_data_sales_boxes/" + saleId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                if (data != null && data != '') {
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#temp").remove();
                    $('#target-installment').html("");
                    $.each(data.Package, function (index, packages) {
                        $.each(packages.PackageDetail, function (index, items) {
                            var options = {
                                i: i,
                                id: items.id,
                                package_no: items.package_no,
                                product: items.Product.Parent.name + " " + items.Product.name,
                                nett_weight: items.nett_weight,
                                quantity: items.quantity_per_pack,
                                tgl: cvtTanggal(items.created),
                            };
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                        });
                    });
                }
            }
        });
    }
    ;

</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">
    {{i}}
    </td>
    <td class="text-center">
    <input class='form-control' value="{{package_no}}" readonly>
    <input type='hidden' name="data[ShipmentMaterial][{{i}}][package_detail_id]" value='{{id}}'>
    </td> 
    <td>
    <input class='form-control text-left' value="{{product}}" readonly>
    </td> 
    <td>
    <div class="input-group">            
    <input class='form-control text-right' value="{{nett_weight}}" readonly>
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>
    </td> 
    <td>
    <div class="input-group">            
    <input class='form-control text-right' value="{{quantity}}" readonly>
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>
    </td> 
    <td>
    <input class='form-control text-center' value="{{tgl}}" readonly>
    </td> 
    </tr>
</script>
<?php echo $this->Form->end() ?>