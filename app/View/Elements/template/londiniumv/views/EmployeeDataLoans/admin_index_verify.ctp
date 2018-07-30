<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-data-loan-verify");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI PINJAMAN PEGAWAI") ?>
                <div class="pull-right">
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table style="width:100%;" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?= __("Tipe Pinjaman") ?></th>
                            <th><?= __("Nomor Pinjaman") ?></th>
                            <th><?= __("Pegawai Peminjam") ?></th>                            
                            <th><?= __("NIP Pegawai Peminjam") ?></th>                            
                            <th><?= __("Departement Pegawai Peminjam") ?></th>                            
                            <th><?= __("Operator Pelaksana") ?></th>                            
                            <th colspan = "2"><?= __("Jumlah Pinjaman") ?></th>
                            <th><?= __("Bunga") ?></th>
                            <th colspan = "2"><?= __("Jumlah Tanggungan") ?></th>
                            <th><?= __("Tanggal Pinjaman") ?></th>
                            <th><?= __("Tenor") ?></th>
                            <th colspan = "2"><?= __("Sisa Pinjaman") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = "18">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">                                    
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CooperativeLoanType']['name'] ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-left"><?= $item['Employee']['nip'] ?></td>
                                    <td class="text-left"><?= $item['Employee']['Department']['name'] ?></td>
                                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['amount_loan__ic'] ?></td>
                                    <td class="text-right" ><?= $item['EmployeeDataLoan']['interest_rate'] ?> %</td>
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['total_amount_loan__ic'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeDataLoan']['date']) ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataLoan']['installment_number'] ?> bulan</td>
                                    <td class="text-center" style = "border-right-style:none !important">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['EmployeeDataLoan']['remaining_loan__ic'] ?></td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeDataLoan']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['EmployeeDataLoan']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['EmployeeDataLoan']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['EmployeeDataLoan']['verify_status_id'], Router::url("/admin/employee_data_loans/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal"  data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-pnju&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" class="btn btn-default btn-xs btn-icon btn-icon" title="Lihat Data Pinjaman"><i class="icon-eye7"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>