<h2 style="text-align: center">
    Data Pembeli
</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("ID Pembeli") ?></th>
                            <th><?= __("Tipe Pembeli") ?></th>
                            <th><?= __("Nama Perusahaan") ?></th>
                            <th><?= __("Kode Perusahaan") ?></th>
                            <th><?= __("Alamat") ?></th>
                            <th><?= __("Provinsi") ?></th>
                            <th><?= __("Kota") ?></th>
                            <th><?= __("Negara") ?></th>
                            <th><?= __("No. Telepon") ?></th>
                            <th><?= __("Email") ?></th>
                            <th><?= __("Website") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['id_buyer']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['BuyerType']['name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['company_name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['company_uniq_name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['address']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['State']['name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['City']['name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Country']['name']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['phone_number']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['email']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Buyer']['website']) ?></td>
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
