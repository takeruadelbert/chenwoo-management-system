<?php
//echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-shu-detail");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Detail Pembagian SHU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("view_detail_SHU/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("view_detail_SHU/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive stn-table">
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Data Laba") ?></h6>
            </div> 
            <table width="100%" class="table table-hover" id="transactionList">
                <tr>
                    <td>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeRemainingOperation.year", __("Tahun SHU"), array("class" => "col-md-2 control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("CooperativeRemainingOperation.year", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $cooperativeRemainingOperation['CooperativeRemainingOperation']['year'], "disabled"));
                            ?>
                            <?php
                            echo $this->Form->label("CooperativeRemainingOperation.profit", __("Laba"), array("class" => "col-md-2  control-label", "style" => "padding-top:10px;"));
                            ?>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Rp.</button>
                                    </span>
                                    <?php
                                    echo $this->Form->input("dummy.zzz", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "value" => ic_rupiah($cooperativeRemainingOperation['CooperativeRemainingOperation']['profit']), "disabled"));
                                    ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">,00.</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("CooperativeRemainingOperation.total_employee", __("Total Pegawai"), array("class" => "col-md-2 control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("CooperativeRemainingOperation.total_employee", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control text-right", "value" => $cooperativeRemainingOperation['CooperativeRemainingOperation']['total_employee'], "disabled"));
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <br/>
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-box-remove"></i><?= __("Detail Pembagian SHU") ?></h6>
            </div>
            <table width="100%" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="50" rowspan="2">No</th>
                        <th rowspan="2"><?= __("Nama Pegawai") ?></th>
                        <th rowspan="2" colspan="2"><?= __("Mulai Masuk Anggota") ?></th>
                        <th colspan="4"><?= __("SHU yang diberikan") ?></th>
                        <th rowspan="2" width="250"><?= __("Tanggal Pembayaran") ?></th>
                        <th rowspan="2" width="250"><?= __("Status Pengambilan") ?></th>
                    </tr>
                    <tr>
                        <th colspan="2"><?= __("Jumlah") ?></th>
                        <th colspan="2"><?= __("Dibulatkan") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                    $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                    $i = ($limit * $page) - ($limit - 1);
                    if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan = "10">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        foreach ($data['rows'] as $item) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']["full_name"]; ?></span></td>
                                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['CooperativeRemainingOperationDetail']['duration'] ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "50">Bln </td>
                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeRemainingOperationDetail']['amount']) ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CooperativeRemainingOperationDetail']['abs_amount']) ?></td>
                                <td class="text-center">
                                    <?php
                                    if (!empty($item['CooperativeRemainingOperationDetail']['payment_date'])) {
                                        echo $this->Html->cvtTanggal($item['CooperativeRemainingOperationDetail']['payment_date']);
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td class="text-center"  id = "target-change-status<?= $i ?>">
                                    <?php
                                    if ($item['CooperativeRemainingOperationDetail']['verify_status_id'] == 2) {
                                        echo "Ditolak";
                                    } else if ($item['CooperativeRemainingOperationDetail']['verify_status_id'] == 3) {
                                        echo "Disetujui";
                                    } else {
                                        echo $this->Html->changeStatusSelect($item['CooperativeRemainingOperationDetail']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['CooperativeRemainingOperationDetail']['verify_status_id'], Router::url("/admin/cooperative_remaining_operation_details/change_status_verify"), "#target-change-status$i");
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php // echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>