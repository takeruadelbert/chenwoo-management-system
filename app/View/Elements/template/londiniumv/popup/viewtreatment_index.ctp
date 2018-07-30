<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Data Treatment (Retouching)</h4>
</div>
<?php
//debug($this->data);
?>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">LIHAT DATA TREATMENT (RETOUCHING)
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Staff Penginput</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pegawai Pelaksana</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-stopwatch"></i> Data Styling</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-file6"></i> Data Rincian Treatment</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Employee.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.treatment_number", __("Nomor Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.treatment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("TreatmentSourceDetail.0.FreezeDetail.Freeze.freeze_number", __("Nomor Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("TreatmentSourceDetail.0.FreezeDetail.Freeze.freeze_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
<!--                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                <?php
                                echo $this->Form->label("TreatmentSourceDetail.0.FreezeDetail.Freeze.total_weight", __("Berat Styling"), array("class" => "col-sm-2 control-label"));
                                ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                <?php
                                echo $this->Form->input("TreatmentSourceDetail.0.FreezeDetail.Freeze.total_weight", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled"));
                                ?>
                                                    <span class="input-group-addon"><strong>Kg</strong></span>
                                                </div>
                                            </div>
                                <?php
                                echo $this->Form->label("TreatmentSourceDetail.0.FreezeDetail.Freeze.ratio", __("Ratio Styling"), array("class" => "col-sm-2 control-label"));
                                ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                <?php
                                echo $this->Form->input("TreatmentSourceDetail.0.FreezeDetail.Freeze.ratio", array("div" => array("class" => ""), "label" => false, "class" => "form-control", "disabled"));
                                ?>
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("VerifyStatus.name", __("Status"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("VerifyStatus.name", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("VerifiedBy.Account.Biodata.full_name", __("Diverifikasi Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("VerifiedBy.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive stn-table">
                                    <div class="panel-heading" style="background:#2179cc">
                                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Treatment Source") ?></h6>
                                    </div>
                                    <table width="100%" class="table table-hover table-bordered">                        
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th><?= __("Nama Material") ?></th>
                                                <th colspan="2"><?= __("Berat Ikan") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($this->data['TreatmentSourceDetail'] as $source) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $i ?></td>
                                                    <td><?= $source['Product']['Parent']['name'] . " " . $source['Product']['name'] ?></td>
                                                    <td class="text-right" style="border-right-style:none;"><?= $source['weight'] ?></td>
                                                    <td class = "text-left" style= "width:50px; border-left-style:none;">Kg</td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill4">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width = "50">No</th>
                                    <th>Jenis Produk</th>
                                    <th width = "200">Tipe Turun Grade</th>
                                    <th colspan="2" width = "200">Berat Treatment</th>
                                </tr>
                            <thead>
                            <tbody id="target-treatment-detail">
                                <?php
                                $i = 1;
                                foreach ($this->data['TreatmentDetail'] as $detail) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        
                                        <td><?= $detail['Product']['Parent']['name'] . " " . $detail['Product']['name'] ?></td>
                                        <td class="text-center"><?php
                                        if($detail['RejectedGradeType']!=null){
                                            echo $detail['RejectedGradeType']['name'];
                                        }else{
                                            echo "-";
                                        }
                                        ?></td>
                                        <td class="text-right" style="border-right-style:none;"><?= $detail['weight'] ?></td>
                                        <td class = "text-left" style= "width:50px; border-left-style:none;">Kg</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Total Berat Treatment</strong>
                                    </td>
                                    <td class="text-right" style="border-right-style:none;"><?= $this->data['Treatment']['total'] ?></td>
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">Kg</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Total Ratio</strong>
                                    </td>
                                    <td class="text-right" style="border-right-style:none;"><?= $this->data['Treatment']['ratio'] ?></td>
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">%</td>
                                </tr>
                            </tfoot>
                        </table>
                        <br/>
                        <?php
                        if ($this->data['Treatment']['ratio'] < 95 && $this->data['Treatment']['ratio'] > 105) {
                            ?>
                            <div class = "treatmentNote">
                                <td colspan="12" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Treatment.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                        ?>
                                        <div id ="TreatmentNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                        </div>
                                    </div>
                                </td>
                            </div> 
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>                                
</div>   
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>