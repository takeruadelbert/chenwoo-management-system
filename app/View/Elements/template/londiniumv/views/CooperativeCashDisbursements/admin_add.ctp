<?php echo $this->Form->create("CooperativeCashDisbursement", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PEMBELIAN - KOPERASI") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">                   
                    <li class="active" id="tab-step1"><a href="#justified-pill3" data-toggle="tab"><i class="fa fa-shopping-basket"></i> Pembelian Barang</a></li>
                    <li id="tab-step2"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Pembelian Barang</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade" id="justified-pill1">
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
                                                    echo $this->Form->input("CooperativeCashDisbursement.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("NIK"), array("class" => "col-sm-4 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.nip"), "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashDisbursement.cash_disbursement_number", __("Nomor Kas Keluar"), array("class" => "col-sm-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashDisbursement.created_date", __("Waktu Dibuat"), array("class" => "col-sm-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashDisbursement.created_date", array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">       
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashDisbursement.cooperative_cash_id", __("Kas Asal"), array("class" => "col-sm-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashDisbursement.cooperative_cash_id", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas Yang Digunakan -"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashDisbursement.supplier_id", __("Supplier"), array("class" => "col-sm-4 control-label"));
                                                    ?>
                                                    <div class="col-md-8 has-feedback">
                                                        <?php
                                                        echo $this->Form->input("typeahead.CooperativeCashDisbursement.cooperative_supplier_id", array("div" => array("class" => false), "type" => "text", "label" => false, "class" => "form-control typeahead-ajax-supplier"));
                                                        echo $this->Form->input("CooperativeCashDisbursement.cooperative_supplier_id", array("type" => "hidden", "class" => "check_supplierid"));
                                                        ?>
                                                        <i class="icon-search3 form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashDisbursement.bukti_pembelian", __("Bukti Bayar"), array("class" => "col-md-4 control-label"));
                                                    ?>
                                                    <div class="col-md-8">
                                                        <?php
                                                        echo $this->Form->input("CooperativeCashDisbursement.bukti_pembelian", array("div" => false, "label" => false, "class" => "form-control styled", "type" => "file"));
                                                        ?>
                                                        <span class="help-block">Format File Hanya Bisa: pdf, png, jpg. Dengan Ukuran File Maksimal 20Mb</span>
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
                                            echo $this->Form->label("CooperativeCashDisbursement.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                                        <input type="hidden" name="data[CooperativeCashDisbursementDetail][0][cooperative_good_list_id]" id="good0" class="check_goodlist">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <?= $this->Form->input("CooperativeCashDisbursementDetail.0.quantity", array("type" => "number", "div" => false, "label" => false, "class" => "form-control text-right inputquantity0 check_amount")) ?>
                                                    <span class="input-group-addon unit0" style="width:75px; text-align: left;"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control text-right isdecimal" id = "hargaSatuan0" data-price="0" name="data[CooperativeCashDisbursementDetail][0][amount]">
                                                    <span class="input-group-addon">,00.</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control text-right" id = "diskon0" data-diskon="0" value="0" name="data[CooperativeCashDisbursementDetail][0][discount]">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control text-right produkTotal auto-calculate-total0" name="data[CooperativeCashDisbursementDetail][0][total_amount]" readonly data-total="0" >
                                                    <span class="input-group-addon">,00.</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar')" data-n="1" data-k="0"><i class="icon-plus-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" align="right">
                                                <strong>Diskon</strong>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control text-right" id = "diskonTotal" data-diskon="0" value="0" name="data[CooperativeCashDisbursement][discount]">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" align="right">
                                                <strong>Grand Total</strong>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp.</span>
                                                    <input type="text" class="form-control text-right auto-calculate-grand-total" name="data[CooperativeCashDisbursement][grand_total]"readonly>
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
    $(document).ready(function () {
        /* cari nama barang */
        var good = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        good.clearPrefetchCache();
        good.initialize(true);
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
        var supplier = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?= Router::url("/admin/cooperative_suppliers/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
                filter: function (response) {
                    return response.data;
                },
            }
        });
        supplier.clearPrefetchCache();
        supplier.initialize(true);
        $('input.typeahead-ajax-supplier').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'supplier',
            display: 'name',
            source: supplier.ttAdapter(),
            templates: {
                header: '<center><h5>Data Supplier</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama Supplier : ' + context.name + '<br>No Telpon : ' + context.phone + '<br>Contact Person : ' + context.cp_name + '<br>Contact Person HP : ' + context.cp_hp + '</p>';
                },
                empty: [
                    '<center><h5>Data Supplier</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-supplier').bind('typeahead:select', function (ev, suggestion) {
            $("#CooperativeCashDisbursementCooperativeSupplierId").val(suggestion.id);
        });
        $("#formSubmit").on("submit", function () {
            var exit = true;
            if (!$("#CooperativeCashDisbursementCooperativeCashId").val()) {
                alert("Kas asal belum dipilih");
                exit = false;
            }
            $(".check_goodlist").each(function () {
                if (!$(this).val()) {
                    alert("Data barang belum diisi");
                    exit = false;
                }
            });
            $(".check_amount").each(function () {
                if (!$(this).val()) {
                    alert("Data jumlah barang belum diisi");
                    exit = false;
                }
            });
            return exit;
        })
        disableTab2();
    });


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
        $('#hargaSatuan' + k).val(IDR(e.capital_price));
        $('#hargaSatuan' + k).data("price", e.capital_price);
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
            $(".grandTotal").val(grandTotal);
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
        $(".grandTotal").val(result);
    });

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
        var good = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_good_lists/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        good.clearPrefetchCache();
        good.initialize(true);
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
            listenerBarang(suggestion, n);
            listenerTotalHarga(n);
            $(".unit" + n).html(suggestion.unit);
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
    <input type="hidden" name="data[CooperativeCashDisbursementDetail][{{n}}][cooperative_good_list_id]" id="good{{n}}" class="check_goodlist">
    </div>
    </div>
    </td>
    <td>
    <div class="input-group">
    <input type="number" name="data[CooperativeCashDisbursementDetail][{{n}}][quantity]" class="form-control text-right inputquantity{{n}}" class="check_amount">                                    
    <span class="input-group-addon unit{{n}}" style="width:75px; text-align: left;"></span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type="text" class="form-control text-right isdecimal" id= "hargaSatuan{{n}}" data-price="0" name="data[CooperativeCashDisbursementDetail][{{n}}][amount]">
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <input type="number" class="form-control text-right" id = "diskon{{n}}" data-diskon="0" value="0" name="data[CooperativeCashDisbursementDetail][{{n}}][discount]">
    <span class="input-group-addon"><strong>%</strong></span>
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type="text" class="form-control text-right produkTotal auto-calculate-total{{n}}" name="data[CooperativeCashDisbursementDetail][{{n}}][total_amount]"  data-total="0" readonly>
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>