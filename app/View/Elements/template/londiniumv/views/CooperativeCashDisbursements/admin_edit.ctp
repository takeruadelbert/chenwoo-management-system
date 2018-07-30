<?php echo $this->Form->create("CooperativeCashDisbursement", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH KAS KELUAR KASIR KOPERASI") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Kas Keluar</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Rincian Biaya Pengeluaran</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.cash_disbursement_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.created_date", __("Tanggal Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.created_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.creator_id", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.creator_id", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            echo $this->Form->input("CooperativeCashDisbursement.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.position", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.Office.name"), "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.cooperative_cash_id", __("Kas yang digunakan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.cooperative_cash_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "--Pilih Kas Yang Digunakan--", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill3">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Pengeluaran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th width="300">Bukti</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["CooperativeCashDisbursementDetail"]);
                                foreach ($this->data["CooperativeCashDisbursementDetail"] as $i => $value) {
                                    ?>
                                    <tr>
                                        <td class="text-center nomorIdx">
                                            <?= $no; ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("CooperativeCashDisbursementDetail.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            ?>
                                            <div class="has-feedback">
                                                <div>                                                
                                                    <input type="text" class="form-control typeahead-ajax-barang0" id="typeaheadBarang0" placeholder="Cari Nama Barang ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[CooperativeCashDisbursementDetail][0][cooperative_good_list_id]" id="good0" value="">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Rp.</button>
                                                </span>
                                                <?php
                                                echo $this->Form->input("CooperativeCashDisbursementDetail.$i.amount", array("div" => false, "label" => false, "type" => "text", "class" => "form-control text-right isdecimal"));
                                                ?>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashDisbursementDetail.$i.date", array("div" => false, "label" => false, "class" => "form-control datepicker text-right", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <input type="file" name="data[CooperativeCashDisbursementDetail][<?= $i ?>][gambar]" class="form-control" id="files">
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="6">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar', 'anakOptions')" data-n="<?= $dataN ?>"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /justified pills -->
        <div class="text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="reset" value="Reset" class="btn btn-info">
            <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                <?= __("Simpan") ?>
            </button>
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
        });
    });


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
            if($quantity == '' && $quantity == null) {
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
            $("#diskonTotal").trigger("keyup");
        });
        
        $('#diskon' + n).on("change keyup", function() {
            var grandTotal = 0;
            var quantity = $('.inputquantity' + n).val();
            var diskon;
            if($(this).val() == '' || $(this).val() == null) {
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
        
        $("#hargaSatuan" + n).on("change keyup", function() {
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
    
    $('#diskonTotal').on("change keyup", function() {
        var temp = 0;
        $(".produkTotal").each(function() {
            temp += parseInt(replaceAll(String($(this).val()), ".", ""));
        });
        var diskon = 0;
        if($(this).val() != '' && $(this).val() != null) {
            diskon = parseFloat($(this).val());
        }
        var grandTotal = temp;
        var diskonTemp = parseInt(grandTotal * (diskon / 100));
        var result = grandTotal - diskonTemp;
        $("input.auto-calculate-grand-total").val(IDR(result));
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
    <input type="hidden" name="data[CooperativeCashDisbursementDetail][{{n}}][cooperative_good_list_id]" id="good{{n}}">
    </div>
    </div>
    </td>
    <td>
    <input type="number" name="data[CooperativeCashDisbursementDetail][{{n}}][quantity]" class="form-control text-right inputquantity{{n}}">                                    
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