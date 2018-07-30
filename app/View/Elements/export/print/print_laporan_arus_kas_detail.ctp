<table width="100%" style = "border: 1px solid; font-size: 14px;">
    <thead>
        <tr> 
            <th width="50"></th>
            <th width="50"></th>
            <th></th>
            <th></th>
            <th colspan="2"></th>
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
                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="6"><strong>Operating Activities</strong></td>
            </tr>

            <!-- Pembelian -->
            <tr>
                <td></td>
                <td colspan="5"><strong>Pembelian</strong></td>
            </tr>
            <?php
            $totalCashDisbursement = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 4) {
                    $totalCashDisbursement += $item['TransactionMutation']['credit'] * -1;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-left"><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td class="text-left"><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['credit'] * -1) : ac_dollar($item['TransactionMutation']['credit'] * -1) ?></td>
                    </tr>                        
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Pembelian : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($totalCashDisbursement) : ac_dollar($totalCashDisbursement) ?></strong></td>
            </tr>

            <!--Pendapatan-->
            <tr>
                <td></td>
                <td colspan="5"><strong>Pendapatan</strong></td>
            </tr>
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
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-left"><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td class="text-left"><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['debit']) : ac_dollar($item['TransactionMutation']['debit']) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Pendapatan : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong> <?= $currency_type == 1 ? ic_rupiah($totalPaymentSale) : ac_dollar($totalPaymentSale) ?></strong></td>
            </tr>

            <!--Kas Keluar-->
            <tr>
                <td></td>
                <td colspan="5"><strong>Kas Keluar</strong></td>
            </tr>
            <?php
            $totalCashOut = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 2) {
                    $totalCashOut += $item['TransactionMutation']['credit'] * -1;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-left"><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td class="text-left"><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['credit'] * -1) : ac_dollar($item['TransactionMutation']['credit'] * -1) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Kas Keluar : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong> <?= $currency_type == 1 ? ic_rupiah($totalCashOut) : ac_dollar($totalCashOut) ?></strong></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3"><strong>Total Operating Activities : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right">
                    <strong>
                        <?php
                        $totalOperatingActivities = $totalCashDisbursement + $totalCashOut + $totalPaymentSale;
                        echo $currency_type == 1 ? ic_rupiah($totalOperatingActivities) : ac_dollar($totalOperatingActivities) . "</strong>";
                        ?>
                    </strong>
                </td>
            </tr>

            <!--Financial Activities-->
            <tr>
                <td colspan="6"><strong>Financial Activities</strong></td>
            </tr>

            <!-- Modal -->
            <tr>
                <td></td>
                <td colspan="5"><strong>Modal</strong></td>
            </tr>
            <?php
            $totalCapital = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 7) {
                    $totalCapital += $item['TransactionMutation']['debit'];
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['debit']) : ac_dollar($item['TransactionMutation']['debit']) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Modal : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($totalCapital) : ac_dollar($totalCapital) ?></strong></td>
            </tr>

            <!-- Asset -->
            <tr>
                <td></td>
                <td colspan="5"><strong>Aset</strong></td>
            </tr>
            <?php
            $totalAsset = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 11) {
                    $totalAsset += $item['TransactionMutation']['debit'];
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['debit']) : ac_dollar($item['TransactionMutation']['debit']) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Aset : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($totalAsset) : ac_dollar($totalAsset) ?></strong></td>
            </tr>

            <!--Kas Masuk-->
            <tr>
                <td></td>
                <td colspan="5"><strong>Kas Masuk</strong></td>
            </tr>
            <?php
            $totalCashIn = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 1) {
                    $totalCashIn += $item['TransactionMutation']['debit'];
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['debit']) : ac_dollar($item['TransactionMutation']['debit']) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Kas Masuk : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($totalCashIn) : ac_dollar($totalCashIn) ?></strong></td>
            </tr>

            <!--Mutasi Kas-->
            <tr>
                <td></td>
                <td colspan="5"><strong>Mutasi Kas</strong></td>
            </tr>
            <?php
            $totalCashMutation = 0;
            foreach ($data['rows'] as $item) {
                if ($item['TransactionMutation']['transaction_type_id'] == 5) {
                    $totalCashMutation += $item['TransactionMutation']['credit'] * -1;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?= $item['TransactionMutation']['reference_number'] ?></td>
                        <td><?= $item['TransactionMutation']['transaction_name'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                        <td class="text-right"><?= $currency_type == 1 ? ic_rupiah($item['TransactionMutation']['credit'] * -1) : ac_dollar($item['TransactionMutation']['credit'] * -1) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td colspan="2"></td>
                <td colspan="2"><strong>Total Mutasi Kas : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class='text-right'><strong><?= $currency_type == 1 ? ic_rupiah($totalCashMutation) : ac_dollar($totalCashMutation) ?></strong></td>
            </tr>

            <!--Gaji Harian Karyawan-->
            <tr>
                <td></td>
                <td colspan="5"><strong>Gaji Karyawan</strong></td>
            </tr>
            <?php
            $totalDailyEmployeeSalary = 0;
            if (!empty($dataDailySalary)) {
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $dataDailySalary[0]['TransactionMutation']['reference_number'] ?></td>
                    <td><?= $dataDailySalary[0]['TransactionMutation']['transaction_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                    <td class='text-right'>
                        <?php
                        foreach ($dataDailySalary as $temp2) {
                            foreach ($temp2['EmployeeSalary']['ParameterEmployeeSalary'] as $salaries) {
                                $totalDailyEmployeeSalary += $salaries['nominal'];
                            }
                        }
                        $totalDailyEmployeeSalary *= -1;
                        if ($currency_type == 1) {
                            echo ic_rupiah($totalDailyEmployeeSalary);
                        } else {
                            echo ac_dollar($totalDailyEmployeeSalary);
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            $totalMonthlyEmployeeSalary = 0;
            if (!empty($dataMonthlySalary)) {
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $dataMonthlySalary[0]['TransactionMutation']['reference_number'] ?></td>
                    <td><?= $dataMonthlySalary[0]['TransactionMutation']['transaction_name'] ?></td>
                    <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                    <td class='text-right'>
                        <?php
                        foreach ($dataMonthlySalary as $temp) {
                            foreach ($temp['EmployeeSalary']['ParameterEmployeeSalary'] as $salaries) {
                                $totalMonthlyEmployeeSalary += $salaries['nominal'];
                            }
                        }
                        $totalMonthlyEmployeeSalary *= -1;
                        if ($currency_type == 1) {
                            echo ic_rupiah($totalMonthlyEmployeeSalary);
                        } else {
                            echo ac_dollar($totalMonthlyEmployeeSalary);
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <?php
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"><hr></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Total Gaji Karyawan : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <?php
                $totalSalaryEmployee = $totalDailyEmployeeSalary + $totalMonthlyEmployeeSalary;
                ?>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($totalSalaryEmployee) : ac_dollar($totalSalaryEmployee) ?></strong></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3"><strong>Total Financial Activities : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right">
                    <strong>
                        <?php
                        $totalFinancialActivities = $totalCapital + $totalAsset + $totalCashIn + $totalCashMutation + $totalDailyEmployeeSalary + $totalMonthlyEmployeeSalary;
                        echo $currency_type == 1 ? ic_rupiah($totalFinancialActivities) : ac_dollar($totalFinancialActivities);
                        ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total Keluar/Masuk Kas</strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right">
                    <strong>
                        <?php
                        $totalKasMasukKeluar = $totalFinancialActivities + $totalOperatingActivities;
                        if ($currency_type == 1) {
                            echo ic_rupiah($totalKasMasukKeluar);
                        } else {
                            echo ac_dollar($totalKasMasukKeluar);
                        }
                        ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="4"><strong>Saldo Awal : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right"><strong><?= $currency_type == 1 ? ic_rupiah($data['rows'][0]['TransactionMutation']['initial_balance']) : ac_dollar($data['rows'][0]['TransactionMutation']['initial_balance']) ?></strong></td>
            </tr>

            <tr>
                <td colspan="4"><strong>Saldo Akhir : </strong></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50"><?= $currency ?></td>
                <td class="text-right">
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
                        echo $currency_type == 1 ? ic_rupiah($dataTransactionMutation['TransactionMutation']['mutation_balance']) : ac_dollar($dataTransactionMutation['TransactionMutation']['mutation_balance']);
                        ?>
                    </strong>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>