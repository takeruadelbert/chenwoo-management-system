<?php echo $this->Form->create("ReturnOrder", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Pengembalian Barang ke Pemasok") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pengembalian") ?></h6>
                            </div>
                            <div>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("ReturnOrder.material_entry_id", __("Nomor Nota Timbang"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("ReturnOrder.material_entry_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "- Pilih Nota Timbang -", "onchange" => "callData(this)"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("ReturnOrderTemp.return_number", __("Nomor Pengembalian"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("ReturnOrderTemp.return_number", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => "AUTO GENERATE"));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.piutang_supplier_id", __("Akun Piutang Supplier"), array("class" => "col-md-2 control-label label-required"));
                                echo $this->Form->input("Dummy.piutang_supplier_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Silahkan Pilih -", "options" => $piutangSuppliers));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Konversi / Material Masuk") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">                        
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th><?= __("Nomor Konversi / Nota Timbang") ?></th>
                                        <th><?= __("Penanggung Jawab") ?></th>
                                        <th><?= __("Total Berat") ?></th>
                                        <th><?= __("Dikembalikan") ?></th>
                                    </tr>
                                </thead>
                                <tbody id="target-source">
                                    <tr id="initMaterial">
                                        <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                    </tr>
                                    <tr class="dynamic-row-nota hidden" data-n="0">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Yang Diproses") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">                        
                                <thead>
                                    <tr>
                                        <th width="50px">No</th>
                                        <th width="25%"><?= __("Nama Ikan") ?></th>
                                        <th width="15%"><?= __("Grade") ?></th>
                                        <th width="15%"><?= __("Berat") ?></th>
                                        <th width="20%"><?= __("Harga Beli") ?></th>
                                        <th width="20%"><?= __("Total") ?></th>
                                    </tr>
                                </thead>
                                <tbody id="target-process">
                                    <tr id="initProcess">
                                        <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                                    </tr>
                                    <tr class="dynamic-row-detail hidden" data-n="0">
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control text-right" id="GrandTotal" name="data[ReturnOrder][total]" readonly>
                                                <span class="input-group-addon">,00</span>
                                            </div>
                                        </td>
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
<script>
    var grandTotal=0;
    var i = 1;
    $(document).ready(function () {

    });

    function callData(data) {
        $(".material").html("");
        $(".material-detail").html("");
        var materialEntryId = data.options[data.selectedIndex].value;
        var e = $("tr.dynamic-row-nota");
        $.ajax({
            url: BASE_URL + "admin/material_entries/view_data_material_entry/" + materialEntryId,
            type: "GET",
            dataType: "JSON",
            data: {},
            success: function (response) {
                var data = response.data;
                if (data.MaterialEntry.material_category_id == 1) {
                    var emp = data.Conversion;
                    var i = 1;
                    $.each(emp, function (index, value) {
                        
                        if (value.return_order_status == 0) {
                            var id = value.id;
                            var no = value.no_conversion;
                            var employee = data.Employee.Account.Biodata.first_name + " " + data.Employee.Account.Biodata.last_name;
                            var weight = value.total;
                            var n = e.data("n");
                            var template = $('#tmpl-material').html();
                            Mustache.parse(template);
                            var options = {i: i, id: id, n: n, no: no, employee: employee, weight: weight};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('.dynamic-row-nota').before(rendered);
                            e.data("n", n + 1);
                        }
                    });
                    $("#initMaterial").hide();
                } else {
                    var emp = data.MaterialEntry;
                    console.log(emp);
		    var checkStatus = "checked";
                    var i = 1;
                    var id = 0;
                    var no = emp.material_entry_number;
                    var employee = data.Employee.Account.Biodata.first_name + " " + data.Employee.Account.Biodata.last_name;
                    var weight = 0;
                    $.each(data.MaterialEntryGrade, function (index, value) {
                        weight = parseFloat(weight) + parseFloat(value.weight);
                    });
                    weight += " Kg";
                    var n = e.data("n");
                    var template = $('#tmpl-material').html();
                    Mustache.parse(template);
                    var options = {i: i, id: id, n: n, no: no, employee: employee, weight: weight};
                    
                    var rendered = Mustache.render(template, options);
                    $('.dynamic-row-nota').before(rendered);
                    e.data("n", n + 1);
                    $("#initMaterial").hide();
                    //If loin munculin detail 
                    var emp = data.TransactionEntry.TransactionMaterialEntry;
                    var statusPembayaran=true;
                    if(emp.length==0){ //Jika belum dibayar maka ambil nota timbang
                        emp = data.MaterialEntryGrade;
                        statusPembayaran=false;
                    }
                    $("#checkboxMaterial1").prop( "checked", true );
                    //$("#checkboxMaterial1").prop( "disabled", true );
                    $.each(emp, function (index, value) {
                        var id = value.id;
                        var produk = value.MaterialDetail.name;
                        var grade = value.MaterialSize.name;
                        var price = 0;
                        if(statusPembayaran==true){
                            price = parseInt(value.price);
                        }
                        var weight = value.weight + " " + value.MaterialDetail.Unit.uniq;
                        var total = parseFloat(weight)*parseInt(price);
                        var n = e.data("n");
                        grandTotal+= parseInt(total);
                        var template = $('#tmpl-material-detail').html();
                        Mustache.parse(template);
                        var options = {i: i, id: id, n: n, produk: produk, grade: grade, weight: weight,price: ic_rupiah(price),total:ic_rupiah(total),checkStatus:checkStatus};
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('.dynamic-row-detail').before(rendered);
                        e.data("n", n + 1);
                    });
                    $("#GrandTotal").val(ic_rupiah(grandTotal));
                    i++;
                    $("#initProcess").hide();
                }
                reloadStyled();
                coolField();
            }
        });
        i = 1;

    }

    function getDetail(value) {
        //alert($(".checkboxSelectedMaterial:checked").val());
        var conversionCheck = $(".checkboxSelectedMaterial:checked").val();
        var conversionId = value;
        var e = $("tr.dynamic-row-detail");
        if (conversionCheck != undefined) { //check in checked
            $.ajax({
                url: BASE_URL + "conversions/view_data_conversion_transaction/" + conversionId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (request) {
                    var data = request.data;
                    var emp = data.MaterialEntry.TransactionEntry.TransactionMaterialEntry;
		    var checkStatus = "";
                    if(emp.length!=0){
                        $.each(emp, function (index, value) {
                            var id = value.id;
                            var produk = value.MaterialDetail.name;
                            var grade = value.MaterialSize.name;
                            var price = parseInt(value.price);
                            var weight = value.weight + " " + value.MaterialDetail.Unit.uniq;
                            var total = parseFloat(weight)*parseInt(price);
                            var n = e.data("n");
                            grandTotal+= parseInt(total);
                            var template = $('#tmpl-material-detail').html();
                            Mustache.parse(template);
                            var options = {i: i, id: id, n: n, produk: produk, grade: grade, weight: weight,price: price,total:total,checkStatus:checkStatus,conversionId:conversionId};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('.dynamic-row-detail').before(rendered);
                            e.data("n", n + 1);
                        });
                    }else{
                        if(emp.length==0){ //Jika belum dibayar maka ambil nota timbang
                            statusPembayaran=false;
                        }
                        var emp = data.MaterialEntry.MaterialEntryGrade;
                        $.each(emp, function (index, value) {
                            var id = value.id;
                            var produk = value.MaterialDetail.name;
                            var grade = value.MaterialSize.name;
                            var price = 0;
                            if(statusPembayaran==true){
                                price = parseInt(value.price);
                            }
                            var weight = value.weight + " " + value.MaterialDetail.Unit.uniq;
                            var total = parseFloat(weight)*parseInt(price);
                            var n = e.data("n");
                            grandTotal+= parseInt(total);
                            var template = $('#tmpl-material-detail').html();
                            Mustache.parse(template);
                            var options = {i: i, id: id, n: n, produk: produk, grade: grade, weight: weight,price: price,total:total,checkStatus:checkStatus,conversionId:conversionId};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('.dynamic-row-detail').before(rendered);
                            e.data("n", n + 1);
                        });
                    }
                    $("#initProcess").hide();
                    $("#GrandTotal").val(IDR(grandTotal));
                }
            });
        }else{
            //remove if unchecked
            $('tr.whole'+conversionId).remove();
            listenerTotalReturn();
        }

    }
    
    function listenerTotalReturn() {
        var grandTotal = 0;
        $('.valueTotal').each(function () {
            if ($(this).val()) {
                $returnAmount = $(this).val();
            } else {
                $returnAmount = 0;
            }
            grandTotal += parseInt($returnAmount);
        });
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material">
    <tr class="material">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <input class='form-control' value="{{no}}" disabled>
    </td> 
    <td class="text-center">
    <input class='form-control' value="{{employee}}" disabled>
    </td>     
    <td class="text-center">
    <input class='form-control addon-field text-right' data-addon-symbol="Kg" value="{{weight}}" disabled>
    </td>    
    <td class="text-center">
    <input type="checkbox" name="data[ReturnOrderDetail][{{i}}][conversion_id]" id="checkboxMaterial{{i}}" class="checkboxSelectedMaterial checkboxMaterial{{i}} styled" value="{{id}}" onclick="getDetail({{id}})" {{checkStatus}}>
    </td>            
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-detail">
    <tr class="material-detail whole{{conversionId}}">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <input class='form-control' value="{{produk}}" disabled>
    </td> 
    <td class="text-center">
    <input class='form-control' value="{{grade}}" disabled>
    </td>     
    <td class="text-center">
    <input class='form-control addon-field text-right' data-addon-symbol="Kg" value="{{weight}}" disabled>
    </td><td class="text-center">
<div class="input-group">
<span class="input-group-addon">Rp.</span>
<input class='form-control text-right' value="{{price}}" disabled>
<span class="input-group-addon">,00</span>
</div>
</td><td class="text-center">
<div class="input-group">
<span class="input-group-addon">Rp.</span>
<input class='form-control text-right valueTotal' value="{{total}}" disabled>
<span class="input-group-addon">,00</span>
</div>
</td>                 
    </tr>
</script>