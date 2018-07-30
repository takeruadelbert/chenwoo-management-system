<table width="100%" class="" style="border: none !important; font-size:10px; font-family:Tahoma, Geneva, sans-serif;">
    <?php
    $totalAktiva = [];
    for ($i = 0; $i < 12; $i++) {
        $totalAktiva[$i] = 0;
    }
    ?>
    <tr>
        <td><strong>Harta</strong></td>
        <td colspan="4"></td>
        <?php
        $months = $this->Echo->periodeBulanSingkatan();
        foreach ($months as $month) {
            ?>
            <td class="text-center"><strong><?= $month ?></strong></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Kas</strong></td>
        <td colspan="12"></td>
    </tr>

    <!-- Kas -->
    <?php
    $currentYear = date("Y");
    $cash = ClassRegistry::init("InitialBalance")->find("all", [
        "contain" => [
            "GeneralEntryType"
        ],
        "order" => "GeneralEntryType.code"
    ]);
    $totalKas = [];
    foreach ($cash as $kas) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td width="1%"></td>
            <td><?= $kas['GeneralEntryType']['code'] ?></td>
            <td><?= $kas['GeneralEntryType']['name'] ?></td>
            <?php
            for ($i = 0; $i < 12; $i++) {
                $totalKas[$i] = 0;
                $totalPerKas = 0;
                $cashGeneralEntry = ClassRegistry::init("GeneralEntry")->find("all", [
                    "conditions" => [
                        "GeneralEntry.general_entry_type_id" => $kas['InitialBalance']['general_entry_type_id'],
                        "MONTH(GeneralEntry.transaction_date)" => ($i + 1),
                        "YEAR(GeneralEntry.transaction_date)" => $currentYear
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "Currency"
                        ]
                    ],
                ]);
                foreach ($cashGeneralEntry as $total) {
                    if (!empty($total['GeneralEntry']['initial_balance_id'])) {
                        if ($total['InitialBalance']['currency_id'] == 1) {
                            $totalPerKas += $total['GeneralEntry']['debit'];
                            $totalPerKas += $total['GeneralEntry']['credit'] * -1;
                        } else {
                            if ($total['GeneralEntry']['is_from_general_transaction']) {
                                $totalPerKas += $total['GeneralEntry']['debit'] * $total['GeneralEntry']['exchange_rate'];
                                $totalPerKas += $total['GeneralEntry']['credit'] * -1 * $total['GeneralEntry']['exchange_rate'];
                            } else {
                                $totalPerKas += $total['GeneralEntry']['debit'] * $total['InitialBalance']['exchange_rate'];
                                $totalPerKas += $total['GeneralEntry']['credit'] * -1 * $total['InitialBalance']['exchange_rate'];
                            }
                        }
                    } else {
                        $totalPerKas += $total['GeneralEntry']['debit'];
                        $totalPerKas += $total['GeneralEntry']['credit'] * -1;
                    }
                }
                ?>
                <td class="text-right"><?= ic_rupiah($totalPerKas) ?></td>

                <?php
            }
            ?>
        </tr>       
        <?php
    }
    ?>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Kas</strong></td>
        <?php
        foreach ($dataAnnualKas as $index => $annualKas) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualKas) ?></td>
            <?php
            $totalKas[$index] += $annualKas;
        }
        ?>
    </tr>

    <?php
    $dataAnnualPiutang = [];
    for ($i = 0; $i < 12; $i++) {
        $dataAnnualPiutang[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Piutang</strong></td>
        <td colspan="12"></td>
    </tr>   

    <?php
    foreach ($dataCOAPiutang as $coapiutang) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td width="1%"></td>
            <td><?= $coapiutang['GeneralEntryType']['code'] ?></td>
            <td><?= $coapiutang['GeneralEntryType']['name'] ?></td>
            <?php
            $j = 0;
            for ($i = 1; $i <= 12; $i++) {
                $dataTransactions = ClassRegistry::init("GeneralEntry")->find("all", [
                    "conditions" => [
                        "GeneralEntry.general_entry_type_id" => $coapiutang['GeneralEntryType']['id'],
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                    ],
                    "contain" => [
                        "GeneralEntryType",
                        "InitialBalance",
                        "PaymentSale" => [
                            "Sale"
                        ],
                        "Shipment" => [
                            "Sale"
                        ]
                    ]
                ]);
                $totalPiutang = 0;
                $total = 0;
                if (!empty($dataTransactions)) {
                    foreach ($dataTransactions as $piutang) {
                        if (!$piutang['GeneralEntry']['is_from_general_transaction']) {
                            if (!empty($piutang['GeneralEntry']['initial_balance_id'])) {
                                if (!empty($piutang['GeneralEntry']['payment_sale_id'])) {
                                    if ($piutang['GeneralEntry']['initial_balance_id'] == 1) {
                                        $total += $piutang['GeneralEntry']['credit'] * -1;
                                    } else {
                                        $total += $piutang['GeneralEntry']['credit'] * $piutang['PaymentSale']['Sale']['exchange_rate'] * -1;
                                    }
                                } else if (!empty($piutang['GeneralEntry']['shipment_id'])) {
                                    if ($piutang['GeneralEntry']['initial_balance_id'] == 1) {
                                        $total += $piutang['GeneralEntry']['debit'];
                                    } else {
                                        $total += $piutang['GeneralEntry']['debit'] * $piutang['Shipment']['Sale']['exchange_rate'];
                                    }
                                } else {
                                    if ($piutang['GeneralEntry']['initial_balance_id'] == 1) {
                                        $total += $piutang['GeneralEntry']['credit'] * -1;
                                    } else {
                                        $total += $piutang['GeneralEntry']['credit'] * $piutang['InitialBalance']['exchange_rate'] * -1;
                                    }
                                }
                            }
                        }
                        $totalPiutang += $total;
                    }
                    ?>
                    <td class="text-right"><?= ic_rupiah($total) ?></td>
                    <?php
                } else {
                    ?>
                    <td class="text-right"><?= ic_rupiah($total) ?></td>
                    <?php
                }
                $dataAnnualPiutang[$j] += $totalPiutang;
                $j++;
            }
            ?>
        </tr>
        <?php
    }
    ?>

    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Piutang</strong></td>
        <?php
        foreach ($dataAnnualPiutang as $annualPiutang) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualPiutang) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalPiutangSupplier = [];
    for ($i = 0; $i < 12; $i++) {
        $totalPiutangSupplier[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Piutang Supplier</strong></td>
        <td colspan="12"></td>
    </tr>
    <?php
    foreach ($dataPiutangSupplier as $piutangSupplier) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td width="1%"></td>
            <td><?= $piutangSupplier['GeneralEntryType']['code'] ?></td>
            <td><?= $piutangSupplier['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataRincianPiutangSupplier as $rincianPiutangSupplier) {
                $total = 0;
                if (!empty($rincianPiutangSupplier)) {
                    foreach ($rincianPiutangSupplier as $rincian) {
                        if ($rincian['GeneralEntryType']['id'] == $piutangSupplier['GeneralEntryType']['id']) {
                            $total += $rincian['GeneralEntry']['credit'];
                        }
                    }
                }
                ?>
                <td class="text-right"><?= ic_rupiah($total) ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Piutang Supplier</strong></td>
        <?php
        foreach ($dataAnnualPiutangSupplier as $annualPiutangSupplier) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualPiutangSupplier) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalAssetBerwujud = [];
    for ($i = 0; $i < 12; $i++) {
        $totalAssetBerwujud[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Harta Tetap Berwujud</strong></td>
        <td colspan="12"></td>
    </tr>
    <?php
    if (!empty($dataAssetBerwujud)) {
        foreach ($dataAssetBerwujud as $assetBerwujud) {
            ?>
            <tr>
                <td></td>
                <td></td>
                <td width="1%"></td>
                <td><?= $assetBerwujud['GeneralEntryType']['code'] ?></td>
                <td><?= $assetBerwujud['GeneralEntryType']['name'] ?></td>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $asset = ClassRegistry::init("GeneralEntry")->find("all", [
                        "conditions" => [
                            "GeneralEntry.general_entry_type_id" => $assetBerwujud['AssetProperty']['general_entry_type_id'],
//                    "AssetProperty.asset_property_type_id" => 1,
                            "MONTH(GeneralEntry.transaction_date)" => $i,
                            "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                        ],
                        "contain" => [
                            "GeneralEntryType",
                            "AssetProperty"
                        ]
                    ]);
                    $nominal = 0;
                    if (!empty($asset)) {
                        foreach ($asset as $assets) {
                            $nominal += $assets['GeneralEntry']['debit'];
                        }
                    } else {
                        $nominal = 0;
                    }
                    $totalAssetBerwujud[$i - 1] += $nominal;
                    ?>
                    <td class="text-right"><?= ic_rupiah($nominal) ?></td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
    }
    ?>

    <?php
    $totalPenyusutanAsset = [];
    for ($i = 0; $i < 12; $i++) {
        $totalPenyusutanAsset[$i] = 0;
    }
    foreach ($dataPenyusutanAsset as $penyusutanAsset) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td width="1%"></td>
            <td><?= $penyusutanAsset['GeneralEntryType']['code'] ?></td>
            <td><?= $penyusutanAsset['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataAnnualPenyusutanAsset as $index => $annualPenyusutanAsset) {
                ?>
                <td class="text-right"><?= ic_rupiah($annualPenyusutanAsset) ?></td>
                <?php
                $totalAssetBerwujud[$index] += $annualPenyusutanAsset;
            }
            ?>
        </tr>
        <?php
    }
    ?>

    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Harta Tetap Berwujud</strong></td>
        <?php
        foreach ($totalAssetBerwujud as $assetBerwujudTotal) {
            ?>
            <td class="text-right"><?= ic_rupiah($assetBerwujudTotal) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalAssetTakBerwujud = [];
    for ($i = 0; $i < 12; $i++) {
        $totalAssetTakBerwujud[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Harta Tetap Tidak Berwujud</strong></td>
        <td colspan="12"></td>
    </tr>
    <?php
    if (!empty($dataAssetTakBerwujud)) {
        foreach ($dataAssetTakBerwujud as $assetTakBerwujud) {
            ?>
            <tr>
                <td></td>
                <td></td>
                <td width="1%"></td>
                <td><?= $assetTakBerwujud['GeneralEntryType']['code'] ?></td>
                <td><?= $assetTakBerwujud['GeneralEntryType']['name'] ?></td>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $asset = ClassRegistry::init("AssetProperty")->find("first", [
                        "conditions" => [
                            "AssetProperty.id" => $assetBerwujud['AssetProperty']['id'],
                            "AssetProperty.asset_property_type_id" => 2,
                            "MONTH(AssetProperty.created)" => $i,
                            "YEAR(AssetProperty.created)" => $this->request->query['year']
                        ]
                    ]);
                    if (!empty($asset)) {
                        $nominal = $asset['AssetProperty']['nominal'];
                    } else {
                        $nominal = 0;
                    }
                    $totalAssetTakBerwujud[$i - 1] += $nominal;
                    ?>
                    <td class="text-right"><?= ic_rupiah($nominal) ?></td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
    }
    ?>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Harta Tetap Tidak Berwujud</strong></td>
        <?php
        foreach ($totalAssetTakBerwujud as $assetTakBerwujudTotal) {
            ?>
            <td class="text-right"><?= ic_rupiah($assetTakBerwujudTotal) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    foreach ($totalAktiva as $index => $aktivaTotal) {
        $totalAktiva[$index] = $totalKas[$index] + $dataAnnualPiutang[$index] + $totalPiutangSupplier[$index] + $totalAssetBerwujud[$index] + $dataAnnualPiutangSupplier[$index];
    }
    ?>
    <tr>
        <td colspan="5" style="color: #993333;"><strong>Total Harta</strong></td>
        <?php
        foreach ($totalAktiva as $aktivaTotal) {
            ?>
            <td class="text-right" style="color: #993333;"><strong><?= ic_rupiah($aktivaTotal) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalPassiva = 0;
    ?>
    <tr>
        <td><strong>Kewajiban</strong></td>
        <td colspan="16"></td>
    </tr>
    <?php
    $totalHutang = [];
    for ($i = 0; $i < 12; $i++) {
        $totalHutang[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Hutang</strong></td>
        <td colspan="12"></td>
    </tr>

    <!-- Hutang Usaha -->
    <?php
    $totalPassiva = [];
    for ($i = 0; $i < 12; $i++) {
        $totalPassiva[$i] = 0;
    }
    $dataAnnualHutangUsaha = [];
    foreach ($dataHutangUsaha as $hutang) {
        ?>
        <tr>
            <td></td>
            <td></td>
            <td width="1%"></td>
            <td><?= $hutang['GeneralEntryType']['code'] ?></td>
            <td><?= $hutang['GeneralEntryType']['name'] ?></td>
            <?php
            $totalHutangParent = [];
            $totalHutangChild = [];
            $j = 0;
            for ($i = 1; $i <= 12; $i++) {
                $temp = ClassRegistry::init("GeneralEntry")->find("all", [
                    "conditions" => [
                        "GeneralEntry.general_entry_type_id" => $hutang['GeneralEntryType']['id'],
                        "MONTH(GeneralEntry.transaction_date)" => $i,
                        "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                    ],
                    "contain" => [
                        "InitialBalance" => [
                            "Currency"
                        ],
                        "GeneralEntryType"
                    ]
                ]);
                $totalCashDebit = 0;
                $totalCashCredit = 0;
                foreach ($temp as $cash) {
                    if ($cash['GeneralEntry']['is_from_general_transaction']) {
                        if ($cash['InitialBalance']['currency_id'] == 2) {
                            $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['GeneralEntry']['exchange_rate'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['GeneralEntry']['exchange_rate'];
                        } else {
                            $totalCashDebit += $cash['GeneralEntry']['debit'];
                            $totalCashCredit += $cash['GeneralEntry']['credit'];
                        }
                    } else {
                        $totalCashDebit += $cash['GeneralEntry']['debit'];
                        $totalCashCredit += $cash['GeneralEntry']['credit'];
                    }
                }
                $totalHutangParent[$j] = $totalCashCredit - $totalCashDebit;

                if (!empty($hutang['Child'])) {
                    foreach ($hutang['Child'] as $child) {
                        $temp = ClassRegistry::init("GeneralEntry")->find("all", [
                            "conditions" => [
                                "MONTH(GeneralEntry.transaction_date)" => $i,
                                "GeneralEntry.general_entry_type_id" => $child['id'],
                                "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                            ],
                            "contain" => [
                                "InitialBalance" => [
                                    "Currency"
                                ],
                                "GeneralEntryType"
                            ]
                        ]);
                        $totalCashDebit = 0;
                        $totalCashCredit = 0;
                        foreach ($temp as $cash) {
                            if ($cash['GeneralEntry']['is_from_general_transaction']) {
                                if ($cash['InitialBalance']['currency_id'] == 2) {
                                    $totalCashDebit += $cash['GeneralEntry']['debit'] * $cash['GeneralEntry']['exchange_rate'];
                                    $totalCashCredit += $cash['GeneralEntry']['credit'] * $cash['GeneralEntry']['exchange_rate'];
                                } else {
                                    $totalCashDebit += $cash['GeneralEntry']['debit'];
                                    $totalCashCredit += $cash['GeneralEntry']['credit'];
                                }
                            } else {
                                $totalCashDebit += $cash['GeneralEntry']['debit'];
                                $totalCashCredit += $cash['GeneralEntry']['credit'];
                            }
                        }
                        $totalHutangChild[$j] = $totalCashCredit - $totalCashDebit;
                    }
                } else {
                    $totalHutangChild[$j] = 0;
                }
                $dataAnnualHutangUsaha[$j] = $totalHutangParent[$j] + $totalHutangChild[$j];
                $totalPassiva[$j] += $dataAnnualHutangUsaha[$j];
                ?>
                <td class="text-right"><?= ic_rupiah($dataAnnualHutangUsaha[$j]) ?></td>
                <?php
                $j++;
            }
            ?>
        </tr>
        <?php
    }
    ?>

    <!-- Hutang Sub Child -->
    <?php
    $dataAnnualHutangSubChild = [];
    $coaSubChild = ClassRegistry::init("GeneralEntryType")->find("first", [
        "conditions" => [
            "GeneralEntryType.id" => 85
        ],
        "recursive" => -1
    ]);
    $j = 0;
    ?>
    <tr>
        <td></td>
        <td></td>
        <td width="1%"></td>
        <td><?= $coaSubChild['GeneralEntryType']['code'] ?></td>
        <td><?= $coaSubChild['GeneralEntryType']['name'] ?></td>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $temp = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => 85,
                    "MONTH(GeneralEntry.transaction_date)" => $i,
                    "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                ],
                'order' => "GeneralEntry.transaction_date",
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($temp as $subchild) {
                if ($subchild['GeneralEntryType']['currency_id'] == 1) {
                    $totalDebit += $subchild['GeneralEntry']['debit'];
                    $totalCredit += $subchild['GeneralEntry']['credit'];
                } else {
                    $totalDebit += $subchild['GeneralEntry']['debit'] * $subchild['GeneralEntry']['exchange_rate'];
                    $totalCredit += $subchild['GeneralEntry']['credit'] * $subchild['GeneralEntry']['exchange_rate'];
                }
            }
            $dataAnnualHutangSubChild[$j] = $totalCredit - $totalDebit;
            ?>
            <td class="text-right"><?= ic_rupiah($dataAnnualHutangSubChild[$j]) ?></td>
            <?php
            $totalPassiva[$j] += $dataAnnualHutangSubChild[$j];
            $j++;
        }
        ?>
    </tr>

    <!-- Hutang Lain-Lain -->
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Hutang Lain-Lain</strong></td>
        <td colspan="12"></td>
    </tr>
    <?php
    $dataAnnualHutangLain = [];
    foreach ($dataHutangLain as $hutangLain) {
        $j = 1;
        ?>
        <tr>
            <td colspan="2"></td>
            <td width="1%"></td>
            <td><?= $hutangLain['GeneralEntryType']['code'] ?></td>
            <td><?= $hutangLain['GeneralEntryType']['name'] ?></td>
            <?php
            for ($i = 0; $i < 12; $i++) {
                $dataTransactionHutangLain = ClassRegistry::init("GeneralEntry")->find("all", [
                    "conditions" => [
                        "GeneralEntry.general_entry_type_id" => $hutangLain['GeneralEntryType']['id'],
                        "MONTH(GeneralEntry.transaction_date)" => $j,
                        "YEAR(GeneralEntry.transaction_date)" => $this->request->query['year']
                    ],
                    "contain" => [
                        "GeneralEntryType"
                    ]
                ]);
                $total = 0;
                if (!empty($dataTransactionHutangLain)) {
                    foreach ($dataTransactionHutangLain as $transaksiHutangLain) {
                        if (!empty($transaksiHutangLain['GeneralEntry']['debit'])) {
                            if ($transaksiHutangLain['GeneralEntryType']['currency_id'] == 1) {
                                $total += $transaksiHutangLain['GeneralEntry']['debit'] * -1;
                            } else {
                                $total += $transaksiHutangLain['GeneralEntry']['debit'] * $transaksiHutangLain['GeneralEntry']['exchange_rate'] * -1;
                            }
                        }
                        if (!empty($transaksiHutangLain['GeneralEntry']['credit'])) {
                            if ($transaksiHutangLain['GeneralEntryType']['currency_id'] == 1) {
                                $total += $transaksiHutangLain['GeneralEntry']['credit'];
                            } else {
                                $total += $transaksiHutangLain['GeneralEntry']['credit'] * $transaksiHutangLain['GeneralEntry']['exchange_rate'];
                            }
                        }
                    }
                }
                ?>
                <td class="text-right"><?= ic_rupiah($total) ?></td>
                <?php
                $dataAnnualHutangLain[$i] = $total;
                $totalPassiva[$i] += $dataAnnualHutangLain[$i];
                $j++;
            }
            ?>
        </tr>
        <?php
    }
    ?>

    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Hutang Lain-Lain</strong></td>
        <?php
        foreach ($dataAnnualHutangLain as $annualHutangLain) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualHutangLain) ?></td>
            <?php
        }
        ?>
    </tr>

    <tr>
        <td colspan="5"><strong>Total Kewajiban</strong></td>
        <?php
        foreach ($totalPassiva as $passiva) {
            ?>
            <td class="text-right"><?= ic_rupiah($passiva) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalModal = [];
    for ($i = 0; $i < 12; $i++) {
        $totalModal[$i] = 0;
    }
    ?>
    <tr>
        <td><strong>Modal</strong></td>
        <td colspan="16"></td>
    </tr>

    <?php
    $totalModalDisetor = [];
    for ($i = 0; $i < 12; $i++) {
        $totalModalDisetor[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Modal Disetor</strong></td>
        <td colspan="12"></td>
    </tr>

    <!-- Modal Disetor -->
    <tr>
        <td></td>
        <td></td>
        <td width="1%"></td>
        <td><?= $dataModalDisetor['GeneralEntryType']['code'] ?></td>
        <td><?= $dataModalDisetor['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualModalDisetor as $index => $annualModalDisetor) {
            $totalModalDisetor[$index] += $annualModalDisetor;
            ?>
            <td class="text-right"><?= ic_rupiah($annualModalDisetor) ?></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Modal Disetor</strong></td>
        <?php
        foreach ($totalModalDisetor as $modalDisetor) {
            ?>
            <td class="text-right"><?= ic_rupiah($modalDisetor) ?></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Laba</strong></td>
        <td colspan="12"></td>
    </tr>
    <!-- Laba Rugi Ditahan -->
    <?php
    $totalLabaDitahan = [];
    for ($i = 0; $i < 12; $i++) {
        $totalLabaDitahan[$i] = 0;
    }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td width="1%"></td>
        <td><?= $dataLabaDitahan['GeneralEntryType']['code'] ?></td>
        <td><?= $dataLabaDitahan['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualLabaDitahan as $index => $ditahan) {
            $totalLabaDitahan[$index] += $ditahan;
            ?>
            <td class="text-right"><?= ic_rupiah($ditahan) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    $totalLabaRugi = [];
    for ($i = 0; $i < 12; $i++) {
        $totalLabaRugi[$i] = 0;
    }
    ?>
    <!-- Laba Rugi Berjalan -->
    <tr>
        <td></td>
        <td></td>
        <td width="1%"></td>
        <td><?= $dataLabaRugiBerjalan['GeneralEntryType']['code'] ?></td>
        <td><?= $dataLabaRugiBerjalan['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualLabaRugiBerjalan as $index => $annualLabaRugiBerjalan) {
            $totalLabaRugi[$index] += $annualLabaRugiBerjalan;
            ?>
            <td class="text-right"><?= ic_rupiah($annualLabaRugiBerjalan) ?></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <?php
    $totalLaba = [];
    for ($i = 0; $i < 12; $i++) {
        $totalLaba[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Laba</strong></td>
        <?php
        foreach ($totalLaba as $index => $labaTotal) {
            $totalLaba[$index] += $totalLabaRugi[$index] + $totalLabaDitahan[$index];
        }
        ?>
        <?php
        foreach ($totalLaba as $laba) {
            ?>
            <td class="text-right"><?= ic_rupiah($laba) ?></td>
            <?php
        }
        ?>
    </tr>

    <!-- Revaluasi Nilai Asset -->
    <?php
    $totalRevaluationAsset = [];
    for ($i = 0; $i < 12; $i++) {
        $totalRevaluationAsset[$i] = 0;
    }
    ?>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Revaluasi Aset</strong></td>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td width="1%"></td>
        <td><?= $dataRevaluasiAsset['GeneralEntryType']['code'] ?></td>
        <td><?= $dataRevaluasiAsset['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualRevaluationAsset as $index => $annualRevaluationAsset) {
            $totalRevaluationAsset[$index] += $annualRevaluationAsset;
            ?>
            <td class="text-right"><?= ic_rupiah($annualRevaluationAsset) ?></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td width="1%">
        <td colspan="16"><hr></td>
    </tr>
    <tr>
        <td width="1%"></td>
        <td colspan="4"><strong>Total Revaluasi Aset</strong></td>
        <?php
        foreach ($totalRevaluationAsset as $totalRevaluasi) {
            ?>
            <td class="text-right"><?= ic_rupiah($totalRevaluasi) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    foreach ($totalModal as $index => $modal) {
        $totalModal[$index] = $totalModalDisetor[$index] + $totalLaba[$index] + $totalRevaluationAsset[$index];
    }
    ?>
    <tr>
        <td colspan="5"><strong>Total Modal</strong></td>
        <?php
        foreach ($totalModal as $modal) {
            ?>
            <td class="text-right"><?= ic_rupiah($modal) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    for ($i = 0; $i < 12; $i++) {
        $ModalAndPassiva[$i] = $totalPassiva[$i] + $totalModal[$i];
    }
    ?>
    <tr>
        <td colspan="5" style="color: #993333;"><strong>Total Kewajiban dan Modal</strong></td>
        <?php
        foreach ($ModalAndPassiva as $totalAll) {
            ?>
            <td class="text-right" style="color: #993333;"><strong><?= ic_rupiah($totalAll) ?></strong></td>
                    <?php
                }
                ?>
    </tr>
</table>