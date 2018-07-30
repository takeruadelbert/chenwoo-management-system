<?php echo $this->Form->create("MaterialAdditionalReturn", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH PROSES PENGEMBALIAN MATERIAL PEMBANTU") ?>
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
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                            echo $this->Form->input("MaterialAdditionalReturn.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['nip']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            if (empty($this->data['Employee']['Department'])) {
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Department']['name']));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            if (empty($this->data['Employee']['Department'])) {
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Office']['name']));
                                            }
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
                                            echo $this->Form->label("MaterialAdditionalPerContainer.Sale.po_number", __("Nomor PO"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalPerContainer.Sale.po_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            echo $this->Form->input("MaterialAdditionalPerContainer.id", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "hidden", "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalPerContainer.Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalPerContainer.Sale.sale_no", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.created", __("Tanggal Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.created", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => $this->data['MaterialAdditionalPerContainer']['Sale']['created'], "disabled"));
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
                                <?php
                                $no = 1;
                                $dataN = count($this->data["MaterialAdditionalReturnDetail"]);
                                foreach ($this->data["MaterialAdditionalReturnDetail"] as $i => $value) {
                                    ?>
                                    <tr class="dynamic-row">
                                        <td class="nomorIdx text-center"><?= $no; ?></td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("MaterialAdditionalReturnDetail.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("Dummy.product_name", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "value" => $value['Product']['Parent']['name'] . " " . $value['Product']['name'], "disabled"));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("Dummy.material_name", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "value" => $value['MaterialAdditionalMc']['name'] . " " . $value['MaterialAdditionalMc']['size'], "disabled"));
                                            ?>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->input("MaterialAdditionalReturnDetail.$i.order_quantity_mc", array("div" => false, "label" => false, "class" => "form-control isdecimal text-right", "maxlength" => "255", "disabled"));
                                                ?>
                                                <span class="input-group-addon"><strong>Pcs</strong></span>
                                            </div>  
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->input("MaterialAdditionalReturnDetail.$i.quantity_mc", array("div" => false, "label" => false, "class" => "form-control text-right isdecimal", "maxlength" => "255"));
                                                ?>
                                                <span class="input-group-addon"><strong>Pcs</strong></span>
                                            </div>  
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("Dummy.material_plastic_name", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "value" => $value['MaterialAdditionalPlastic']['name'] . " " . $value['MaterialAdditionalPlastic']['size'], "disabled"));
                                            ?>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->input("MaterialAdditionalReturnDetail.$i.order_quantity_plastic", array("div" => false, "label" => false, "class" => "form-control isdecimal text-right", "maxlength" => "255", "disabled"));
                                                ?>
                                                <span class="input-group-addon"><strong>Pcs</strong></span>
                                            </div>  
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <?php
                                                echo $this->Form->input("MaterialAdditionalReturnDetail.$i.quantity_plastic", array("div" => false, "label" => false, "class" => "form-control text-right isdecimal", "maxlength" => "255"));
                                                ?>
                                                <span class="input-group-addon"><strong>Pcs</strong></span>
                                            </div>  
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-actions text-center">
                                    <input type="button" value="Kembali" class="btn btn-info" onclick="gotoTab2a();
                                           ">
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