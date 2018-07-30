<table width="100%" class="" style="border: none !important; font-size:11px; font-family:Tahoma, Geneva, sans-serif;">
    <thead>
        <tr style="border-bottom: 1px solid">
            <th>Kode Akun</th>
            <th>Nama Akun</th>
            <th colspan="2">Debet</th>
            <th colspan="2">Kredit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalAllDebet = 0;
        $totalAllKredit = 0;
        $conds = [];
        $defaultConds = [
            "MONTH(GeneralEntry.transaction_date)" => date("m"),
            "YEAR(GeneralEntry.transaction_date)" => date("Y")
        ];
        if(!empty($this->request->query['bulan']) && !empty($this->request->query['tahun'])) {
            $defaultConds = [];
            $conds = [
                "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                "YEAR(GeneralEntry.transaction_date)" => $this->request->query['tahun']
            ];
        }
        foreach ($dataGeneralEntryType as $generalEntryType) {
            $totalDebet = 0;
            $totalKredit = 0;
            $dataGeneralEntry = ClassRegistry::init("GeneralEntry")->find("all", [
                "conditions" => [
                    "GeneralEntry.general_entry_type_id" => $generalEntryType['GeneralEntryType']['id'],
                    $conds,
                    $defaultConds
                ],
                "contain" => [
                    "InitialBalance" => [
                        "Currency"
                    ],
                    "PaymentSale" => [
                        "Sale"
                    ],
                    "Sale",
                    "Shipment" => [
                        "Sale" => [
                            "Buyer"
                        ]
                    ]
                ]
            ]);
            if (!empty($dataGeneralEntry[0]['GeneralEntry']['debit']) || !empty($dataGeneralEntry[0]['GeneralEntry']['credit'])) {
                foreach ($dataGeneralEntry as $item) {
                    if(!empty($item["GeneralEntry"]['initial_balance_id'])) {
                        if ($item['InitialBalance']['Currency']['id'] == 1) {
                            $totalDebet += $item['GeneralEntry']['debit'];
                            $totalKredit += $item['GeneralEntry']['credit'];
                        } else {
                            if (!empty($item['GeneralEntry']['payment_sale_d']) && empty($item['GeneralEntry']['sale_id'])) {
                                $totalDebet += $item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                $totalKredit += $item['GeneralEntry']['credit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                            } else if (empty($item['GeneralEntry']['payment_sale_d']) && !empty($item['GeneralEntry']['sale_id'])) {
                                $totalDebet += $item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate'];
                                $totalKredit += $item['GeneralEntry']['credit'] * $item['Sale']['exchange_rate'];
                            } else if($item['GeneralEntry']['is_from_general_transaction']) {
                                $totalDebet += $item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate'];
                                $totalKredit += $item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate'];
                            } else {
                                $totalDebet += $item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate'];
                                $totalKredit += $item['GeneralEntry']['credit'] * $item['InitialBalance']['exchange_rate'];
                            }
                        }
                    } else {
                        if(!empty($item['GeneralEntry']['shipment_id'])) {
                            if($item['Shipment']["Sale"]['Buyer']['buyer_type_id'] == 2) {
                                $totalDebet += $item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                $totalKredit += $item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate'];
                            } else {
                                $totalDebet += $item['GeneralEntry']['debit'];
                                $totalKredit += $item['GeneralEntry']['credit'];
                            }
                        } else {
                            $totalDebet += $item['GeneralEntry']['debit'];
                            $totalKredit += $item['GeneralEntry']['credit'];
                        }
                    }
                }
                ?>
                <tr>
                    <td class="text-center"><?= $generalEntryType['GeneralEntryType']['code'] ?></td>
                    <td class="text-center"><?= $generalEntryType['GeneralEntryType']['name'] ?></td>
                    <td class="" style = "border-right-style:none !important" width = "50">Rp </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($totalDebet) ?></td>
                    <td class="" style = "border-right-style:none !important" width = "50">Rp </td>
                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($totalKredit) ?></td>
                </tr>
                <?php
                $totalAllDebet += $totalDebet;
                $totalAllKredit += $totalKredit;
            }
        }
        ?>
        <tr>
            <td colspan="2" class="text-center"><strong>Total</strong></td>
            <td class="" style = "border-right-style:none !important" width = "50">Rp </td>
            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($totalAllDebet) ?></strong></td>
            <td class="" style = "border-right-style:none !important" width = "50">Rp </td>
            <td class="text-right" style = "border-left-style:none !important" width = "150"><strong><?= ic_rupiah($totalAllKredit) ?></strong></td>
        </tr>
    </tbody>
</table>