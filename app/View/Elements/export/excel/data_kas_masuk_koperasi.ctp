<h2 style="text-align: center">
    Data Kas Masuk Koperasi
</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 400px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor Kas Masuk") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Tipe Kas Koperasi") ?></th>
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
                                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['CooperativeCashIn']['cash_in_number'] ?></td>
                                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCashIn']['amount']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CooperativeCashIn']['created_datetime']) ?></td>
                                    <td class="text-center"><?= $item['CooperativeCash']['name'] ?></td>
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