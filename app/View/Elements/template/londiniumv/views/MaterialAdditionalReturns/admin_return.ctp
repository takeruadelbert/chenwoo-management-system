<?php echo $this->Form->create("MaterialAdditionalReturn", array("class" => "form-horizontal form-separate", "action" => "return", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PROSES PENGEMBALIAN MATERIAL PEMBANTU") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li id="tab-step2a"><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Rincian Penjualan</a></li>
                    <li id="tab-step2b"><a href="#justified-pill3" data-toggle="tab"><i class="icon-stopwatch"></i> Input Hasil Treatment</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                            echo $this->Form->input("MaterialAdditionalReturn.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
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
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            echo $this->Form->input("MaterialAdditionalPerContainer.sale_id", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "type" => "hidden", "id" => "matId","disabled"));
                                            ?>
                                            <input type="hidden" name="data[MaterialAdditionalReturn][material_additional_per_container_id]" id="materialAdditionalPerContainerId">  
                                            <?php
                                            echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Sale.created", __("Tanggal Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Sale.created", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "disabled"));
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
                                    <th width = "50">No</th>
                                    <th width = "250">Produk</th>
                                    <th width = "200">Material Pembantu MC</th>
                                    <th width = "150">Jumlah MC</th>
                                    <th width = "150">Selisih MC</th>
                                    <th width = "200">Material Pembantu Plastik</th>
                                    <th width = "150">Jumlah Plastik</th>
                                    <th width = "150">Selisih Plastik</th>
                                </tr>
                            <thead>
                            <tbody id="target-treatment-detail">
                                <tr id="temp">
                                    <td colspan="8" class="text-center">Tidak Ada Data</td>
                                </tr>
                                <tr id="addRow">
                                    <td colspan="8" style = "padding: 0px; border: none">
                                        <div class="text-success test" data-n="0"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-actions text-center">
                                    <input type="button" value="Kembali" class="btn btn-info" onclick="gotoTab2a();">
                                    <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>" style="margin:10px auto;">
                                        <?= __("Simpan") ?>
                                    </button>
                                </div>
                            </div>
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
        var id = $("#matId").val();
        getDataMaterialPembantu(id);
    })

    function getDataMaterialPembantu(matId) {
        $.ajax({
            url: BASE_URL + "admin/material_additional_per_containers/view_data_per_po/" + matId,
            type: "GET",
            dataType: "JSON",
            data: {},
            success: function (data) {
                var detail = data.MaterialAdditionalPerContainerDetail;
                $("input#SalePoNumber").val(data.Sale.po_number);
                $("input#SaleSaleNo").val(data.Sale.sale_no);
                $("input#SaleCreated").val(cvtTanggal(data.Sale.created));
                $("#materialAdditionalPerContainerId").val(data.MaterialAdditionalPerContainer.id);
                $.each($(".test").parents("tbody").find("tr"), function () {
                    $(this).not("#addRow").remove();
                    $(".test").data("n", 0);
                });
                $.each(detail, function (index, value) {
                    addThisRow($(".test"), "treatment-detail");
                    $("#product_name" + index).val(value.Product.Parent.name + " " + value.Product.name);
                    $("#MaterialAdditionalReturnDetail" + index + "ProductId").val(value.product_id);
                    $("#material_mc" + index).val(value.MaterialAdditionalMc.name + " " + value.MaterialAdditionalMc.size);
                    $("#MaterialAdditionalReturnDetail" + index + "MaterialAdditionalMcId").val(value.material_additional_mc_id);
                    $("#mcWeight" + index).val(ic_rupiah(value.quantity_mc));
                    $("#material_plastic" + index).val(value.MaterialAdditionalPlastic.name + " " + value.MaterialAdditionalPlastic.size);
                    $("#MaterialAdditionalReturnDetail" + index + "MaterialAdditionalPlasticId").val(value.material_additional_plastic_id);
                    $("#plasticWeight" + index).val(ic_rupiah(value.quantity_plastic));
                });
            }
        });
    }
</script>
<script>
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
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
            i++;
        })
    }
    function anakOptions() {
        return {};
    }


    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-detail">
    <tr id="data1">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="text" class="form-control text-left product_name" name="data[Dummy][{{n}}][product_name]" id="product_name{{n}}" readonly> 
    <input type="hidden" name="data[MaterialAdditionalReturnDetail][{{n}}][product_id]" id="MaterialAdditionalReturnDetail{{n}}ProductId">                              
    </td>
    <td>
    <input type="text" class="form-control text-left material_mc" name="data[Dummy][{{n}}][material_mc]" id="material_mc{{n}}" readonly> 
    <input type="hidden" name="data[MaterialAdditionalReturnDetail][{{n}}][material_additional_mc_id]" id="MaterialAdditionalReturnDetail{{n}}MaterialAdditionalMcId">                              
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right mcWeight" id="mcWeight{{n}}" name="data[MaterialAdditionalReturnDetail][{{n}}][order_quantity_mc]" value = "0" readonly>
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right isdecimal" name="data[MaterialAdditionalReturnDetail][{{n}}][quantity_mc]" id="MaterialAdditionalReturnDetail{{n}}QuantityMc" value = "0">
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>                                
    </td>
    <td>
    <input type="text" class="form-control text-left material_mc" name="data[Dummy][{{n}}][material_plastic]" id="material_plastic{{n}}" readonly> 
    <input type="hidden" name="data[MaterialAdditionalReturnDetail][{{n}}][material_additional_plastic_id]" id="MaterialAdditionalReturnDetail{{n}}MaterialAdditionalPlasticId">                              
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right plasticWeight" id="plasticWeight{{n}}"  name="data[MaterialAdditionalReturnDetail][{{n}}][order_quantity_plastic]" value = "0" readonly>
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right isdecimal" name="data[MaterialAdditionalReturnDetail][{{n}}][quantity_plastic]" id="MaterialAdditionalReturnDetail{{n}}QuantityPlastic" value = "0">
    <span class="input-group-addon"><strong>Pcs</strong></span>
    </div>                                
    </td>
    </tr>
</script>