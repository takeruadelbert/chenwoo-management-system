<table width="100%" style = "border: 1px solid !important; font-size: 14px;">
    <thead>
        <tr>
            <th width="50" ></th>
            <th width="50"></th>
            <th width="10"></th>
            <th style="border-right: 1px solid;" colspan="2"></th>
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
                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="5"  style="border-right: 1px solid;"><strong>Operating Activities</strong></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Pembelian</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"  style="border-right: 1px solid;" width="150">
                    <?php
                    $totalPaymentPurchase = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 4) {
                            $totalPaymentPurchase += $item['TransactionMutation']['credit'] * -1;
                        }
                    }
                    if ($currency_type == 1) {
                        echo ic_rupiah($totalPaymentPurchase);
                    } else {
                        echo ac_dollar($totalPaymentPurchase);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Pendapatan</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"  style="border-right: 1px solid;">
                    <?php
                    $totalPaymentSale = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 3) {
                            if (!empty($item['TransactionMutation']['shipment_id'])) {
                                if ($item['Shipment']['Sale']['Buyer']['buyer_type_id'] == 2) {
                                    $totalPaymentSale += $item['TransactionMutation']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                } else {
                                    $totalPaymentSale += $item['TransactionMutation']['debit'];
                                }
                            } else if (!empty($item['TransactionMutation']['sale_product_additional_id'])) {
                                $totalPaymentSale += $item['TransactionMutation']['debit'];
                            } else {
                                $totalPaymentSale += $item['TransactionMutation']['debit'];
                            }
                        }
                    }
                    if ($currency_type == 1) {
                        echo ic_rupiah($totalPaymentSale);
                    } else {
                        echo ac_dollar($totalPaymentSale);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Kas Keluar</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"  style="border-right: 1px solid;">
                    <?php
                    $totalCashOut = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 2) {
                            $totalCashOut += $item['TransactionMutation']['credit'] * -1;
                        }
                    }
                    if($currency_type == 1) {
                        echo ic_rupiah($totalCashOut);
                    } else {
                        echo ac_dollar($totalCashOut);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3" style="border-right: 1px solid;"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total Operating Activities : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <strong>
                        <?php
                        $totalOperatingActivities = $totalCashOut + $totalPaymentPurchase + $totalPaymentSale;
                        if($currency_type == 1) {
                            echo ic_rupiah($totalOperatingActivities);
                        } else {
                            echo ac_dollar($totalOperatingActivities);
                        }
                        ?>
                    </strong>
                </td>
            </tr>

            <tr>
                <td colspan="5"><strong>Financing Activites</strong></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Modal</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalCapital = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 7) {
                            $totalCapital += $item['TransactionMutation']['debit'];
                        }
                    }
                    if($currency_type == 1) {
                        echo ic_rupiah($totalCapital);
                    } else {
                        echo ac_dollar($totalCapital);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Aset</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalAsset = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 11) {
                            $totalAsset += $item['TransactionMutation']['debit'];
                        }
                    }
                    if($currency_type == 1) {
                        echo ic_rupiah($totalAsset);
                    } else {
                        echo ac_dollar($totalAsset);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Kas Masuk</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalCashIn = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 1) {
                            $totalCashIn += $item['TransactionMutation']['debit'];
                        }
                    }
                    if($currency_type == 1) {
                        echo ic_rupiah($totalCashIn);
                    } else {
                        echo ac_dollar($totalCashIn);
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Mutasi Kas</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalCashMutation = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 5) {
                            $totalCashMutation += $item['TransactionMutation']['credit'] * -1;
                        }
                    }
                    if($currency_type == 1) {
                        echo ic_rupiah($totalCashMutation);
                    } else {
                        echo ac_dollar($totalCashMutation);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>Gaji Harian Karyawan</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalDailyEmployeeSalary = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 6 && !empty($item['EmployeeSalary']['id'])) {
                            if ($item['EmployeeSalary']['Employee']['employee_type_id'] == 1) {
                                foreach ($item['EmployeeSalary']['ParameterEmployeeSalary'] as $salaries) {
                                    $totalDailyEmployeeSalary += $salaries['nominal'];
                                }
                            }
                        }
                    }
                    $totalDailyEmployeeSalary *= -1;
                    if($currency_type == 1) {
                        echo ic_rupiah($totalDailyEmployeeSalary);
                    } else {
                        echo ac_dollar($totalDailyEmployeeSalary);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>Gaji Bulanan Karyawan</td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <?php
                    $totalMonthlyEmployeeSalary = 0;
                    foreach ($data['rows'] as $item) {
                        if ($item['TransactionMutation']['transaction_type_id'] == 6 && !empty($item['EmployeeSalary']['id'])) {
                            if ($item['EmployeeSalary']['Employee']['employee_type_id'] == 2) {
                                foreach ($item['EmployeeSalary']['ParameterEmployeeSalary'] as $salaries) {
                                    $totalMonthlyEmployeeSalary += $salaries['nominal'];
                                }
                            }
                        }
                    }
                    $totalMonthlyEmployeeSalary *= -1;
                    if($currency_type == 1) {
                        echo ic_rupiah($totalMonthlyEmployeeSalary);
                    } else {
                        echo ac_dollar($totalMonthlyEmployeeSalary);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="3" style="border-right: 1px solid;"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total Financing Activities</strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <strong>
                        <?php
                        $totalFinancialActivities = $totalCapital + $totalAsset + $totalCashIn + $totalCashMutation + $totalDailyEmployeeSalary + $totalMonthlyEmployeeSalary;
                        if($currency_type == 1) {
                            echo ic_rupiah($totalFinancialActivities);
                        } else {
                            echo ac_dollar($totalFinancialActivities);
                        }
                        ?>
                    </strong>
                </td>
            </tr>

            <tr>
                <td colspan="3"><strong>Total Masuk/Keluar Kas : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <strong>
                        <?php
                        $totalArusKas = $totalFinancialActivities + $totalOperatingActivities;
                        if($currency_type == 1) {
                            echo ic_rupiah($totalArusKas);
                        } else {
                            echo ac_dollar($totalArusKas);
                        }
                        ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>Saldo Awal : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <strong>
                        <?= $currency_type == 1 ? ic_rupiah($data['rows'][0]['TransactionMutation']['initial_balance']) : ac_dollar($data['rows'][0]['TransactionMutation']['initial_balance']) ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>Saldo Akhir : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right" style="border-right: 1px solid;">
                    <strong>
                        <?php
                        $dataTransactionMutation = ClassRegistry::init("TransactionMutation")->find("first", [
                            "conditions" => [
                                "TransactionMutation.initial_balance_id" => $this->request->query['select_TransactionMutation_initial_balance_id'],
                                "TransactionMutation.initial_balance !=" => null,
                                "TransactionMutation.mutation_balance !=" => null
                            ],
                            "order" => "TransactionMutation.id DESC"
                        ]);
                        if($currency_type == 1) {
                            echo ic_rupiah($dataTransactionMutation['TransactionMutation']['mutation_balance']);
                        } else {
                            echo ac_dollar($dataTransactionMutation['TransactionMutation']['mutation_balance']);
                        }
                        ?>
                    </strong>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>