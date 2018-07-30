<table width="100%" class="" style="border: none !important; font-size:11px; font-family:Tahoma, Geneva, sans-serif;">
    <?php
    if (empty($dataPiutangExport) && empty($dataPiutangLokal) && empty($dataModalDisetor) && empty($dataHutangDagang) &&
            empty($piutangDagang) && empty($dataPiutangSupplier) && empty($dataPersediaanBahanBaku) && empty($dataPersediaanBahanPembantu) && empty($dataLabaRugi) && empty($dataLabaDitahan)) {
        ?>
        <tr>
            <td class = "text-center" colspan = 6>Tidak Ada Data</td>
        </tr>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="6"><strong>Harta (Aktiva)</strong></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="2"><strong>Kas</strong></td>
        </tr>
        <?php
        $totalAktiva = 0;
        $totalKas = 0;
        $conds = [];
        $defaultConds = [
            "MONTH(GeneralEntry.transaction_date)" => date("m"),
            "YEAR(GeneralEntry.transaction_date)" => date("Y")
        ];
        if (!empty($this->request->query['bulan']) && !empty($this->request->query['tahun'])) {
            $defaultConds = [];
            $conds = [
                "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun']
            ];
        }
        foreach ($categoryCash as $category) {
            $temp = 0;
            $dataKas = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => $category['GeneralEntryType']['id'],
                    $conds,
                    $defaultConds
                ],
                "contain" => [
                    "InitialBalance" => [
                        "Currency"
                    ],
                ]
            ]);
            if (!empty($dataKas)) {
                ?>
                <tr>
                    <td width="2%"></td>
                    <td width="2%"></td>
                    <td width="15%"><?= $category['GeneralEntryType']['code'] ?></td>
                    <td width="30%"><?= $category['GeneralEntryType']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                    <td class="text-right">
                        <?php
                        $total = 0;
                        foreach ($dataKas as $kas) {
                            $totalDebit = 0;
                            $totalKredit = 0;
                            if (!empty($kas['GeneralEntry']['initial_balance_id'])) {
                                if ($kas['InitialBalance']['currency_id'] == 1) {
                                    $totalDebit += $kas['GeneralEntry']['debit'];
                                    $totalKredit += $kas['GeneralEntry']['credit'] * -1;
                                } else {
                                    if ($kas['GeneralEntry']['is_from_general_transaction']) {
                                        $totalDebit += $kas['GeneralEntry']['debit'] * $kas['GeneralEntry']['exchange_rate'];
                                        $totalKredit += $kas['GeneralEntry']['credit'] * $kas['GeneralEntry']['exchange_rate'] * -1;
                                    } else {
                                        $totalDebit += $kas['GeneralEntry']['debit'] * $kas['InitialBalance']['exchange_rate'];
                                        $totalKredit += $kas['GeneralEntry']['credit'] * $kas['InitialBalance']['exchange_rate'] * -1;
                                    }
                                }
                            } else {
                                $totalDebit += $kas['GeneralEntry']['debit'];
                                $totalKredit += $kas['GeneralEntry']['credit'] * -1;
                            }
                            $total += $totalDebit + $totalKredit;
                            $temp = $total;
                        }
                        echo ic_rupiah($temp);
                        $totalKas += $total;
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td width="2%"></td>
            <td colspan="3"><strong>Total Kas</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalKas) ?></td>
        </tr>

        <tr>
            <td width="2%"></td>
            <td colspan="5"><strong>Piutang</strong></td>
        </tr>
        <?php
        $totalPiutang = 0;
        foreach ($dataCOAPiutang as $coapiutang) {
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $coapiutang['GeneralEntryType']['code'] ?></td>
                <td><?= $coapiutang['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right">
                    <?php
                    $total = 0;
                    $dataPiutang = ClassRegistry::init("GeneralEntry")->find("all", [
                        "conditions" => [
                            "GeneralEntry.general_entry_type_id" => $coapiutang['GeneralEntryType']['id'],
                            "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                            "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun']
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
                    if (!empty($dataPiutang)) {
                        foreach ($dataPiutang as $piutang) {
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
                            echo ic_rupiah($total);
                            $totalPiutang += $total;
                        }
                    } else {
                        echo ic_rupiah($total);
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Piutang</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalPiutang) ?></td>
        </tr>

        <tr>
            <td width="2%"></td>
            <td colspan="5"><strong>Piutang Supplier</strong></td>
        </tr>
        <?php
        $totalPiutangSupplier = 0;
        foreach ($dataPiutangSupplier as $piutangSupplier) {
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $piutangSupplier['GeneralEntryType']['code'] ?></td>
                <td><?= $piutangSupplier['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right"><?= !empty($piutangSupplier['GeneralEntry']['debit']) ? ic_rupiah($piutangSupplier['GeneralEntry']['debit']) : ic_rupiah($piutangSupplier['GeneralEntry']['credit'] * -1) ?></td>
            </tr>
            <?php
            $totalPiutangSupplier += $piutangSupplier['GeneralEntry']['debit'];
            $totalPiutangSupplier += $piutangSupplier['GeneralEntry']['credit'] * -1;
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Piutang Supplier</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalPiutangSupplier) ?></td>
        </tr>

        <!-- Harta Tetap / Asset -->
        <tr>
            <td width="2%"></td>
            <td colspan="5"><strong>Harta Tetap Berwujud</strong></td>
        </tr>
        <?php
        $totalAssetBerwujud = 0;
        if (!empty($dataAssetBerwujud)) {
            foreach ($dataAssetBerwujud as $assetBerwujud) {
                $amount = 0;
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $assetBerwujud['GeneralEntryType']['code'] ?></td>
                    <td><?= $assetBerwujud['GeneralEntryType']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                    <td class="text-right">
                        <?php
                        $dataGeneralEntry = ClassRegistry::init("GeneralEntry")->find("all", [
                            "conditions" => [
                                "GeneralEntry.general_entry_type_id" => $assetBerwujud['GeneralEntryType']['id']
                            ],
                            "recursive" => -1
                        ]);
                        foreach ($dataGeneralEntry as $dataAsset) {
                            if (!empty($dataAsset['GeneralEntry']['debit'])) {
                                $amount += $dataAsset['GeneralEntry']['debit'];
                            } else {
                                $amount += $dataAsset['GeneralEntry']['credit'] * -1;
                            }
                        }
                        $totalAssetBerwujud += $amount;
                        echo ic_rupiah($amount);
                        ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            if (!empty($dataKenaikanNilaiAset)) {
                foreach ($dataKenaikanNilaiAset as $kenaikanAset) {
                    $amount = $kenaikanAset['GeneralEntry']['debit'];
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td><?= $kenaikanAset['GeneralEntryType']['code'] ?></td>
                        <td><?= $kenaikanAset['GeneralEntryType']['name'] ?></td>
                        <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                        <td class="text-right">
                            <?php
                            $totalAssetBerwujud += $amount;
                            echo ic_rupiah($amount);
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>

        <?php
        $depreciationAmount = 0;
        if (!empty($dataPenyusutanAsset)) {
            foreach ($dataPenyusutanAsset as $penyusutanAsset) {
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $penyusutanAsset['GeneralEntryType']['code'] ?></td>
                    <td><?= $penyusutanAsset['GeneralEntryType']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                    <td class="text-right"><?= ic_rupiah($penyusutanAsset['DepreciationAsset']['depreciation_amount'] * -1) ?></td>
                </tr>
                <?php
                $depreciationAmount += $penyusutanAsset['DepreciationAsset']['depreciation_amount'] * -1;
            }
        }
        $totalAssetBerwujud += $depreciationAmount;
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Harta Tetap Berwujud</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalAssetBerwujud) ?></td>
        </tr>

        <tr>
            <td width="2%"></td>
            <td colspan="5"><strong>Harta Tetap Tidak Berwujud</strong></td>
        </tr>
        <?php
        $totalAssetTakBerwujud = 0;
        if (!empty($dataAssetTakBerwujud)) {
            foreach ($dataAssetTakBerwujud as $assetTakBerwujud) {
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $assetTakBerwujud['GeneralEntryType']['code'] ?></td>
                    <td><?= $assetTakBerwujud['GeneralEntryType']['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                    <td class="text-right"><?= !empty($assetTakBerwujud['GeneralEntry']['debit']) ? ic_rupiah($assetTakBerwujud['GeneralEntry']['debit']) : ic_rupiah($assetTakBerwujud['GeneralEntry']['credit'] * -1) ?></td>
                </tr>
                <?php
                $totalAssetTakBerwujud += $assetTakBerwujud['GeneralEntry']['debit'];
                $totalAssetTakBerwujud += $assetTakBerwujud['GeneralEntry']['credit'] * -1;
            }
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Harta Tetap Berwujud</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalAssetTakBerwujud) ?></td>
        </tr>

        <?php
        $totalAktiva = $totalKas + $totalPiutang + $totalPiutangSupplier + $totalAssetBerwujud + $totalAssetTakBerwujud;
        ?>
        <tr>
            <td colspan="4" style="color: #993333;"><strong>Total Harta</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right" style="color: #993333;"><strong><?= ic_rupiah($totalAktiva) ?></strong></td>
        </tr>
        <?php
        $totalPassiva = 0;
        ?>
        <tr>
            <td colspan="6"><strong>Kewajiban (Passiva)</strong></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><strong>Hutang</strong></td>
        </tr>
        <?php
        $totalHutang = 0;
        $dataHutang = ClassRegistry::init("GeneralEntryType")->find("all", [
            "conditions" => [
                "OR" => [
                    "GeneralEntryType.id" => [28, 35],
                    "GeneralEntryType.parent_id" => 327
                ]
            ],
            "order" => "GeneralEntryType.code",
            "contain" => [
                "Parent",
                "Child"
            ]
        ]);
        foreach ($dataHutang as $hutang) {
            $totalHutangParent = 0;
            $totalHutangChild = 0;
            $transaction_data = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => $hutang['GeneralEntryType']['id'],
                    "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                    "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun'],
                ],
                "contain" => [
                    "InitialBalance" => [
                        "Currency"
                    ],
                    "TransactionEntry",
                    "GeneralEntryType"
                ]
            ]);
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($transaction_data as $transaction) {
                if ($transaction['GeneralEntry']['is_from_general_transaction']) {
                    if ($transaction['GeneralEntryType']['currency_id'] == 2) {
                        $totalCredit += $transaction['GeneralEntry']['credit'] * $transaction['GeneralEntry']['exchange_rate'];
                        $totalDebit += $transaction['GeneralEntry']['debit'] * $transaction['GeneralEntry']['exchange_rate'];
                    } else {
                        $totalCredit += $transaction['GeneralEntry']['credit'];
                        $totalDebit += $transaction['GeneralEntry']['debit'];
                    }
                } else {
                    $totalCredit += $transaction['GeneralEntry']['credit'];
                    $totalDebit += $transaction['GeneralEntry']['debit'];
                }
            }
            $totalHutangParent = $totalCredit - $totalDebit;
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $hutang['GeneralEntryType']['code'] ?></td>
                <td><?= $hutang['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right"> <?= ic_rupiah($totalHutangParent) ?></td>
            </tr>
            <?php
            if (!empty($hutang['Child'])) {
                foreach ($hutang['Child'] as $child) {
                    $totalDebit = 0;
                    $totalCredit = 0;
                    $transaction_data = ClassRegistry::init("GeneralEntry")->find("all", [
                        "conditions" => [
                            "GeneralEntry.general_entry_type_id" => $child['id'],
                            "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                            "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun'],
                        ],
                        "contain" => [
                            "InitialBalance",
                            "Shipment" => [
                                "Sale"
                            ],
                            "GeneralEntryType"
                        ]
                    ]);
                    foreach ($transaction_data as $transaction) {
                        if ($transaction['GeneralEntry']['is_from_general_transaction']) {
                            if ($transaction['GeneralEntryType']['currency_id'] == 2) {
                                $totalCredit += $transaction['GeneralEntry']['credit'] * $transaction['GeneralEntry']['exchange_rate'];
                                $totalDebit += $transaction['GeneralEntry']['debit'] * $transaction['GeneralEntry']['exchange_rate'];
                            } else {
                                $totalCredit += $transaction['GeneralEntry']['credit'];
                                $totalDebit += $transaction['GeneralEntry']['debit'];
                            }
                        } else {
                            $totalCredit += $transaction['GeneralEntry']['credit'];
                            $totalDebit += $transaction['GeneralEntry']['debit'];
                        }
                    }
                }
                $totalHutangChild = $totalCredit - $totalDebit;
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $child['code'] ?></td>
                    <td><?= $child['name'] ?></td>
                    <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                    <td class="text-right"> <?= ic_rupiah($totalHutangChild) ?></td>
                </tr>
                <?php
            }
            $totalHutang += $totalHutangParent + $totalHutangChild;
        }
        $totalDebit = 0;
        $totalCredit = 0;
        $totalHutangSubChild = 0;
        foreach ($dataSubChild as $subChild) {
            if ($subChild['GeneralEntryType']['currency_id'] == 1) {
                $totalDebit += $subChild['GeneralEntry']['debit'];
                $totalCredit += $subChild['GeneralEntry']['credit'];
            } else {
                $totalDebit += $subChild['GeneralEntry']['debit'] * $subChild['GeneralEntry']['exchange_rate'];
                $totalCredit += $subChild['GeneralEntry']['credit'] * $subChild['GeneralEntry']['exchange_rate'];
            }
            $totalHutangSubChild += $totalCredit - $totalDebit;
        }
        $coaSubChild = ClassRegistry::init("GeneralEntryType")->find("first", [
            "conditions" => [
                "GeneralEntryType.id" => 85
            ],
            "recursive" => -1
        ]);
        ?>
        <tr>
            <td colspan="2"></td>
            <td><?= $coaSubChild['GeneralEntryType']['code'] ?></td>
            <td><?= $coaSubChild['GeneralEntryType']['name'] ?></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"> <?= ic_rupiah($totalHutangSubChild) ?></td>
        </tr>

        <tr>
            <td></td>
            <td colspan="5"><strong>Hutang Lain-Lain</strong></td>
        </tr>

        <?php
        $dataHutangLain = ClassRegistry::init("GeneralEntryType")->find("all", [
            "conditions" => [
                "GeneralEntryType.parent_id" => 338
            ],
            "recursive" => -1,
            "order" => "GeneralEntryType.code"
        ]);
        $totalHutangLain = 0;
        foreach ($dataHutangLain as $hutangLain) {
            $dataTransactionHutangLain = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => $hutangLain['GeneralEntryType']['id'],
                    "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                    "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun'],
                ],
                "contain" => [
                    "GeneralEntryType"
                ]
            ]);
            $total = 0;
            if (!empty($dataTransactionHutangLain)) {
                foreach ($dataTransactionHutangLain as $transaksiHutangLain) {
                    if (!empty($transaksiHutangLain['GeneralEntry']['debit'])) {
                        if($transaksiHutangLain['GeneralEntryType']['currency_id'] == 1) {
                            $total += $transaksiHutangLain['GeneralEntry']['debit'] * -1; 
                        } else {
                            $total += $transaksiHutangLain['GeneralEntry']['debit'] * $transaksiHutangLain['GeneralEntry']['exchange_rate'] * -1;
                        }
                    } else {
                        if($transaksiHutangLain['GeneralEntryType']['currency_id'] == 1) {
                            $total += $transaksiHutangLain['GeneralEntry']['credit']; 
                        } else {
                            $total += $transaksiHutangLain['GeneralEntry']['credit'] * $transaksiHutangLain['GeneralEntry']['exchange_rate'];
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $hutangLain['GeneralEntryType']['code'] ?></td>
                    <td><?= $hutangLain['GeneralEntryType']['name'] ?></td>
                    <td class="text-right" style="border-right-style: none !important;" width="250">Rp</td>
                    <td class="text-right"><?= ic_rupiah($total) ?></td>
                </tr>
                <?php
                $totalHutangLain += $total;
            }
        }
        ?>

        <?php
        $totalPassiva = $totalHutang + $totalHutangSubChild + $totalHutangLain;
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>

        <tr>
            <td></td>
            <td colspan="3"><strong>Total Hutang</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalHutang) ?></td>
        </tr>
        <tr>
            <td colspan="4"><strong>Total Kewajiban</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalPassiva) ?></td>
        </tr>

        <?php
        $totalModal = 0;
        ?>
        <tr>
            <td colspan="6"><strong>Modal</strong></td>
        </tr>

        <?php
        $totalModalDisetor = 0;
        $totalModal = 0;
        foreach ($dataModalDisetor as $modal) {
            if (!empty($modal['InitialBalance']['id'])) {
                if ($modal['InitialBalance']['Currency']['id'] == 1) {
                    $totalModal = $modal['GeneralEntry']['credit'];
                } else {
                    $totalModal = $modal['GeneralEntry']['credit'] * $modal['GeneralEntryType']['exchange_rate'];
                }
            } else {
                $totalModal = $modal['GeneralEntry']['credit'];
            }
            $totalModalDisetor += $totalModal;
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $modal['GeneralEntryType']['code'] ?></td>
                <td><?= $modal['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right"><?= ic_rupiah($totalModal) ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Modal Disetor</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalModalDisetor) ?></td>
        </tr>

        <?php
        $totalLaba = 0;
        ?>
        <tr>
            <td></td>
            <td colspan="5"><strong>Laba</strong></td>
        </tr>
        <?php
        $dataLaba = ClassRegistry::init("GeneralEntryType")->find("all", [
            "conditions" => [
                "GeneralEntryType.parent_id" => 41
            ],
            "recursive" => -1
        ]);
        foreach ($dataLaba as $laba) {
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $laba['GeneralEntryType']['code'] ?></td>
                <td><?= $laba['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right">
                    <?php
                    if ($laba['GeneralEntryType']['id'] == 42) {
                        $totalLabaDitahan = 0;
                        foreach ($dataLabaDitahan as $ditahan) {
                            $totalLabaDitahan += $ditahan['RetainedEarning']['nominal'];
                        }
                        echo ic_rupiah($totalLabaDitahan);
                    } else {
                        $totalLabaRugiBerjalan = 0;
                        foreach ($dataLabaRugi as $berjalan) {
                            $totalLabaRugiBerjalan += $berjalan['ProfitAndLoss']['nominal'];
                        }
                        echo ic_rupiah($totalLabaRugiBerjalan);
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        $totalLaba = $totalLabaDitahan + $totalLabaRugiBerjalan;
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Laba</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalLaba) ?></td>
        </tr>        

        <tr>
            <td colspan="6"><strong>Revaluasi Aset</strong></td>
        </tr>            
        <?php
        $totalRevaluasiAset = 0;
        $grandTotalRevaluasiAset = 0;
        foreach ($dataRevaluasiAset as $revaluasiAset) {
            $totalRevaluasiAset = $revaluasiAset['GeneralEntry']['credit'];
            $grandTotalRevaluasiAset += $totalRevaluasiAset;
            ?>
            <tr>
                <td colspan="2"></td>
                <td><?= $revaluasiAset['GeneralEntryType']['code'] ?></td>
                <td><?= $revaluasiAset['GeneralEntryType']['name'] ?></td>
                <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
                <td class="text-right"><?= ic_rupiah($totalRevaluasiAset) ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Revaluasi Aset</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($grandTotalRevaluasiAset) ?></td>
        </tr>

        <?php
        $totalModal = $totalModalDisetor + $totalLaba + $grandTotalRevaluasiAset;
        ?>
        <tr>
            <td colspan="4"><strong>Total Modal</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalModal) ?></td>
        </tr>
        <tr>
            <td colspan="4" style="color: #993333;"><strong>Total Kewajiban dan Modal</strong></td>
            <td class="text-right" style = "border-right-style:none !important" width = "250">Rp</td>
            <td class="text-right" style="color: #993333;"><strong><?= ic_rupiah($totalPassiva + $totalModal) ?></strong></td>
        </tr>
        <?php
    }
    ?>
</table>