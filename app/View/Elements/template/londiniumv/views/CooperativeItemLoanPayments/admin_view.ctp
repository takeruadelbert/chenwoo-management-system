<?php echo $this->Form->create("CooperativeItemLoanPayment", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Data Potongan Sembako") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("CooperativeItemLoanPayment.start_period", __("Periode Awal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("CooperativeItemLoanPayment.start_period", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("CooperativeItemLoanPayment.end_period", __("Periode Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("CooperativeItemLoanPayment.end_period", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive stn-table">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <th width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
                                <th align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
                                <th width="200" align="center" valign="middle" bgcolor="#feffc2" colspan="2">Total Hutang Sembako</th>
                                <th width="200" align="center" valign="middle" bgcolor="#feffc2" colspan="2">Jumlah Potongan Periode Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (!empty($this->data["CooperativeItemLoanPaymentDetail"])) {
                                foreach ($this->data["CooperativeItemLoanPaymentDetail"] as $k => $cooperativeItemLoanPaymentDetail) {
                                    ?>
                                    <tr>
                                        <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                                        <td>
                                            <div class="false">
                                                <?= $cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["Employee"]["Account"]["Biodata"]["full_name"] ?>
                                            </div>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;">  
                                            <div class="false">
                                                Rp.
                                            </div>
                                        </td>
                                        <td class = "text-right" style="border-left-style:none;">
                                            <div class="false">
                                                <?= ic_rupiah($cooperativeItemLoanPaymentDetail["current_debt"]) ?>
                                            </div>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;">  
                                            <div class="false">
                                                Rp.
                                            </div>
                                        </td>
                                        <td class = "text-right" style="border-left-style:none;">
                                            <div class="false">
                                                <?= ic_rupiah($cooperativeItemLoanPaymentDetail["amount"]) ?>
                                                <?= $this->Form->hidden("CooperativeItemLoanPaymentDetail.$i.id", ["value" => $cooperativeItemLoanPaymentDetail["id"]]) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data hutang.</td>
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
</div>
<?php echo $this->Form->end() ?>