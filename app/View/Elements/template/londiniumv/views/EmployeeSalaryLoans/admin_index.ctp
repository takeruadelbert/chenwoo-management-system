<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-salary-loan");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Data Potongan Gaji Kasbon") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th width="300"><?= __("Nama Pegawai") ?></th>
                            <th width="200"><?= __("Nik Pegawai") ?></th>
                            <th><?= __("Nomor Pinjaman") ?></th>
                            <th width="200"><?= __("Jumlah Potongan (Rp)") ?></th>
                            <th width="200"><?= __("Periode") ?></th>
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
                                <td class = "text-center" colspan ="6">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['EmployeeSalary']['Employee']["Account"]["Biodata"]["full_name"] ?></td>
                                    <td class="text-left"><?= $item['EmployeeSalary']['Employee']["nip"] ?></td>
                                    <td class="text-left"><?= $item['EmployeeDataLoan']['receipt_loan_number'] ?></td>
                                    <td class="text-right"><?= ic_rupiah($item['EmployeeSalaryLoan']['amount']) ?></td>
                                    <td class="text-left"><?= $this->Echo->laporanPeriodeBulan($item['EmployeeSalary']['start_date_period'], $item['EmployeeSalary']['end_date_period']) ?></td>
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