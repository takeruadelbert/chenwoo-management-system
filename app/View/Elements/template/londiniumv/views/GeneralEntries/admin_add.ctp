<?php echo $this->Form->create("GeneralEntry", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Transaksi Umum") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Transaksi Umum") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("GeneralEntry.reference_number", __("Nomor Referensi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("GeneralEntry.reference_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("GeneralEntry.transaction_date", __("Tanggal Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("GeneralEntry.transaction_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("GeneralEntry.transaction_type_id", __("Jenis Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("GeneralEntry.transaction_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", 'empty' => "", "placeholder" => "- Pilih -"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("GeneralEntry.general_entry_account_type_id", __("Kode Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("GeneralEntry.general_entry_account_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6 exchangeRate">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4">
                                                <label>Kurs</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default rupiah" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal inputExchangeRate" name="data[GeneralEntry][exchange_rate]" disabled>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default rupiah" type="button">,00.</button>
                                                    </span>
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
                                    <label class="col-sm-2 control-label">Keterangan : </label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" cols="5" class="limited form-control" name="data[GeneralEntry][note]" data-tip-limit="limit-text1"></textarea>
                                    </div>
                                </div>                           
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="block-inner text-danger">
                            <center>
                                <h6 class="heading-hr">DATA TRANSAKSI DEBIT</h6>
                            </center>
                        </div>
                        <table class="table table-hover table-bordered stn-table transactionTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Akun</th>
                                    <th width="220">Nominal</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-data-debit">
                                <tr>
                                    <td colspan="4">
                                        <a class="text-success runonce" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-data-debit', 'generalEntry')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="block-inner text-danger">
                            <center>
                                <h6 class="heading-hr">DATA TRANSAKSI KREDIT</h6>
                            </center>
                        </div>
                        <table class="table table-hover table-bordered stn-table transactionTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Akun</th>
                                    <th width="220">Nominal</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-data-credit">
                                <tr>
                                    <td colspan="4">
                                        <a class="text-success runonce" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-data-credit', 'generalEntry')" data-n="2"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" data-j="1" id="globalVariable">
                <input type="hidden" data-currency-type="rupiah" id="currencyType">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->label("GeneralEntry.total_debit", __("Total Debit"), array("class" => "col-sm-3 col-md-4 control-label"));
                        ?>
                        <div class="col-sm-9 col-md-8">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Rp.</button>
                                </span>
                                <input type="text" class="form-control text-right totalDebit" name="data[GeneralEntry][total_debit]" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->label("GeneralEntry.total_credit", __("Total Kredit"), array("class" => "col-sm-3 col-md-4 control-label"));
                        ?>
                        <div class="col-sm-9 col-md-8">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Rp.</button>
                                </span>
                                <input type="text" class="form-control text-right totalCredit" name="data[GeneralEntry][total_credit]" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">,00.</button>
                                </span>
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
</div>
<?php echo $this->Form->end() ?>
<?= $this->Form->input(false, ["options" => $generalEntryTypes, "label" => false, "hidden" => true, "id" => "coaList", "empty" => "", "placeholder" => "-Pilih COA-"]) ?>
<script>
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var j = $("#globalVariable").data('j');
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, j: j};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 2);
        $("#globalVariable").data("j", j + 1);
        $(".tempDollar" + n).hide();
        reloadSelect2();
        reloadisdecimal();
        reloadisdecimaldollar();
        reloadStyled();
        fixNumber($(e).parents("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function getTotalDebit(n) {
        var totalDebit = 0;
        $.each($(".debit"), function (index, value) {
            if ($("#coa" + n).val() != null && $("#coa" + n).val() != "") {
                if ($("#debit" + n).parent().parent().parent().find(".dataCurrency").html() == 'rupiah') {
                    totalDebit += parseInt(replaceAll($(this).val(), ".", ""));
                } else {
                    if ($(".inputExchangeRate").val() != 0) {
                        var exchange_rate = parseInt(replaceAll($(".inputExchangeRate").val(), ".", ""));
                        var total = parseFloat(replaceAll($(this).val(), ",", "")) * exchange_rate;
                        totalDebit += total;
                    } else {
                        notif("warning", "Kurs Tidak Boleh Kosong", "growl");
                        $(".inputExchangeRate").focus();
                        return false;
                    }
                }
            } else {
                notif("warning", "Pilih COA Dulu", "growl");
                $("#debit" + n).val(0);
                $("#coa" + n).select2("open");
                return false;
            }
        });
        $(".totalDebit").val(ic_rupiah(totalDebit));
    }

    function getTotalCredit(n) {
        var totalCredit = 0;
//        var i = 2;
        $.each($(".credit"), function (index, value) {
            if ($("#coa" + n).val() != null && $("#coa" + n).val() != "") {
                if ($("#credit" + n).parent().parent().prev().find('td:last-child').html() != null) {
                    if ($("#coa" + n).parent().parent().prev().find("td:last-child").html() == 'rupiah') {
                        totalCredit += parseInt(replaceAll($(this).val(), ".", ""));
                    } else {
                        if ($(".inputExchangeRate").val() != 0) {
                            var exchange_rate = parseInt(replaceAll($(".inputExchangeRate").val(), ".", ""));
                            var total = parseFloat(replaceAll($(this).val(), ",", "")) * exchange_rate;
                            totalCredit += total;
                        } else {
                            notif("warning", "Kurs Tidak Boleh Kosong", "growl");
                            $(".inputExchangeRate").focus();
                            return false;
                        }
                    }
                } else {
                    if ($("#coa" + n).parent().parent().find("td:last-child").html() == 'rupiah') {
                        totalCredit += parseInt(replaceAll($(this).val(), ".", ""));
                    } else {
                        if ($(".inputExchangeRate").val() != 0) {
                            var exchange_rate = parseInt(replaceAll($(".inputExchangeRate").val(), ".", ""));
                            var total = parseFloat(replaceAll($(this).val(), ",", "")) * exchange_rate;
                            totalCredit += total;
                        } else {
                            notif("warning", "Kurs Tidak Boleh Kosong", "growl");
                            $(".inputExchangeRate").focus();
                            return false;
                        }
                    }
                }
//                i = i + 2;
            } else {
                notif("warning", "Pilih COA Dulu", "growl");
                $("#credit" + n).val(0);
                $("#coa" + n).select2("open");
                return false;
            }
        });
        $(".totalCredit").val(ic_rupiah(totalCredit));
    }

    function generalEntry() {
        return {coaList: $("#coaList").html()};
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function changeCOACurrency(n) {
        if ($("#coa" + n).val() != "" && $("#coa" + n).val() != null) {
            var element = $("#coa" + n);
            var coa_id = $("#coa" + n).val();
            $.ajax({
                url: BASE_URL + "admin/general_entry_types/get_currency_id/" + coa_id,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (response) {
                    var data_currency = "";
                    if ($(element).parent().parent().prev().html() == null) {
                        if (response.data == '1') {
                            $(element).closest('td').next().find(".rupiah").show();
                            $(element).closest('td').next().find(".dollar").hide();
                            $(element).closest('td').next().find(".tempRupiah" + n).show();
                            $(element).closest('td').next().find(".inputRupiah").removeAttr("disabled");
                            $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').removeAttr("disabled");
                            $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').val("rupiah");
                            $(element).closest('td').next().find(".tempDollar" + n).hide();
                            $(element).closest('td').next().find(".inputDollar").attr("disabled", "disabled");
                            $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').attr("disabled", "disabled");
                            $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').attr("disabled", "disabled");
                            $(element).closest('td').next().find(".inputDollar").val(0);
                            $(element).closest('td').next().find(".inputRupiah").val(0);
                            $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right isdecimal inputDollar");
                            if ($(element).parent().parent().parent().attr("id") == "target-detail-data-debit") {
                                $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right debit isdecimal inputRupiah");
                            } else {
                                $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right credit isdecimal inputRupiah");
                            }
//                            $(element).closest('td').next().find(".inputRupiah").attr("id", "debitRupiah" + n);
                            $("#currencyType").data("currency-type", 'rupiah');
                            data_currency = "rupiah";
                        } else {
                            $(element).closest('td').next().find(".rupiah").hide();
                            $(element).closest('td').next().find(".dollar").show();
                            $(element).closest('td').next().find(".tempRupiah" + n).hide();
                            $(element).closest('td').next().find(".tempDollar" + n).show();
                            $(element).closest('td').next().find(".tempDollar" + n).attr("style", "margin-top:0px;");
                            $(element).closest('td').next().find(".inputRupiah").attr("disabled", "disabled");
                            $(element).closest('td').next().find(".inputDollar").removeAttr("disabled");
                            $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').removeAttr("disabled");
                            $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').removeAttr("disabled");
                            $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').val("dollar");
                            $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').attr("disabled", "disabled");
                            $(element).closest('td').next().find(".inputRupiah").val(0);
                            $(element).closest('td').next().find(".inputDollar").val(0);
                            $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right isdecimaldollar inputRupiah");
                            if ($(element).parent().parent().parent().attr("id") == "target-detail-data-debit") {
                                $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right debit isdecimal inputDollar");
                            } else {
                                $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right credit isdecimal inputDollar");
                            }
//                            $(element).closest('td').next().find(".inputDollar").attr("id", "creditDollar" + n);
                            $("#currencyType").data("currency-type", 'dollar');
                            data_currency = "dollar";
                        }
                        $(element).parent().parent().find(".dataCurrency").text(data_currency);
                    } else {
                        var currency;
                        var temp;
                        if (response.data == '2') {
                            currency = "dollar";
                            temp = ".tempDollar";
                        } else {
                            currency = "rupiah";
                            temp = ".tempRupiah";
                        }
                        if ($(element).parent().parent().prev().find("td:last-child").html() == currency) {
                            if (response.data == '1') {
                                $(element).closest('td').next().find(".rupiah").show();
                                $(element).closest('td').next().find(".dollar").hide();
                                $(element).closest('td').next().find(".tempRupiah" + n).show();
                                $(element).closest('td').next().find(".inputRupiah").removeAttr("disabled");
                                $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').removeAttr("disabled");
                                $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').val("rupiah");
                                $(element).closest('td').next().find(".tempDollar" + n).hide();
                                $(element).closest('td').next().find(".inputDollar").attr("disabled", "disabled");
                                $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').attr("disabled", "disabled");
                                $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').attr("disabled", "disabled");
                                $(element).closest('td').next().find(".inputDollar").val(0);
                                $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right isdecimal inputDollar");
                                if ($(element).parent().parent().parent().attr("id") == "target-detail-data-debit") {
                                    $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right debit isdecimal inputRupiah");
                                } else {
                                    $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right credit isdecimal inputRupiah");
                                }
//                                $(element).closest('td').next().find(".inputRupiah").attr("id", "debitRupiah" + n);
                                $("#currencyType").data("currency-type", 'rupiah');
                                data_currency = "rupiah";
                            } else {
                                $(element).closest('td').next().find(".rupiah").hide();
                                $(element).closest('td').next().find(".dollar").show();
                                $(element).closest('td').next().find(".tempRupiah" + n).hide();
                                $(element).closest('td').next().find(".tempDollar" + n).show();
                                $(element).closest('td').next().find(".tempDollar" + n).attr("style", "margin-top:0px;");
                                $(element).closest('td').next().find(".inputRupiah").attr("disabled", "disabled");
                                $(element).closest('td').next().find(".inputRupiah").next('input[type=hidden]').attr("disabled", "disabled");
                                $(element).closest('td').next().find(".inputDollar").removeAttr("disabled");
                                $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').removeAttr("disabled");
                                $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').removeAttr("disabled");
                                $(element).closest('td').next().find(".inputDollar").next('input[type=hidden]').next('input[type=hidden]').val("dollar");
                                $(element).closest('td').next().find(".inputRupiah").val(0);
                                $(element).closest('td').next().find(".inputRupiah").attr("class", "form-control text-right isdecimaldollar inputRupiah");
                                if ($(element).parent().parent().parent().attr("id") == "target-detail-data-debit") {
                                    $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right debit isdecimal inputDollar");
                                } else {
                                    $(element).closest('td').next().find(".inputDollar").attr("class", "form-control text-right credit isdecimal inputDollar");
                                }
//                                $(element).closest('td').next().find(".inputDollar").attr("id", "creditDollar" + n);
                                $("#currencyType").data("currency-type", 'dollar');
                                data_currency = "dollar";
                            }
                            $(element).parent().parent().find(".dataCurrency").text(data_currency);
                        } else {
                            notif("warning", "Mata Uang Harus Sama Per Baris", "growl");
                            $(element).parent().parent().remove();
                            return false;
                        }
                    }

                    var is_dollar = false;
                    $(".transactionTable td.dataCurrency").each(function (index, value) {
                        if ($(this).html() == "dollar") {
                            $(".exchangeRate").show();
                            $(".inputExchangeRate").removeAttr("disabled");
                            is_dollar = true;
                        }
                    });
                    if (!is_dollar) {
                        $(".exchangeRate").hide();
                        $(".inputExchangeRate").attr("disabled", "disabled");
                    }
                }
            });
        }
    }

    $(document).ready(function () {
        $(".runonce").trigger("click");
        $(".exchangeRate").hide();


    });
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-data-debit">
    <tr id="data">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select name="data[GeneralEntryDebit][{{n}}][general_entry_type_id]" class="select-full coa" placeholder="- Pilih COA-" id="coa{{n}}" onchange="changeCOACurrency({{n}})">
    {{{coaList}}}
    </select>
    <input type="hidden" name="data[GeneralEntryDebit][{{n}}][is_debit]" value="debit">
    </td>
    <td>
    <div class="input-group tempRupiah{{n}}">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right isdecimal debit inputRupiah" name="data[GeneralEntryDebit][{{n}}][debit]" id="debit{{n}}" onkeyup="getTotalDebit({{n}})" data-currency="rupiah">
    <input type="hidden" name="data[GeneralEntryDebit][{{n}}][currency]">
    <span class="input-group-btn">
    <button class="btn btn-default rupiah" type="button">,00.</button>
    </span>
    </div>
    <div class="input-group tempDollar{{n}}">
    <span class="input-group-btn">
    <button class="btn btn-default dollar" type="button">$</button>
    </span>
    <input type="text" class="form-control text-right isdecimaldollar debit inputDollar" name="data[GeneralEntryDebit][{{n}}][debit]" id="debit{{n}}" onkeyup="getTotalDebit({{n}})" data-currency="dollar" disabled>
    <input type="hidden" name="data[GeneralEntryDebit][{{n}}][currency]" disabled>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this));getTotalDebit({{n}})"><i class="icon-remove3"></i></a>
    </td>
    <td class="dataCurrency hidden"></td>
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-detail-data-credit">
    <tr id="data">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select name="data[GeneralEntryCredit][{{n}}][general_entry_type_id]" class="select-full coa" placeholder="- Pilih COA-" id="coa{{n}}" onchange="changeCOACurrency({{n}})">
    {{{coaList}}}
    </select>
    <input type="hidden" name="data[GeneralEntryCredit][{{n}}][is_credit]" value="credit">
    </td>
    <td>
    <div class="input-group tempRupiah{{n}} tempRupiah">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right isdecimal credit inputRupiah" name="data[GeneralEntryCredit][{{n}}][credit]" id="credit{{n}}" onkeyup="getTotalCredit({{n}})" data-currency="rupiah">
    <input type="hidden" name="data[GeneralEntryCredit][{{n}}][currency]">
    <span class="input-group-btn">
    <button class="btn btn-default rupiah" type="button">,00.</button>
    </span>
    </div>
    <div class="input-group tempDollar{{n}} tempDollar">
    <span class="input-group-btn">
    <button class="btn btn-default dollar" type="button">$</button>
    </span>
    <input type="text" class="form-control text-right isdecimaldollar credit inputDollar" name="data[GeneralEntryCredit][{{n}}][credit]" id="credit{{n}}" onkeyup="getTotalCredit({{n}})" data-currency="dollar">
    <input type="hidden" name="data[GeneralEntryCredit][{{n}}][currency]" disabled>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this));getTotalCredit({{n}})"><i class="icon-remove3"></i></a>
    </td>
    <td class="dataCurrency hidden"></td>
    </tr>
</script>