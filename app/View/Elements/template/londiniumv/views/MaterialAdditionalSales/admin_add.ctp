<?php echo $this->Form->create("MaterialAdditionalSale", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Penjualan Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penjualan Material Pembantu") ?></h6>
                    </div>
                    <table width="100%" class="table table-hover">
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.sale_dt", __("Tanggal Penjualan"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.sale_dt", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control datepicker"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.supplier_id", __("Pembeli"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.supplier_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Supplier -"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu yang Dijual") ?></h6>
                    </div>
                    <table width="100%" class="table table-hover table-bordered stn-table">
                        <thead>
                            <tr>
                                <th width="50px">No</th>
                                <th width="20%">Nama Barang</th>
                                <th width="20%">Stock</th>
                                <th width="20%">Jumlah</th>
                                <th width="25%">Harga</th>
                                <th width="25%">Total</th>
                                <th width="50px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="target-product-data">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'product-data', '')" data-n="1"><i class="icon-plus-circle"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right">
                                    <strong>Grand Total</strong>
                                </td>
                                <td colspan="1">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" id="grandTotal" name="data[MaterialAdditionalSale][total]" readonly>
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
    var count = 0;
    var data_product = <?= json_encode($materialAdditionals) ?>;
    $(document).ready(function () {
        addThisRow(".firstrunclick", 'product-data', '');
    });

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        var n = $(".dataN0").data("n");
        e.parents("tr").remove();
        count--;
        fixNumber(tbody);
        updateTotal(n);
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
        var options = {
            i: 2,
            n: n,
            data_product: data_product
        };
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        count++;
    }

    function change_unit(n) {
        var unit = $("#selectProduct" + n).find(":selected").data("unit");
        var stock = $("#selectProduct" + n).find(":selected").data("stock");
        $("#unit" + n).html(unit);
        $("#unitStock" + n).html(unit);
        $("#stock" + n).val(stock);
    }

    function check_stock(n, current_stock) {
        var desired_stock = parseFloat($("#quantity" + n).val());
        if (desired_stock > current_stock) {
            notif("warning", "Jumlah yang diinput melebihi batas", "growl");
            $("#quantity" + n).val(current_stock);
            return false;
        }
        return true;
    }

    function updateTotal(n) {
        var current_stock = $("#selectProduct" + n).find(":selected").data("stock");
        if (check_stock(n, current_stock)) {
            var quantity = $("#quantity" + n).val();
            var price = parseInt(replaceAll($("#price" + n).val(), ".", ""));
            var total = quantity * price;
            $("#total" + n).val(ic_rupiah(total));
            update_grand_total();
        } else {
            return false;
        }
    }

    function update_grand_total() {
        var grand_total = 0;
        $(".subtotal").each(function (index, value) {
            grand_total += parseInt(replaceAll($(this).val(), '.', ''));
        });
        $("#grandTotal").val(ic_rupiah(grand_total));
    }
</script>    
<script type="x-tmpl-mustache" id="tmpl-product-data">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">{{list_materials}}
    <select name='data[MaterialAdditionalSaleDetail][{{n}}][material_additional_id]' id="selectProduct{{n}}" class='select-full product_id selectProduct' onchange="change_unit({{n}})"> //getPrice(this,{{n}})
    <option value=''>-Pilih Material Pembantu-</option>
    {{#data_product}}
    <optgroup label="{{category}}">
    {{#child}}
    <option value="{{id}}" data-unit="{{unit_name}}" data-stock="{{stock}}">{{label}}</option>
    {{/child}}
    </optgroup>
    {{/data_product}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' class='form-control text-right' id='stock{{n}}' value="0" disabled/>
    <span class="input-group-addon" id="unitStock{{n}}">Pcs</span>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[MaterialAdditionalSaleDetail][{{n}}][quantity]' class='form-control MaterialAdditionalSaleDetail{{n}}Quantity text-right isdecimaldollar' id='quantity{{n}}' value="0" onkeyup="updateTotal({{n}})"/>
    <span class="input-group-addon" id="unit{{n}}">Pcs</span>
    </div>        
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp</span>        
    <input type='text' name="data[MaterialAdditionalSaleDetail][{{n}}][price]" class='form-control MaterialAdditionalSaleDetail{{n}}Price qtyPrice text-right isdecimal' value="0" id="price{{n}}" onkeyup="updateTotal({{n}})"/>
    <div>        
    </td>  
    <td class="text-center">
    <div class="input-group">        
    <span class="input-group-addon">Rp</span> 
    <input type='text' class='form-control text-right subtotal' id="total{{n}}" readonly />
    </div>
    </td>  
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>    
    </tr>
</script>