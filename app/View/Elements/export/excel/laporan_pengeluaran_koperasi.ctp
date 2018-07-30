<h2 style="text-align: center">
    Laporan Pengeluaran Koperasi
</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="1"><strong><i class="icon-coin" style="color:green;"></i>&nbsp;&nbsp;Total Pengeluaran</strong></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "300">
                            <strong>
                                <?php
                                $totalEarning = 0;
                                if (!empty($data['rows'])) {
                                    foreach ($data['rows'] as $earning) {
                                        $totalEarning += $earning['CooperativeTransactionMutation']['nominal'];
                                    }
                                    echo $this->Html->Rp($totalEarning);
                                } else {
                                    echo $this->Html->Html->Rp($totalEarning);
                                }
                                ?>
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 400px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Departemen") ?></th>
                            <th><?= __("Tipe Transaksi") ?></th>
                            <th width="250"><?= __("Tanggal") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'][0]['EmployeeDataDeposit']) && empty($data['rows'][0]['EmployeeDataLoan'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Employee']['nip']) ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                                    <td class="text-center"><?= $item['CooperativeTransactionType']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeTransactionMutation']['transaction_date']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeTransactionMutation']['nominal']) ?></td>
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
</div>