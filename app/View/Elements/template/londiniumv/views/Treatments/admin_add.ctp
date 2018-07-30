<?php echo $this->Form->create("Treatment", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PROSES TREATMENT / RETOUCHING") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li id="tab-step1"><a href="#data-freezing" data-toggle="tab"><i class="fa fa-snowflake-o"></i> Data Styling</a></li>
                    <li id="tab-step2a"><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Rincian Styling Yang Dipilih</a></li>
                    <li id="tab-step2b"><a href="#justified-pill3" data-toggle="tab"><i class="icon-stopwatch"></i> Input Hasil Treatment</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade" id="data-freezing">
                        <div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("MaterialEntry.material_entry_number", __("Nomor Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("MaterialEntry.material_entry_number", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                echo $this->Form->label("Employee.Account.Biodata.full_name", __("Pembuat Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("Employee.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                ?>
                            </div>
                        </div>
                        <div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <!--                                    <div class="table-responsive stn-table">
                                                                            <div class="panel-heading" style="background:#2179cc">
                                                                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><= __("Data Styling Yang Belum Diproses") ?></h6>
                                                                            </div>
                                                                            <table width="100%" class="table table-hover table-bordered">                        
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="50">No</th>
                                                                                        <th><= __("Nomor Styling") ?></th>
                                                                                        <th><= __("Pegawai Pelaksana") ?></th>
                                                                                        <th><= __("Waktu Styling") ?></th>
                                                                                        <th width="75"><= __("Berat Total (kg)") ?></th>
                                                                                        <th width="50"><= __("Pilih") ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="">
                                                                                    <php
                                                                                    $n = 1;
                                                                                    foreach ($this->data["Freeze"] as $freeze) {
                                                                                        if (!$freeze['return_order_status']) {
                                                                                            if (!empty($freeze["Treatment"])) {
                                                                                                continue;
                                                                                            }
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td class="text-center"><= $n ?></td>
                                                                                                <td class="text-left"><= $freeze["freeze_number"] ?></td>
                                                                                                <td class="text-left"><= $freeze["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                                                                                                <td class="text-left"><= $freeze["created__ic"] ?></td>
                                                                                                <td class="text-right"><= $freeze["total_weight"] ?></td>
                                                                                                <td class="text-center">
                                                                                                    <php
                                                                                                    if ($freeze["verify_status_id"] == 1) {
                                                                                                        ?>
                                                                                                        <div class="text-danger" title="Menunggu Verifikasi Dari Konversi">
                                                                                                            <i class="icon-warning"></i>
                                                                                                        </div>
                                                                                                        <php
                                                                                                    } else {
                                                                                                        ?>
                                                                                                        <label class="radio-inline radio-success">
                                                                                                            <input type="radio" name="selectfreeze" class="styled" value="<?= $freeze["id"] ?>">
                                                                                                        </label>
                                                                                                        <php
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <php
                                                                                            $n++;
                                                                                        }
                                                                                    }
                                                                                    if ($n == 1) {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                                                                        </tr>
                                                                                        <php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>-->
                                    <br/>
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Styling Yang Belum Diproses") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th><?= __("Nama Ikan") ?></th>
                                                    <th><?= __("Waktu Styling") ?></th>
                                                    <th colspan = 2><?= __("Berat Ikan Tersedia") ?></th>
                                                    <th width="75px"><?= __("Pilih Styling") ?></th>
                                                    <th><?= __("Berat Ikan yang Diproses") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <?php
                                                $n = 1;
                                                $count = 0;
                                                foreach ($this->data["Freeze"] as $freeze) {
                                                    foreach ($freeze['FreezeDetail'] as $freezeDetail) {
                                                        if (!$freeze['return_order_status']) {
                                                            if ($freezeDetail['remaining_weight'] > 0) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $n ?></td>
                                                                    <td class="text-left"><?= $freezeDetail['Product']['Parent']["name"] . " " . $freezeDetail['Product']["name"] ?></td>
                                                                    <td class="text-left"><?= $freeze["created__ic"] ?></td>
                                                                    <td class="text-right">
                                                                        <?= $freezeDetail["remaining_weight"] ?>
                                                                        <input  type="hidden" id="remainingWeight<?= $n ?>" value="<?= $freezeDetail["remaining_weight"] ?>"/>
                                                                    </td>
                                                                    <td class="text-left" width="50px">Kg</td>
                                                                    <?php
                                                                    if ($freeze["validate_status_id"] == 2) {
                                                                        ?>
                                                                        <td width="75px" class="text-center">
                                                                            <input type="radio" class="styled" name="selectedStyling" id="selectedStyling<?= $n ?>" onclick="unDisabled(<?= $n ?>)"/>
                                                                        </td>
                                                                        <?php
                                                                    } else if ($freeze["validate_status_id"] == 1) {
                                                                        ?>
                                                                        <td width="75px" class="text-center">
                                                                            <div class="text-danger" title="Data Styling Menunggu Validasi">
                                                                                <i class="icon-warning"></i>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td width="75px" class="text-center">
                                                                            <div class="text-danger" title="Data Styling Ditolak">
                                                                                <i class="icon-warning"></i>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <td class="text-center">
                                                                        <div class="input-group">
                                                                            <input  type="hidden" name="data[Treatment][freeze_id]" disabled class="currentFreezeIdTreatment" id="currentFreezeIdTreatment<?= $n ?>" value="<?= $freeze['id'] ?>"/>
                                                                            <input  type="hidden" name="data[Treatment][material_entry_id]" disabled class="currentMaterialEntryId" id="currentMaterialEntryId<?= $n ?>" value="<?= $freeze['material_entry_id'] ?>"/>
                                                                            <input  type="hidden" name="data[TreatmentSourceDetail][<?= $n ?>][freeze_id]" disabled class="currentFreezeId" id="currentFreezeId<?= $n ?>" value="<?= $freeze['id'] ?>"/>
                                                                            <input  type="hidden" name="data[TreatmentSourceDetail][<?= $n ?>][freeze_detail_id]" disabled class="currentFreezeDetailId" id="currentFreezeDetailId<?= $n ?>" value="<?= $freezeDetail['id'] ?>"/>
                                                                            <input  type="hidden" name="data[TreatmentSourceDetail][<?= $n ?>][product_id]" disabled class="currentProductWeightId" id="currentProductWeightId<?= $n ?>" value="<?= $freezeDetail['Product']['id'] ?>"/>
                                                                            <input  type="text" class= "form-control currentProductWeight" id="currentProductWeight<?= $n ?>" disabled data-nId="<?= $n ?>" name="data[TreatmentSourceDetail][<?= $n ?>][weight]" value="0" onkeyup="calcCurrentWeight(<?= $n ?>)"/>
                                                                            <span class="input-group-addon"><strong>Kg</strong></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $n++;
                                                                $count++;
                                                            }
                                                        }
                                                    }
                                                }
                                                if ($n == 1) {
                                                    ?>
                                                    <tr>
                                                        <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Styling Keseluruhan") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th><?= __("Nomor Styling") ?></th>
                                                    <th><?= __("Pegawai Pelaksana") ?></th>
                                                    <th><?= __("Waktu Styling") ?></th>
                                                    <th width="75"><?= __("Berat Total (kg)") ?></th>
<!--                                                    <th width="50"><= __("Pilih") ?></th>-->
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <?php
                                                if (!empty($this->data["Freeze"])) {
                                                    foreach ($this->data["Freeze"] as $n => $freeze) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $n + 1 ?></td>
                                                            <td class="text-left"><?= $freeze["freeze_number"] ?></td>
                                                            <td class="text-left"><?= $freeze["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                                                            <td class="text-left"><?= $freeze["created__ic"] ?></td>
                                                            <td class="text-right"><?= $freeze["total_weight"] ?></td>
        <!--                                                            <td class="text-center">
                                                                <php
                                                                if (empty($freeze["Treatment"])) {
                                                                    ?>
                                                                    <span class="label label-warning">Belum Diproses</span>
                                                                    <php
                                                                } else {
                                                                    ?>
                                                                    <span class="label label-success">Selesai</span>
                                                                    <php
                                                                }
                                                                ?>
                                                            </td>-->
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                        </div>                            
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input type="button" value="Next" class="btn btn-success" onclick="step2a();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>          
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
                                            echo $this->Form->input("Treatment.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
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
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Treatment") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.name", __("Cari Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="has-feedback">
                                                    <?php
                                                    echo $this->Form->input("Treatment.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->input("Treatment.operator_id", array("type" => "hidden", "class" => "form-control"));
                                                    ?>
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                </div>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Treatment.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Treatment.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.start_date", __("Tanggal Mulai Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.start_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Treatment.end_date", __("Tanggal Selesai Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.end_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input type="button" value="Next" class="btn btn-success" onclick="gotoTab1();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.treatment_number", __("Nomor Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.treatment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "AUTO GENERATE"));
                                            ?>
                                            <div class="col-sm-2 control-label">
                                                <label>Berat Ikan yang akan diproses </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="beratPembekuan" readonly>
                                                    <span class="input-group-addon"><strong>Kg</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>                           
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input type="button" value="Kembali" class="btn btn-info" onclick="backToStep1();">
                                        <input type="button" value="Next" class="btn btn-success" onclick="gotoTab2b();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label>Total Berat Ikan Yang Ditreatment</label>
                                </div>
                                <div class="col-md-2">
                                    <span class="input-group">
                                        <input type="text" class="form-control text-right" id="processedWeight" disabled value="0">
                                        <span class="input-group-addon"><strong>Kg</strong></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Produk</th>
                                    <th width = "250">Alasan Turun Grade</th>
                                    <th width = "250">Berat Styling</th>
                                    <th width = "250">Berat Treatment</th>
                                    <th width = "250">Selisih</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-treatment-detail">
                                <tr id="temp">
                                    <td colspan="7" class="text-center">Tidak Ada Data</td>
                                </tr>
                                <tr id="addRow">
                                    <td colspan="7">
                                        <a class="text-success test" href="javascript:void(false)" onclick="addThisRow($(this), 'treatment-detail')" data-n="0"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Berat Treatment</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right totalWeightTreatment" value="0" name="data[Treatment][total]" readonly>
                                            <span class="input-group-addon"><strong> Kg</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Selisih Berat</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right totalDifferWeight" value="0" readonly>
                                            <span class="input-group-addon"><strong>Kg</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Ratio</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right tip" id="ratio" value="0" name="data[Treatment][ratio]" data-toogle="tooltip" readonly>
                                            <span class="input-group-addon"><strong> %</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>   
                        </table>
                        <div class = "treatmentNote">
                            <td colspan="12" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Treatment.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("Treatment.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </div>
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
<?php
$listProduct = [];
foreach ($products as $product) {
    $childs = [];
    foreach ($product["Child"] as $child) {
        $childs[] = [
            "id" => $child["id"],
            "label" => $product["Product"]["name"] . " " . $child["name"],
        ];
    }
    $listProduct[] = [
        "id" => $product["Product"]["id"],
        "label" => $product["Product"]["name"],
        "child" => $childs,
    ];
}
?>
<script>
    $(document).ready(function () {
        var employees = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        employees.clearPrefetchCache();
        employees.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employees.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '<br/>Cabang : ' + context.branch_office + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#TreatmentOperatorId').val(suggestion.id);
            $('#TreatmentNip').val(suggestion.nip);
            $('#TreatmentOfficeName').val(suggestion.jabatan);
            $('#TreatmentDepartmentName').val(suggestion.department);
        });
    })
</script>
<script>
    var data_product = <?= json_encode($listProduct) ?>;
    var stylingCurrentWeight = 0;
    $(document).ready(function () {
        $(".treatmentNote").hide();
        disableStep2();

    })


    function step1() {
        disableStep2();
        enableStep1();
        gotoTab1();
    }

    function step2a() {
        if (proceedToStep2()) {
            disableStep1();
            enableStep2();
            gotoTab2a();
        }
    }

    function disableStep1() {
        $("#tab-step1").addClass("disabled");
        $("#tab-step1 a").on("click", function (e) {
            return false;
        });
    }

    function disableStep2() {
        $("#tab-step2a").addClass("disabled");
        $("#tab-step2b").addClass("disabled");
        $("#tab-step2a a").on("click", function (e) {
            return false;
        });
        $("#tab-step2b a").on("click", function (e) {
            return false;
        });
    }

    function enableStep1() {
        $("#tab-step1").removeClass("disabled");
        $("#tab-step1 a").unbind("click");
    }

    function enableStep2() {
        $("#tab-step2a").removeClass("disabled");
        $("#tab-step2a a").unbind("click");
        $("#tab-step2b").removeClass("disabled");
        $("#tab-step2b a").unbind("click");
    }

    function gotoTab1() {

        $("#tab-step1 a").trigger("click");
    }
    function gotoTab2a() {
        $("#tab-step2a a").trigger("click");
    }
    function gotoTab2b() {
        $("#tab-step2b a").trigger("click");
    }

    function backToStep1() {
        $(".remove").trigger("click");
        $(".test").data("n", 0);
        enableStep1();
        disableStep2();
        gotoTab1();
    }

    function proceedToStep2() {
//        if (!$("input[name='selectfreeze']:checked").val()) {
//            notif("warning", "Data Styling Belum Dipilih", "growl")
//            return false;
//        } else {
//            if ($("#TreatmentOperatorId").val() == "") {
//                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
//                return false;
//            }
//            getFreezeData($("input[name='selectfreeze']:checked").val());
//            return true;
//        }
        if ($("#TreatmentOperatorId").val() == "") {
            notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
            return false;
        }
        $(this).not("#addRow").remove();
        $('input#beratPembekuan').val(stylingCurrentWeight);
        $('#processedWeight').val(stylingCurrentWeight);
        $('#temp').remove();
        var count = 0;
        if ($(".test").data("n") == 0) {
            $(".currentProductWeight").each(function () {
                var weight = $(this).val();
                if (weight != 0) {
                    addThisRow($(".test"), "treatment-detail");
                    var id = $(this).attr("id");
                    var n = $("#" + id).data("nid");
                    //get id product
                    var idProduct = $("#currentProductWeightId" + n).val();
                    $("#TreatmentDetail" + count + "product_id").select2("val", idProduct);
                    $("#freezeWeight" + count).val(weight);
                    count++;
                }
            });
        }
        ajaxLoadingSuccess()
        return true;
    }

    function getFreezeData(freezeId) {
        $.ajax({
            url: BASE_URL + "freezes/view_data_freeze/" + freezeId,
            type: "GET",
            dataType: "JSON",
            data: {},
            beforeSend: function (xhr) {
                ajaxLoadingStart();
            },
            success: function (data) {
                var freezeDetails = data.FreezeDetail;
                $.each($(".test").parents("tbody").find("tr"), function () {
                    $(this).not("#addRow").remove();
                    $(".test").data("n", 0);
                });
                $('input#freezeId').val(data.Freeze.id);
                //$('input#transactionNumber').val(data.Freeze.freeze_number);
                $('input#beratPembekuan').val(stylingCurrentWeight);
                //$('input#ratioPembekuan').val(data.Freeze.ratio);
                $('#processedWeight').val(data.Freeze.total_weight);
                $.each(freezeDetails, function (index, value) {
                    addThisRow($(".test"), "treatment-detail");
                    $("#TreatmentDetail" + index + "product_id").select2("val", value.Product.id);
                    $("#freezeWeight" + index).val(value.weight);
                });
                ajaxLoadingSuccess()
            }
        });
    }

    function getParameterByName(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
</script>
<script>
    var products = <?= $this->Engine->toJSONoptions($products) ?>;
    var rejected_grade_type = <?= $this->Engine->toJSONoptions($rejectedGradeTypes, "- Pilih Alasan Turun Grade -") ?>;
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        $(".weightTreatment").trigger("keyup");
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 1, n: n, data_product: data_product, rejected_grade_type: rejected_grade_type};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
        $(".treatmentNote").hide();
        getTotalBerat(n);
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
        return {products: products, rejected_grade_type: rejected_grade_type};
    }

    function getTotalBerat(n) {
        $("#treatmentWeight" + n).on("change keyup", function () {
            var totalBerat = 0;
            /* updating total weight treatment field */
            $(".weightTreatment").each(function () {
                if ($(this).val()) {
                    var wt = $(this).val();
                } else {
                    var wt = 0;
                }
                totalBerat += parseFloat(wt);
            });
            $(".totalWeightTreatment").val(totalBerat.toFixed(2));

            /* updating total difference between freezed weight and treatment weight */
            var totalDifferWeight = 0;
            var differEachRow = Math.abs($("#treatmentWeight" + n).val() - $("#freezeWeight" + n).val());
            $("#differWeight" + n).val(differEachRow.toFixed(2));

            /* get total of freezed weights */
//            var totalFreezeWeight = 0;
//            $(".freezeWeight").each(function () {
//                totalFreezeWeight += parseFloat($(this).val());
//            });

            /* updating the total differece weight field */
            var totalDifferWeight = Math.abs(totalBerat - stylingCurrentWeight);
            $(".totalDifferWeight").val(totalDifferWeight.toFixed(2));

            /* set the ratio result */
            var ratio = totalBerat / stylingCurrentWeight * 100;
            $("#ratio").val(ratio.toFixed(2));

            /* check the suitable ratio if it's more than ±5% from freezed ratio */
            var freezedRatio = parseFloat($("#ratioPembekuan").val());
            var tRatio = parseFloat($("#ratio").val());
            var top_quartile = 105;
            var bottom_quartile = 95;
            if (tRatio >= bottom_quartile && tRatio <= top_quartile) {
                $("#ratio").removeAttr("data-original-title");
                $("#ratio").tooltip("hide");
                $(".treatmentNote").hide();
            } else {
                $("#ratio").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Pembekuan!");
                $("#ratio").tooltip("fixTitle");
                $("#ratio").tooltip("show");
                $(".treatmentNote").show();
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function calcCurrentWeight(n) {
        //alert("aa");
        //$("#data1").html();
        stylingCurrentWeight = 0;
        var remainingWeight = $("#remainingWeight" + n).val();
        var currentWeight = $("#currentProductWeight" + n).val();
        if (currentWeight != "") {
            remainingWeight = parseFloat($("#remainingWeight" + n).val());
            currentWeight = parseFloat($("#currentProductWeight" + n).val());
            if (currentWeight > remainingWeight) {
                $("#currentProductWeight" + n).val("0")
                alert("Kesalahan! Berat yang diproses lebih besar dari berat tersedia!");
            } else {
                $(".currentProductWeight").each(function () {
                    if (parseFloat($(this).val()) != "") {
                        stylingCurrentWeight += parseFloat($(this).val());
                    }
                });
            }
        }
    }

    function unDisabled(n) {
        $('input.currentProductWeight').each(function () {
            $(this).attr("disabled", true);
            $(this).val("0")
        });
        $('input.currentFreezeIdTreatment').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentMaterialEntryId').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentFreezeId').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentFreezeDetailId').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentProductWeightId').each(function () {
            $(this).attr("disabled", true);
        });
        $("#currentProductWeight" + n).removeAttr("disabled");
        $("#currentFreezeIdTreatment" + n).removeAttr("disabled");
        $("#currentMaterialEntryId" + n).removeAttr("disabled");
        $("#currentFreezeId" + n).removeAttr("disabled");
        $("#currentFreezeDetailId" + n).removeAttr("disabled");
        $("#currentProductWeightId" + n).removeAttr("disabled");
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-detail">
    <tr id="data1">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select name="data[TreatmentDetail][{{n}}][product_id]" class="select-full productSelected" id="TreatmentDetail{{n}}product_id" required="required" empty="" placeholder="- Pilih Jenis Produk -">
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <optgroup label="{{label}}">
    {{#child}}
    <option value="{{id}}" data-id="{{n}}">{{label}}</option>
    {{/child}}
    </optgroup>
    {{/data_product}}
    </select>
    </td>
    <td>
    <select name='data[TreatmentDetail][{{n}}][rejected_grade_type_id]' class='select-full' id='TreatmentDetailRejectedGradeTypeId'>
    {{#rejected_grade_type}}
    <option value="{{value}}">{{label}}</option>
    {{/rejected_grade_type}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right freezeWeight" name="data[Dummy][{{n}}][freezeWeight]" id="freezeWeight{{n}}" value = "0" readonly>
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right weightTreatment" name="data[TreatmentDetail][{{n}}][weight]" id="treatmentWeight{{n}}">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                 
    </td>
    <td>
    <div class="input-group">        
    <input type="text" class="form-control text-right differWeight" name="data[Dummy][{{n}}][differWeight]" id="differWeight{{n}}" readonly value="0">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                  
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3 remove"></i></a>
    </td>
    </tr>
</script>