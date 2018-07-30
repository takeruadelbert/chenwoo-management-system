<?php echo $this->Form->create("SaleProductAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Penjualan Produk Tambahan") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i>Data Penjualan Produk Tambahan</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <table width="100%" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                                    echo $this->Form->input("SaleProductAdditional.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("NIP"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => !empty($this->Session->read("credential.admin.Employee.nip")) ? $this->Session->read("credential.admin.Employee.nip") : "-", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="form-group">                                            
                                                    <?php
                                                    echo $this->Form->label(null, __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => !empty($this->Session->read("credential.admin.Office.name")) ? $this->Session->read("credential.admin.Department.name") : "-", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => !empty($this->Session->read("credential.admin.Employee.Office.name")) ? $this->Session->read("credential.admin.Employee.Office.name") : "-", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                    
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label('SaleProductAdditional.reference_number', __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("SaleProductAdditional.reference_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => "AUTO GENERATE"));
                                                    ?>
                                                    <div id="buyer">
                                                        <?php
                                                        echo $this->Form->label("SaleProductAdditional.purchaser_id", __("Pembeli"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class="col-md-4 has-feedback">
                                                            <?php
                                                            echo $this->Form->input("Dummy.search_pembeli", array("div" => array("class" => false), "type" => "text", "label" => false, "class" => "form-control typeahead-ajax-purchaser", "empty" => "", "placeholder" => "Cari Nama Pembeli ..."));
                                                            echo $this->Form->input("SaleProductAdditional.purchaser_id", array("type" => "hidden", "class" => "purchaserId"));
                                                            ?>
                                                            <i class="icon-search3 form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label('SaleProductAdditional.payment_type_id', __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("SaleProductAdditional.payment_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Pembayaran -", "id" => "paymentType"));
                                                    ?>
                                                    <div id="initialBalance">
                                                        <?php
                                                        echo $this->Form->label('SaleProductAdditional.initial_balance_id', __("Kas"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("SaleProductAdditional.initial_balance_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full initBalance", "empty" => "", "placeholder" => "- Pilih Kas -", "disabled"));
                                                        ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label('SaleProductAdditional.sale_date', __("Tanggal Penjualan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("SaleProductAdditional.sale_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text" , "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered stn-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama Produk Tambahan</th>
                                            <th>Berat</th>
                                            <th>Harga Per Kg</th>
                                            <th>Total</th>
                                            <th width="40">Aksi</th>
                                        </tr>
                                    <thead>
                                    <tbody id="target-detail-penjualan">
                                        <tr>
                                            <td class="text-center nomorIdx">
                                                1
                                            </td>
                                            <td>
                                                <?= $this->Form->input("SaleProductAdditionalDetail.0.product_additional_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Produk Tambahan -", "id" => "product0", "onchange" => "getPricePerKg(0)")) ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="weight0" name="data[SaleProductAdditionalDetail][0][weight]" onkeyup="getTotal(0)">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Kg.</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right" id="nominal0" name="data[SaleProductAdditionalDetail][0][nominal]" readonly>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right total" disabled id="total0">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <!--<a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <a class="text-success firstrunclick" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-penjualan', 'anakOptions')" data-n="1"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right grandTotal" readonly name="data[SaleProductAdditional][grand_total]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td></td>
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
    var productAdditionals =<?= $this->Engine->toJSONoptions($productAdditionals) ?>;

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        calculateGrandTotal();
        var n = $(".firstrunclick").data("n");
        $(".firstrunclick").data("n", n - 1);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".total").attr("id", "total" + (i - 1));
            $(this).find(".weight").attr("id", "weight" + (i - 1));
            $(this).find(".nominal").attr("id", "nominal" + (i - 1));
            //$(this).find(".weight").attr("onkeyup", "getTotal"+(i-1));
            i++;
        })
    }
    function anakOptions() {
        return {productAdditionals: productAdditionals};
    }

    function getTotal(n) {
        var pricePerKg = parseInt(replaceAll($("#nominal" + n).val(), ".", ""));
        var weight = parseFloat($("#weight" + n).val());
        var total = pricePerKg * weight;
        $("#total" + n).val(IDR(total));
        calculateGrandTotal();
    }

    function getPricePerKg(n) {
        var productAdditionalId = $("#product" + n).val();
        if (productAdditionalId != "" && productAdditionalId != null) {
            $.ajax({
                url: BASE_URL + "admin/product_additionals/get_price_per_kg/" + productAdditionalId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#nominal" + n).val(IDR(data.ProductAdditional.price));
                }
            });
        }
    }

    function calculateGrandTotal() {
        var grandTotal = 0;
        $.each($(".total"), function (index, value) {
            grandTotal += parseInt(replaceAll($("#total" + index).val(), ".", ""));
        });
        $(".grandTotal").val(IDR(grandTotal));
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-penjualan">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select class="select-full" name="data[SaleProductAdditionalDetail][{{n}}][product_additional_id]" placeholder="- Pilih Produk Tambahan -" id="product{{n}}" onchange="getPricePerKg({{n}})">
    {{#productAdditionals}}
    <option value="{{value}}">{{label}}</option>
    {{/productAdditionals}}
    </select>       
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right weight" id="weight{{n}}" name="data[SaleProductAdditionalDetail][{{n}}][weight]" onkeyup="getTotal({{n}})">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Kg</button>
    </span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right nominal" id="nominal{{n}}" name="data[SaleProductAdditionalDetail][{{n}}][nominal]" readonly>
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">,00.</button>
    </span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right total" disabled id="total{{n}}">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">,00.</button>
    </span>
    </div>                             
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script>
    var purchaser = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    purchaser.clearPrefetchCache();
    purchaser.initialize(true);
    $('input.typeahead-ajax-purchaser').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'purchaser',
        display: 'full_name',
        source: purchaser.ttAdapter(),
        templates: {
            header: '<center><h5>Data Pembeli</h5></center><hr>',
            suggestion: function (context) {
                return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '<br/>Cabang : ' + context.branch_office + '</p>';
            },
            empty: [
                '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-purchaser').bind('typeahead:select', function (ev, suggestion) {
        $('.purchaserId').val(suggestion.id);
    });
</script>
<script>
    $(document).ready(function() {
        $("#initialBalance").hide();
        $("#paymentType").on("change", function() {
            var paymentTypeId = $(this).val();
            if(paymentTypeId == 2) {
                $("#initialBalance").show();
                $(".initBalance").removeAttr("disabled");
                $("#buyer").hide();
                $(".purchaserId").attr("disabled", "disabled");
            } else {
                $("#initialBalance").hide();
                $(".initBalance").attr("disabled", "disabled");
                $("#buyer").show();
                $(".purchaserId").removeAttr("disabled");
            }
        });
    });
</script>