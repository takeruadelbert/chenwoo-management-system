<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Detail Pengepakan yang sudah Dilakukan per Produk") ?>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-box-add"></i><?= __("Detail Pengepakan yang sudah Dilakukan") ?></h6>
                </div>
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor MC") ?></th>
                            <th><?= __("Nama Produk") ?></th>
                            <th><?= __("PDC") ?></th>
                            <th colspan="2"><?= __("Berat Bersih") ?></th>
                            <th colspan="2"><?= __("Berat Kotor") ?></th>
                            <th colspan="2"><?= __("Jumlah Kemasan") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <!-- <th width="50">< ?= __("Aksi") ?></th> -->

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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["PackageDetail"]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['PackageDetail']['package_no']; ?></span></td>
                                    <?php if (!empty($item['Product']['Parent'])) {
                                        ?>
                                        <td class="text-center"><span><?php echo $item['Product']['Parent']['name'] . " " . $item['Product']['name']; ?></span></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center"><span><?php echo $item['Product']['name'] ?></span></td>
                                        <?php
                                    }
                                    ?>

                                    <td class="text-left">
                                        <?php
                                        foreach ($item['PackageDetailProduct'] as $itemss) {
                                            ?>
                                            <?php echo $itemss['ProductDetail']['batch_number'] . "<br> "; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['nett_weight']); ?> </span></td>
                                    <td class="text-center" width = "30"><span>Kg</span></td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['brut_weight']); ?> </span></td>
                                    <td class="text-center" width = "30"><span>Kg</span></td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['quantity_per_pack']); ?> </span></td>
                                    <td class="text-center" width = "40"><span>Pcs</span></td>
                                    <td class="text-center">
                                        <?php
                                            echo $this->Html->cvtTanggal($item["PackageDetail"]['modified']);
                                        ?>
                                    </td> 
                                    <!--<td class="text-center">
                                        <a href = "< ?= Router::url("/admin/{$this->params['controller']}/reset_package/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Reset Penjualan"><i class = "icon-unlocked"></i></a>
                                    </td> -->
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