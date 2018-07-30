<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Transaksi Jurnal Umum
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : 
        <?php
        if (!empty($startDate) && !empty($endDate)) {
            echo $this->Html->cvtTanggal($startDate)
            ?> - <?=
            $this->Html->cvtTanggal($endDate);
        } else {
            echo $this->Html->getBulan(date("Y-m-d")) . " " . $currentYear;
        }
        ?>
    </div>
</div>
<br/>
<table width="100%" class="table-data" style = "border:1px solid !important; font-family:Tahoma, Geneva, sans-serif; font-size:10px; line-height:20px;">
    <thead>
        <tr style = "border:1px solid !important">
            <th width="110" valign="middle" class = "text-center" style = "border:1px solid !important"><?= __("Tanggal Transaksi") ?></th>
            <th width="250" valign="middle" class = "text-center" style = "border:1px solid !important"><?= __("Nomor Referensi") ?></th>
            <th width="350" class = "text-center" style = "border:1px solid !important"><?= __("Keterangan") ?></th>
            <th class = "text-center" colspan = "2" style = "border:1px solid !important"><?= __("Debit") ?></th>
            <th class = "text-center" colspan = "2" style = "border:1px solid !important"><?= __("Kredit") ?></th>
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
                    <td class="text-center"  style = "border:1px solid !important"><?= $this->Html->cvtTanggal($item['GeneralEntry']['transaction_date']) ?></td>
                    <td class="text-left" style = "border:1px solid !important"><?= $item['GeneralEntry']['reference_number'] ?></td>
                    <td class="text-left" style = "border:1px solid !important"><?= $item['GeneralEntry']['transaction_name'] ?></td>
                    <?php
                    if (!empty($item['GeneralEntry']['initial_balance_id'])) {
                        if ($item['InitialBalance']['Currency']['id'] == 1) {
                            ?>
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                <?php
                                if (!empty($item['GeneralEntry']['debit'])) {
                                    echo ic_rupiah($item['GeneralEntry']['debit']);
                                    $totalDebet += $item['GeneralEntry']['debit'];
                                } else {
                                    echo ic_rupiah(0);
                                }
                                ?>
                            </td>
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                    <?php
                                    if (!empty($item['GeneralEntry']['debit'])) {
                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate']);
                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate'];
                                    } else {
                                        echo ic_rupiah(0);
                                    }
                                    ?>
                                </td>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                    <?php
                                    if (!empty($item['GeneralEntry']['debit'])) {
                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate']);
                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                    } else {
                                        echo ic_rupiah(0);
                                    }
                                    ?>
                                </td>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                            } else {
                                ?>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                    <?php
                                    if (!empty($item['GeneralEntry']['debit'])) {
                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate']);
                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate'];
                                    } else {
                                        echo ic_rupiah(0);
                                    }
                                    ?>
                                </td>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <?php
                            if ($item['Shipment']['Sale']['Buyer']['buyer_type_id'] == 2) {
                                ?>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                    <?php
                                    if (!empty($item['GeneralEntry']['debit'])) {
                                        echo ic_rupiah($item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate']);
                                        $totalDebet += $item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                    } else {
                                        echo ic_rupiah(0);
                                    }
                                    ?>
                                </td>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                    <?php
                                    if (!empty($item['GeneralEntry']['debit'])) {
                                        echo ic_rupiah($item['GeneralEntry']['debit']);
                                        $totalDebet += $item['GeneralEntry']['debit'];
                                    } else {
                                        echo ic_rupiah(0);
                                    }
                                    ?>
                                </td>
                                <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                                <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
                                <?php
                                if (!empty($item['GeneralEntry']['debit'])) {
                                    echo ic_rupiah($item['GeneralEntry']['debit']);
                                    $totalDebet += $item['GeneralEntry']['debit'];
                                } else {
                                    echo ic_rupiah(0);
                                }
                                ?>
                            </td>
                            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp. </td>
                            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid;" width = "150">
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
            <td class = "text-right" colspan = 3><strong>Grand Total</strong></td>
            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp.</td>
            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid; font-weight: bold;" width = "150"><?= ic_rupiah($totalDebet) ?></td>
            <td class="text-center" style = "border-top:1px solid; border-left:1px solid; border-bottom:1px solid;" width = "50">Rp.</td>
            <td class="text-right" style = "border-top:1px solid; border-right:1px solid; border-bottom:1px solid; font-weight: bold;" width = "150"><?= ic_rupiah($totalCredit) ?></td>
        </tr>
    </tfoot>
</table>
