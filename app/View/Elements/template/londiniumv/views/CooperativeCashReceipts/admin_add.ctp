<?php echo $this->Form->create("CooperativeCashReceipt", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PENJUALAN - KOPERASI") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">                    
                    <li class="active" id="tab-step1"><a href="#justified-pill3" data-toggle="tab" ><i class="fa fa-shopping-bag"></i> Rincian Penjualan Barang</a></li>
                    <li id="tab-step2"><a href="#justified-pill1" data-toggle="tab"  ><i class="icon-file6"></i> Data Penjualan</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade" id="justified-pill1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table width="100%" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                            
                                                            <?php
                                                            echo $this->Form->label(null, __("Pegawai Pelaksana"), array("class" => "col-sm-4 control-label"));
                                                            echo $this->Form->input(null, array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label(null, __("NIK Pelaksana"), array("class" => "col-sm-4 control-label"));
                                                            echo $this->Form->input(null, array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.nip"), "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <?php
                                                            echo $this->Form->label("CooperativeCashReceipt.reference_number", __("Nomor Transaksi"), array("class" => "col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeCashReceipt.reference_number", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                                            ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php
                                                            echo $this->Form->label("CooperativeCashReceipt.date", __("Waktu Dibuat"), array("class" => "col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeCashReceipt.date", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <?php
                                                            echo $this->Form->label("CooperativeCashReceipt.operator_id", __("Operator"), array("class" => "col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeCashReceipt.operator_id", array("div" => array("class" => "col-md-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                                            echo $this->Form->input("CooperativeCashReceipt.operator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                                            ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php
                                                            echo $this->Form->label("CooperativeCashReceipt.cooperative_cash_id", __("Kas Tujuan"), array("class" => "col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeCashReceipt.cooperative_cash_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas Yang Digunakan -"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">  
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <?php
                                                            echo $this->Form->label("CooperativeCashReceipt.cooperative_payment_type_id", __("Jenis Pembayaran"), array("class" => "col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeCashReceipt.cooperative_payment_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full paymentType"));
                                                            ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class = "col-md-4 control-label">
                                                                <label> Grand Total</label>
                                                            </div>
                                                            <div class = "col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">Rp.</span>
                                                                    <input type="text" class="form-control text-right grandTotal" name ="data[CooperativeCashReceipt][grand_total]" readonly data-grandtotal="0">
                                                                    <span class="input-group-addon">,00.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class = "tipePembayaran">
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class = "col-md-4 control-label">
                                                                <label> Nominal Bayar </label>
                                                            </div>
                                                            <div class = "col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">Rp.</span>
                                                                    <input type="text" class="form-control text-right totalPayment isdecimal" name ="data[Dummy][total_payment]">
                                                                    <span class="input-group-addon">,00.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class = "col-md-4 control-label">
                                                                <label> Kembalian </label>
                                                            </div>
                                                            <div class = "col-md-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">Rp.</span>
                                                                    <input type="text" class="form-control text-right kembalian" name ="data[Dummy][change_payment]" readonly>
                                                                    <span class="input-group-addon">,00.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class = "namaPegawai">
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-md-4 control-label">
                                                                <label>Nama Pegawai</label>
                                                            </div>
                                                            <div class="col-md-8">   
                                                                <div class="has-feedback">                                             
                                                                    <input type="text" class="form-control typeahead-ajax-employee" placeholder="Cari Nama Pegawai ...">
                                                                    <i class="icon-search3 form-control-feedback"></i>
                                                                    <input type="hidden" name="data[EmployeeDataLoan][employee_id]" id="employee" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashReceipt.note", __("Keterangan"), array("class" => "col-md-2 control-label"));
                                                    echo $this->Form->input("CooperativeCashReceipt.note", array("div" => array("class" => "col-md-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>     
                        <div class="text-center">
                            <input type="button" value="Kembali" onclick="step1()" class="btn btn-success">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                <?= __("Simpan") ?>
                            </button>
                        </div>
                    </div>                    
                    <div class="tab-pane fade in active" id="justified-pill3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-hover table-bordered stn-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama Barang</th>
                                            <th width="175">Stok</th>
                                            <th width="175">Jumlah</th>
                                            <th width="200">Harga Satuan</th>
                                            <th width="125">Diskon</th>
                                            <th width="200">Total</th>
                                            <th width="50">Aksi</th>
                                        </tr>
                                    <thead>
                                    <tbody id="target-detail-kas-keluar">
                                        <tr>
                                            <td class="text-center nomorIdx">
                                                1
                                            </td>
                                            <td>
                                                <div class="has-feedback">
                                                    <div>                                                
                                                        <input type="text" class="form-control typeahead-ajax-barang0" id="typeaheadBarang0" placeholder="Cari Nama Barang ...">
                                                        <i class="icon-search3 form-control-feedback"></i>
                                                        <input type="hidden" name="data[CooperativeCashReceiptDetail][0][cooperative_good_list_id]" id="good0">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?= $this->Form->input("Dummy.0.stock", array("type" => "number", "div" => false, "label" => false, "class" => "form-control text-right", "disabled" => true)) ?>
                                                    <span class="input-group-addon unit0" style="width:75px; text-align: left;"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?= $this->Form->input("CooperativeCashReceiptDetail.0.quantity", array("type" => "number", "div" => false, "label" => false, "class" => "form-control text-right inputquantity0", "min" => 0)) ?>
                                                    <span class="input-group-addon unit0" style="width:75px; text-align: left;"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("CooperativeCashReceiptDetail.0.price", array("type" => "text", "div" => false, "label" => false, "class" => "form-control text-right isdecimal rupiah-field", "data-price" => 0, "id" => "hargaSatuan0")) ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control text-right" id = "diskon0" data-diskon="0" value="0" name="data[CooperativeCashReceiptDetail][0][discount]">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control text-right produkTotal auto-calculate-total0" name="data[CooperativeCashReceiptDetail][0][total_amount]" readonly data-total="0" >
                                                    <span class="input-group-addon">,00.</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar')" data-n="1" data-k="0"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" align="right">
                                                <strong>Diskon</strong>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control text-right" id = "diskonTotal" data-diskon="0" value="0" name="data[CooperativeCashReceipt][discount]">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" align="right">
                                                <strong>Grand Total</strong>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control text-right auto-calculate-grand-total" name="data[CooperativeCashReceipt][grand_total]" readonly value="0">
                                                    <span class="input-group-addon">,00.</span>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>     
                        <div class="text-center">
                            <input type="button" value="Next" onclick="step2()" class="btn btn-danger">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var good = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: false,
        remote: {
            url: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    good.clearPrefetchCache();
    good.initialize(true);
    $(document).ready(function () {
        /* Cari Nama Pegawai */
        $('.tipePembayaran').hide();
        $('.namaPegawai').hide();
        $('.jenisAngsuran').hide();
        listenerTipePembayaran();
        listenerKembalian();
        var employee = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        employee.clearPrefetchCache();
        employee.initialize(true);
        $('input.typeahead-ajax-employee').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employee',
            display: 'full_name',
            source: employee.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-employee').bind('typeahead:select', function (ev, suggestion) {
            $("#employee").val(suggestion.id);
        });
        /* cari nama barang */
        $('input.typeahead-ajax-barang0').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'good',
            display: 'name',
            source: good.ttAdapter(),
            templates: {
                header: '<center><h5>Data Barang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama : ' + context.name + '<br>Kode Barang : ' + context.good_code + '<br>Barcode : ' + context.barcode + '<br>Harga Jual : ' + RP(context.price) + '<br>Harga Modal : ' + RP(context.capital_price) + '<br>Kategori : ' + context.category_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Barang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-barang0').bind('typeahead:select', function (ev, suggestion) {
            listenerBarang(suggestion, 0);
            listenerTotalHarga(0);
            $(".unit0").html(suggestion.unit);
        });

        $(".installment").on("click", function () {
            updateBunga();
        })

        $("#CooperativeCashReceiptCooperativePaymentTypeId").on("select2-selected", function () {
            var paymentType = $(this).val();
            if (paymentType == 2) {
//                updateBunga();
            }
        });
        $("#CooperativeCashReceiptCooperativePaymentTypeId").val("1").trigger("change");
        disableTab2();
    });

    function updateBunga() {
        $.ajax({
            url: BASE_URL + "admin/cooperative_loan_interests/get_loan_interest_item/" + $(".grandTotal").data("grandtotal"),
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                var installment = $('.installment:checked').val();
                console.log(installment);
                var interest = response.data.interest;
                var nilaibungaangsuran = Math.floor(parseInt($(".grandTotal").data("grandtotal")) * interest / 100 * installment / 12);
                $(".bungaAngsuran").val(interest);
                $(".totalsetelahbunga").val(IDR(nilaibungaangsuran + parseInt($(".grandTotal").data("grandtotal"))));
                $("#cooperative_loan_interest_id").val(response.data.id)
            }
        })
    }

    function step1() {
        disableTab2();
        enableTab1();
        gotoTab1();
    }

    function step2() {
        disableTab1();
        enableTab2();
        gotoTab2();
    }

    function disableTab1() {
        $("#tab-step1").addClass("disabled");
        $("#tab-step1 a").on("click", function (e) {
            return false;
        });
    }

    function disableTab2() {
        $("#tab-step2").addClass("disabled");
        $("#tab-step2 a").on("click", function (e) {
            return false;
        });
    }

    function enableTab1() {
        $("#tab-step1").removeClass("disabled");
        $("#tab-step1 a").unbind("click");
    }

    function enableTab2() {
        $("#tab-step2").removeClass("disabled");
        $("#tab-step2 a").unbind("click");
    }

    function gotoTab1() {
        $("#tab-step1 a").trigger("click");
    }
    function gotoTab2() {
        $("#tab-step2 a").trigger("click");
    }

    function listenerBarang(e, k) {
        $('#good' + k).val(e.id);
        $('#hargaSatuan' + k).val(IDR(e.price));
        $('#hargaSatuan' + k).data("price", e.price);
        $('#Dummy' + k + 'Stock').val(e.stock_number);
    }

    function listenerTotalHarga(n) {
        $('.inputquantity' + n).on("change keyup", function () {
            var total = 0;
            var grandTotal = 0;
            var price = $('#hargaSatuan' + n).data("price");

            $quantity = $(this).val();
            if ($quantity == '' && $quantity == null) {
                $quantity = 0;
            }
            $thisTotal = String($quantity * price);
            total = $thisTotal;
            $("input.auto-calculate-total" + n).val(IDR(total));
            $("input.auto-calculate-total" + n).data("total", total);
            $('input.produkTotal').each(function () {
                grandTotal += parseInt($(this).data("total"));
            });
            $("input.auto-calculate-grand-total").val(IDR(grandTotal));
            $(".grandTotal").data("grandtotal", grandTotal);
            $(".grandTotal").val(IDR(grandTotal));
            $("#diskonTotal").trigger("keyup");
        });

        $('#diskon' + n).on("change keyup", function () {
            var grandTotal = 0;
            var quantity = $('.inputquantity' + n).val();
            var diskon;
            if ($(this).val() == '' || $(this).val() == null) {
                diskon = 0;
            } else {
                diskon = parseFloat($(this).val());
            }
            var hargaSatuan = String($("#hargaSatuan" + n).val());
            var total = $('.inputquantity' + n).val() * replaceAll(hargaSatuan, ".", "");
            var diskonTemp = total * (diskon / 100);
            var result = total - diskonTemp;
            $("input.auto-calculate-total" + n).val(IDR(result));
            $("input.auto-calculate-total" + n).data("total", result);
            $('input.produkTotal').each(function () {
                grandTotal += parseInt($(this).data("total"));
            });
            $("input.auto-calculate-grand-total").val(IDR(grandTotal));
            $(".grandTotal").val(IDR(grandTotal));
            $("#diskonTotal").trigger("keyup");
        });

        $("#hargaSatuan" + n).on("change keyup", function () {
            var grandTotal = 0;
            var jumlah = $(".inputquantity" + n).val();
            var diskon = $("#diskon" + n).val();
            var hargaSatuan = parseInt(replaceAll(String($(this).val()), ".", ""));
            var total = jumlah * hargaSatuan;
            var temp = total * (diskon / 100);
            var result = total - temp;
            $("input.auto-calculate-total" + n).val(IDR(result));
            $("input.auto-calculate-total" + n).data("total", result);
            $('input.produkTotal').each(function () {
                grandTotal += parseInt($(this).data("total"));
            });
            $("input.auto-calculate-grand-total").val(IDR(grandTotal));
            $(".grandTotal").val(IDR(grandTotal));
            $("#diskonTotal").trigger("keyup");
        })
    }

    $('#diskonTotal').on("change keyup", function () {
        var temp = 0;
        $(".produkTotal").each(function () {
            temp += parseInt(replaceAll(String($(this).val()), ".", ""));
        });
        var diskon = 0;
        if ($(this).val() != '' && $(this).val() != null) {
            diskon = parseFloat($(this).val());
        }
        var grandTotal = temp;
        var diskonTemp = parseInt(grandTotal * (diskon / 100));
        var result = grandTotal - diskonTemp;
        $("input.auto-calculate-grand-total").val(IDR(result));
        $(".grandTotal").val(IDR(result));
    });

    function listenerKembalian() {
        $('.totalPayment').on("keyup", function () {
            var grandTotal = $(".grandTotal").val();
            var totalPayment = $(this).val();
            $grandTotals = replaceAll(grandTotal, '.', '');
            $totalPayments = replaceAll(totalPayment, '.', '');
            var kembalian = parseInt($totalPayments - $grandTotals);
            $(".kembalian").val(IDR(kembalian));
        });
    }

    function listenerTipePembayaran() {
        $('.paymentType').on("change", function () {
            var type = $(".paymentType :selected").text();
            if (type == "Kredit") {
                $('.namaPegawai').show();
                $('.jenisAngsuran').show();
                $('.tipePembayaran').hide();
                $("#CooperativeCashReceiptCooperativeCashId").attr("disabled", "disabled");
                $("#employee").removeAttr("disabled");
            } else if (type == "Tunai") {
                $('.namaPegawai').hide();
                $('.jenisAngsuran').hide();
                $('.tipePembayaran').show();
                $("#employee").attr("disabled", "disabled");
                $("#CooperativeCashReceiptCooperativeCashId").removeAttr("disabled");
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        var grandTotal = 0;
        e.parents("tr").remove();
        fixNumber(tbody);
        var k = $(".dataN").data("k");
        $('input.produkTotal').each(function () {
            grandTotal += parseInt($(this).data("total"));
        });
        $("input.auto-calculate-grand-total").val(IDR(grandTotal));
        $(".grandTotal").val(grandTotal);
        $("#diskonTotal").trigger("keyup");
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var k = $(e).data("k");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, k: k};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        $(e).data("k", k + 1);
        reloadDatePicker();
        reloadSelect2();
        reloadisdecimal()
        fixNumber($(e).parents("tbody"));
        $('input.typeahead-ajax-barang' + n).typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'good',
            display: 'name',
            source: good.ttAdapter(),
            templates: {
                header: '<center><h5>Data Barang</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama : ' + context.name + '<br>Kode Barang : ' + context.good_code + '<br>Barcode : ' + context.barcode + '<br>Harga Jual : Rp. ' + IDR(context.price) + ',00.' + '<br>Harga Modal : Rp. ' + IDR(context.capital_price) + ',00.' + '<br>Kategori : ' + context.category_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Barang</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-barang' + n).bind('typeahead:select', function (ev, suggestion) {
            $(".unit" + n).html(suggestion.unit);
            listenerBarang(suggestion, n);
            listenerTotalHarga(n);
        });
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <div class="has-feedback">
    <div>                                                
    <input type="text" class="form-control typeahead-ajax-barang{{n}}" id="typeaheadBarang{{n}}" placeholder="Cari Nama Barang ...">
    <i class="icon-search3 form-control-feedback"></i>
    <input type="hidden" name="data[CooperativeCashReceiptDetail][{{n}}][cooperative_good_list_id]" id="good{{n}}">
    </div>
    </div>
    </td>
    <td>
    <div class="input-group">
    <input name="data[Dummy][{{n}}][stock]" value="{{stock_number}}" class="form-control text-right" disabled="disabled" type="number" id="Dummy{{n}}Stock">                                    
    <span class="input-group-addon unit{{n}}" style="width:75px; text-align: left;"></span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <input min="0" type="number" name="data[CooperativeCashReceiptDetail][{{n}}][quantity]" class="form-control text-right inputquantity{{n}}">                                    
    <span class="input-group-addon unit{{n}}" style="width:75px; text-align: left;"></span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type="text" class="form-control text-right isdecimal" id= "hargaSatuan{{n}}" data-price="0" name="data[CooperativeCashReceiptDetail][{{n}}][price]">
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <input type="number" class="form-control text-right" id = "diskon{{n}}" data-diskon="0" value="0" name="data[CooperativeCashReceiptDetail][{{n}}][discount]">
    <span class="input-group-addon"><strong>%</strong></span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type="text" class="form-control text-right produkTotal auto-calculate-total{{n}}" name="data[CooperativeCashReceiptDetail][{{n}}][total_amount]"  data-total="0" readonly>
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>