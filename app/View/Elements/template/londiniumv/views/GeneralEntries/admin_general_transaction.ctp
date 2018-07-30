<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/general-transaction");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("TRANSAKSI UMUM") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("general_transaction/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("general_transaction/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 600px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><?= __("Tanggal Transaksi") ?></th>
                            <th><?= __("Nomor Referensi") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th colspan = "2"><?= __("Debit") ?></th>
                            <th colspan = "2"><?= __("Kredit") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalDebet = 0;
                        $totalCredit = 0;
                        if (empty($generalEntries)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($generalEntries as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['GeneralEntry']['transaction_date']) ?></td>
                                    <td class="text-left"><?= $item['GeneralEntry']['reference_number'] ?></td>
                                    <td class="text-left"><?= $item['GeneralEntry']['transaction_name'] ?></td>
                                    <?php
                                    if (!empty($item['InitialBalance']['id'])) {
                                        if ($item['InitialBalance']['Currency']['id'] == 1) {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['debit'])) {
                                                    echo ic_rupiah($item['GeneralEntry']['debit']);
                                                    $totalDebet += $item['GeneralEntry']['debit'];
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['credit'])) {
                                                    echo ic_rupiah($item['GeneralEntry']['credit']);
                                                    $totalCredit += $item['GeneralEntry']['credit'];
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <?php
                                        } else {
                                            if ($item['InitialBalance']['Currency']['id'] == 2 && !empty($item['GeneralEntry']['sale_id']) && empty($item['GeneralEntry']['payment_sale_id'])) {
                                                ?>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['Sale']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            } else if ($item['InitialBalance']['Currency']['id'] == 2 && empty($item['GeneralEntry']['sale_id']) && !empty($item['GeneralEntry']['payment_sale_id'])) {
                                                ?>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['PaymentSale']['Sale']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            } else if ($item['InitialBalance']['Currency']['id'] == 2 && $item['GeneralEntry']['is_from_general_transaction']) {
                                                ?>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['InitialBalance']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['InitialBalance']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($item['GeneralEntry']['shipment_id'])) {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <?php
                                            if ($item['Shipment']['Sale']['Buyer']['buyer_type_id'] == 2) {
                                                ?>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>      
                                                <?php
                                            } else {
                                                ?>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['debit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit']);
                                                        $totalDebet += $item['GeneralEntry']['debit'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                                <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                    <?php
                                                    if (!empty($item['GeneralEntry']['credit'])) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit']);
                                                        $totalCredit += $item['GeneralEntry']['credit'];
                                                    } else {
                                                        echo ic_rupiah(0);
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            }
                                        } else if ($item['GeneralEntry']['is_from_general_transaction']) {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['debit'])) {
                                                    if ($item['GeneralEntryType']['currency_id'] == 1) {
                                                        echo ic_rupiah($item['GeneralEntry']['debit']);
                                                        $totalDebet += $item['GeneralEntry']['debit'];
                                                    } else {
                                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate']);
                                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate'];
                                                    }
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['credit'])) {
                                                    if ($item['GeneralEntryType']['currency_id'] == 1) {
                                                        echo ic_rupiah($item['GeneralEntry']['credit']);
                                                        $totalCredit += $item['GeneralEntry']['credit'];
                                                    } else {
                                                        echo ic_rupiah($item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate']);
                                                        $totalCredit += $item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate'];
                                                    }
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['debit'])) {
                                                    echo ic_rupiah($item['GeneralEntry']['debit']);
                                                    $totalDebet += $item['GeneralEntry']['debit'];
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150">
                                                <?php
                                                if (!empty($item['GeneralEntry']['credit'])) {
                                                    echo ic_rupiah($item['GeneralEntry']['credit']);
                                                    $totalCredit += $item['GeneralEntry']['credit'];
                                                } else {
                                                    echo ic_rupiah(0);
                                                }
                                                ?>
                                            </td>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center"><strong>Total</strong></td>
                            <td class="text-center" style = "border-right-style:none !important; font-weight: bold;" width = "50" >Rp. </td>
                            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($totalDebet) ?></strong></td>
                            <td class="text-center" style = "border-right-style:none !important; font-weight: bold;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($totalCredit) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>