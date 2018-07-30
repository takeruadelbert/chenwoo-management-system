<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Penjualan Produk Tambahan</h4>
</div>
<?php
//debug($this->data);
?>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENJUALAN PRODUK TAMBAHAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <?php
        if (!empty($this->data['Treatment'])) {
            ?>
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <?php
                        foreach ($this->data['Treatment'] as $i => $treatments) {
                            if ($i == 0) {
                                $is_active = "active";
                            } else {
                                $is_active = "";
                            }
                            ?>
                            <li class="<?= $is_active ?>"><a href="#justified-pill<?= $i ?>" data-toggle="tab"><i class="icon-stopwatch"></i> Treatment <?= ($i + 1) ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div class="tab-content pill-content">
                        <?php
                        foreach ($this->data['Treatment'] as $i => $treatments) {
                            if ($i == 0) {
                                $is_active = "active";
                            } else {
                                $is_active = "";
                            }
                            ?>
                            <div class="tab-pane fade in <?= $is_active ?>" id="justified-pill<?= $i ?>">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                                </div>
                                <table width="100%" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Employee']['Account']['Biodata']['full_name']));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("NIP"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Employee']['nip']));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($treatments['Employee']['Department']['name']) ? $treatments['Employee']['Department']['name'] : "-"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($treatments['Employee']['Office']['name']) ? $treatments['Employee']['Office']['name'] : "-"));
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
                                                    echo $this->Form->label(null, __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Operator']['Account']['Biodata']['full_name']));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("NIP"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Operator']['nip']));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Operator']['Department']['name']));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['Operator']['Office']['name']));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Tanggal Mulai Treatment"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control", "disabled", "value" => $this->Html->cvtWaktu($treatments['start_date'])));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label(null, __("Tanggal Selesai Treatment"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control", "disabled", "value" => $this->Html->cvtWaktu($treatments['end_date'])));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Hasil Treatment") ?></h6>
                                </div>
                                <table width="100%" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Nomor Treatment"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $treatments['treatment_number']));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <div class="table-responsive stn-table">
                                    <table width="100%" class="table table-hover table-bordered">  
                                        <thead>
                                            <tr>
                                                <th width="50">No.</th>
                                                <th>Jenis Produk</th>
                                                <th>Tipe Turun Grade</th>
                                                <!--<th colspan="2">Berat Styling</th>-->
                                                <th colspan="2">Berat Treatment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $weight_difference = 0;
                                            foreach ($treatments['TreatmentDetail'] as $index => $details) {
                                                $currentWeight = e_isset(@$treatments['TreatmentSourceDetail'][$index]['weight'], 0);
                                                $weight_difference = abs($details['weight'] - $currentWeight);
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $i ?></td>
                                                    <td><?= $details['Product']['Parent']['name'] . "-" . $details['Product']['name'] ?></td>
                                                    <td class="text-center"><?= !empty($details['RejectedGradeType']['id']) ? $details['RejectedGradeType']['name'] : "-" ?></td>
            <!--                                                    <td class="text-right" style="border-right-style:none;">
                                                    <?= e_isset(@$treatments['TreatmentSourceDetail'][$index]['weight'], 0) ?>
                                                    </td> 
                                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                        Kg
                                                    </td> -->
                                                    <td class="text-right" style="border-right-style:none;">
                                                        <?= $details['weight'] ?>
                                                    </td> 
                                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                        Kg
                                                    </td> 
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>                                    
                                        </tbody> 
                                        <tfoot>
                                            <tr>
                                                <td colspan = 3 class= "text-right">
                                                    <strong>Berat Treatment</strong>
                                                </td>
                                                <td class="text-right" style="border-right-style:none;">
                                                    <?= $treatments['total'] ?>
                                                </td> 
                                                <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                    Kg
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td colspan = 3 class= "text-right">
                                                    <strong>Ratio Treatment</strong>
                                                </td>
                                                <td class="text-right" style="border-right-style:none;">
                                                    <?= $treatments['ratio'] ?>
                                                </td> 
                                                <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                    Kg
                                                </td> 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <br>
                                <?php
                                if (!empty($treatments['TreatmentSourceDetail'])) {
                                    ?>
                                    <div class="panel-heading" style="background:#2179cc">
                                        <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Treatment Source") ?></h6>
                                    </div>
                                    <div class="table-responsive stn-table">
                                        <table width="100%" class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="50">No.</th>
                                                    <th>Jenis Produk</th>
                                                    <th colspan="2">Berat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $weight_difference = 0;
                                                foreach ($treatments['TreatmentSourceDetail'] as $index => $details) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td><?= $details['Product']['Parent']['name'] . "-" . $details['Product']['name'] ?></td>

                                                        <td class="text-right" style="border-right-style:none;">
                                                            <?= $details['weight'] ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                            Kg
                                                        </td> 
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>                                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <center><h2>Belum Ada Data Treatment</h2></center>
            <?php
        }
        ?>
        <br><br>
        <!-- /new invoice template -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
        </div>
    </div>
</div>
