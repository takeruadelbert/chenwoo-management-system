<center>
    <div class="container-print" style="width:955px; margin:30px auto; line-height:15px;">
        <div id="identity">
            <div class="no-margin no-padding text-left" style="width:100%">
                <?php
                $entity = ClassRegistry::init("EntityConfiguration")->find("first");
                ?>
                <div style="display:inline-block; margin-right: 15px;">
                    <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>"/>
                </div>
                <div style="display:inline-block;width: 855px;" >
                    <?php
                    echo $entity['EntityConfiguration']['header'];
                    ?>
                </div>
            </div>
        </div>
        <hr>
        <div style="color: #3366cc; font-size: 12px; font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">LAPORAN LABA RUGI</div>
        <span style="color: #993333; font-size: 12px; font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
            Periode <?php
            if (!empty($this->request->query['bulan']) && !empty($this->request->query['tahun'])) {
                echo $this->Html->getNamaBulan($this->request->query['bulan']) . " " . $this->request->query['tahun'];
            }
            ?>
    </div>
</center>
<table width="100%" class="" style="border: none !important; font-size:11px; font-family:Tahoma, Geneva, sans-serif; line-height:15px;">
    <!-- data pendapatan -->
    <tr>
        <td colspan="6"><strong>Pendapatan</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5"><strong>Penjualan</strong></td>
    </tr>
    <?php
    $totalPendapatan = 0;
    $totalPenjualan = 0;
    foreach ($dataPenjualan as $penjualan) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= $penjualan['GeneralEntryType']['code'] ?></td>
            <td><?= $penjualan['GeneralEntryType']['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right">
                <?php
                if (!empty($penjualan['GeneralEntry']['shipment_id'])) {
                    if ($penjualan['Shipment']['Sale']['Buyer']['buyer_type_id'] == 2) {
                        $total = $penjualan['GeneralEntry']['credit'] * $penjualan['Shipment']['Sale']['exchange_rate'];
                    } else {
                        $total = $penjualan['GeneralEntry']['credit'];
                    }
                    $totalPenjualan += $penjualan['GeneralEntry']['credit'] * $penjualan['Shipment']['Sale']['exchange_rate'];
                } else if (!empty($penjualan['GeneralEntry']['sale_product_additional_id'])) {
                    $total = $penjualan['GeneralEntry']['credit'];
                    $totalPenjualan += $total;
                } else if(!empty($penjualan['GeneralEntry']['material_additional_sale_id'])) {
                    $total = $penjualan['GeneralEntry']['credit'];
                    $totalPenjualan += $total;
                } else {
                    $total = $penjualan['GeneralEntry']['debit'] * -1;
                    $totalPenjualan += $total;
                }
                echo ic_rupiah($total);
                ?>
            </td>
        </tr>
        <?php
    }
    $totalPendapatan += $totalPenjualan;
    ?>
    <tr>
        <td></td>
        <td colspan="3"><strong>Total Penjualan</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalPenjualan) ?></td>
    </tr>
    <tr>
        <td colspan="4"><strong>Total Pendapatan</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalPendapatan) ?></td>
    </tr>

    <!-- Data Pembelian -->
    <tr>
        <td colspan="6"><strong>Pengeluaran</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5"><strong>Pembelian</strong></td>
    </tr>
    <?php
    $totalBiayaPembelian = 0;
    if (!empty($dataPembelianIkan)) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= @$dataPembelianIkan[0]['GeneralEntryType']['code'] ?></td>
            <td><?= @$dataPembelianIkan[0]['GeneralEntryType']['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalPembelianIkan) ?></td>
        </tr>
        <?php
    }
    if (!empty($dataPengirimanMaterialPembantu)) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= @$dataPengirimanMaterialPembantu[0]['GeneralEntryType']['code'] ?></td>
            <td><?= @$dataPengirimanMaterialPembantu[0]['GeneralEntryType']['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right"><?= ic_rupiah($totalPengirimanMaterialPembantu) ?></td>
        </tr>
        <?php
    }
    if (!empty($dataPembelianMaterialPembantu)) {
        foreach ($dataPembelianMaterialPembantu as $overhead) {
            ?>
            <tr>
                <td></td>
                <td colspan="2" class="text-center"><?= @$overhead['GeneralEntryType']['code'] ?></td>
                <td><?= @$overhead['GeneralEntryType']['name'] ?></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
                <td class="text-right"><?= ic_rupiah($overhead['GeneralEntry']['debit']) ?></td>
            </tr>
            <?php
        }
    }
    $totalBiayaPembelian = $totalPembelianIkan + $totalPembelianMaterialPembantu + $totalPengirimanMaterialPembantu;
    ?>
    <tr>
        <td></td>
        <td colspan="3"><strong>Total Pembelian</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalBiayaPembelian) ?></td>
    </tr>

    <!-- Biaya Produksi -->
    <tr>
        <td></td>
        <td colspan="5"><strong>Biaya Produksi</strong></td>
    </tr>
    <?php
    $totalGajiHarian = 0;
    foreach ($dataGajiHarian as $gajiHarian) {
        $totalGajiHarian += $gajiHarian['GeneralEntry']['debit'];
    }
    ?>
    <tr>
        <td></td>
        <td colspan="2" class="text-center"><?= $accountNameGajiHarian['GeneralEntryType']['code'] ?></td>
        <td><?= $accountNameGajiHarian['GeneralEntryType']['name'] ?></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalGajiHarian) ?></td>
    </tr>
    <?php
    $totalBiayaProduksi = $totalGajiHarian;
    ?>
    <tr>
        <td></td>
        <td colspan="3"><strong>Total Biaya Produksi</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalBiayaProduksi) ?></td>
    </tr>

    <!-- Laba/Rugi Kotor -->
    <tr style="border-top:1px solid #000; border-bottom: 1px solid #000;">
        <td style="color: #993333;" colspan="4"><strong>Laba/Rugi Kotor</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td style="color: #993333;" class="text-right">
            <strong>
                <?php
                $totalLabaRugiKotor = $totalPendapatan - ($totalBiayaPembelian + $totalBiayaProduksi);
                echo ic_rupiah($totalLabaRugiKotor);
                ?>
            </strong>
        </td>
    </tr>

    <!-- Biaya Administrasi & Umum -->
    <tr>
        <td colspan="6"><strong>Biaya Administrasi & Umum</strong></td>
    </tr>
    <?php
    $totalBiayaAdminUmum = 0;
    $totalGajiBulanan = 0;
    foreach ($dataGajiBulanan as $gajiBulanan) {
        $totalGajiBulanan += $gajiBulanan['GeneralEntry']['debit'];
    }
    ?>
    <tr>
        <td></td>
        <td colspan="2" class="text-center"><?= $accountNameGajiBulanan['GeneralEntryType']['code'] ?></td>
        <td><?= $accountNameGajiBulanan['GeneralEntryType']['name'] ?></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalGajiBulanan) ?></td>
    </tr>
    <?php
    $totalAdminUmum = 0;
    $dataCoaAdminUmum = ClassRegistry::init("GeneralEntryType")->find("all", [
        "conditions" => [
            "GeneralEntryType.parent_id" => 92
        ],
        "recursive" => -1
    ]);
    foreach ($dataCoaAdminUmum as $coaAdminUmum) {
        $dataAdminUmum = ClassRegistry::init("GeneralEntry")->find("all", [
            "conditions" => [
                "GeneralEntry.general_entry_type_id" => $coaAdminUmum['GeneralEntryType']['id'],
                "MONTH(GeneralEntry.transaction_date)" => $this->request->query['bulan'],
                "GeneralEntryType.id !=" => 30
            ],
            "order" => "GeneralEntry.transaction_date",
            "contain" => [
                "GeneralEntryType"
            ]
        ]);
        if (!empty($dataAdminUmum)) {
            foreach ($dataAdminUmum as $adminUmum) {
                $totalAdminUmum += $adminUmum['GeneralEntry']['debit'];
            }
            ?>
            <tr>
                <td></td>
                <td colspan="2" class="text-center"><?= $adminUmum['GeneralEntryType']['code'] ?></td>
                <td><?= $adminUmum['GeneralEntryType']['name'] ?></td>
                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
                <td class="text-right"><?= ic_rupiah($totalAdminUmum) ?></td>
            </tr>
            <?php
        }
    }
    $totalBiayaAdminUmum = $totalGajiBulanan + $totalAdminUmum;
    ?>
    <tr>
        <td colspan="5"><strong>Total Biaya Administrasi & Umum</strong></td>
        <td class="text-right"><?= ic_rupiah($totalBiayaAdminUmum) ?></td>
    </tr>

    <!-- Biaya Pemasaran -->
    <tr>
        <td colspan="6"><strong>Biaya Pemasaran</strong></td>
    </tr>
    <?php
    $totalBiayaPemasaran = 0;
    foreach ($dataPemasaran as $pemasaran) {
        if(!empty($pemasaran['Shipment']['id'])) {
            if ($pemasaran['Shipment']['Sale']['Buyer']['buyer_type_id'] == 1) {
                $biayaPemasaran = $pemasaran['GeneralEntry']['debit'];
            } else {
                $biayaPemasaran = $pemasaran['GeneralEntry']['debit'] * $pemasaran['Shipment']["Sale"]['exchange_rate'];
            }
        } else {
            $biayaPemasaran = $pemasaran['GeneralEntry']['debit'];
        }
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= $pemasaran['GeneralEntryType']['code'] ?></td>
            <td><?= $pemasaran['GeneralEntryType']['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right"><?= ic_rupiah($biayaPemasaran) ?></td>
        </tr>
        <?php
        $totalBiayaPemasaran += $biayaPemasaran;
    }
    ?>
    <tr>
        <td colspan="4"><strong>Total Biaya Pemasaran</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalBiayaPemasaran) ?></td>
    </tr>

    <!-- Laba/Rugi Operasi -->
    <tr style="border-top:1px solid #000; border-bottom: 1px solid #000;">
        <td style="color: #993333;" colspan="4"><strong>Laba/Rugi Operasi</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td style="color: #993333;" class="text-right">
            <strong>
                <?php
                $totalLabaRugiOperasi = $totalLabaRugiKotor - $totalBiayaAdminUmum - $totalBiayaPemasaran;
                echo ic_rupiah($totalLabaRugiOperasi);
                ?>
            </strong>
        </td>
    </tr>

    <!-- Pendapatan Non Operasional -->
    <tr>
        <td colspan="6"><strong>Pendapatan Non Operasional</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5"><strong>Pendapatan Luar Usaha</strong></td>
    </tr>
    <?php
    $totalPendapatanNonOperasional = 0;
    $totalPendapatanLuarUsaha = 0;
    foreach ($dataPendapatanNonOperasional as $nonOperasional) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= $nonOperasional['GeneralEntryType']['code'] ?></td>
            <td><?= $nonOperasional["GeneralEntryType"]['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right"><?= ic_rupiah($nonOperasional["GeneralEntry"]['credit']) ?></td>
        </tr>
        <?php
        $totalPendapatanLuarUsaha += $nonOperasional["GeneralEntry"]['credit'];
    }
    ?>
    <tr>
        <td></td>
        <td colspan="3"><strong>Total Pendapatan Luar Usaha</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalPendapatanLuarUsaha) ?></td>
    </tr>
    <?php
    $totalPendapatanNonOperasional += $totalPendapatanLuarUsaha;
    ?>
    <tr>
        <td colspan="4"><strong>Total Pendapatan Non Operasional</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalPendapatanNonOperasional) ?></td>
    </tr>

    <!-- Biaya Non Operasional -->
    <tr>
        <td colspan="6"><strong>Biaya Non Operasional</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5"><strong>Pengeluaran Luar Usaha</strong></td>
    </tr>
    <?php
    $totalPengeluaranLuarUsaha = 0;
    $totalBiayaNonOperasional = 0;
    foreach ($dataPengeluaranLuarUsaha as $luarUsaha) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= $luarUsaha['GeneralEntryType']['code'] ?></td>
            <td><?= $luarUsaha["GeneralEntryType"]['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <td class="text-right">
                <?php
                if ($luarUsaha['InitialBalance']['currency_id'] == 1) {
                    echo ic_rupiah($luarUsaha['GeneralEntry']['debit']);
                } else {
                    echo ic_rupiah($luarUsaha['GeneralEntry']['debit'] * $luarUsaha['CashDisbursement']['exchange_rate']);
                }
                ?>
            </td>
        </tr>
        <?php
        if ($luarUsaha['InitialBalance']['currency_id'] == 1) {
            $totalPengeluaranLuarUsaha += $luarUsaha['GeneralEntry']['debit'];
        } else {
            $totalPengeluaranLuarUsaha += $luarUsaha['GeneralEntry']['debit'] * $luarUsaha['CashDisbursement']['exchange_rate'];
        }
    }
    if (!empty($dataBiayaPenyusutan)) {
        ?>
        <tr>
            <td></td>
            <td colspan="2" class="text-center"><?= $dataBiayaPenyusutan[0]['GeneralEntryType']['code'] ?></td>
            <td><?= $dataBiayaPenyusutan[0]['GeneralEntryType']['name'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
            <?php
            $totalBiayaPenyusutan = 0;
            foreach ($dataBiayaPenyusutan as $biayaPenyusutan) {
                $totalBiayaPenyusutan += $biayaPenyusutan['GeneralEntry']['debit'];
            }
            ?>
            <td class="text-right"><?= ic_rupiah($totalBiayaPenyusutan) ?></td>
        </tr>
        <?php
        $totalPengeluaranLuarUsaha += $totalBiayaPenyusutan;
    }
    ?>
    <tr>
        <td></td>
        <td colspan="3"><strong>Total Pengeluaran Luar Usaha</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td class="text-right"><?= ic_rupiah($totalPengeluaranLuarUsaha) ?></td>
    </tr>
    <?php
    $totalBiayaNonOperasional = $totalPengeluaranLuarUsaha;
    ?>
    <tr>
        <td colspan="5"><strong>Total Biaya Non Operasional</strong></td>
        <td class="text-right"><?= ic_rupiah($totalBiayaNonOperasional) ?></td>
    </tr>

    <!-- Laba/Rugi Bersih -->
    <tr style="border-top:1px solid #000; border-bottom: 1px solid #000;">
        <td style="color: #993333;" colspan="4"><strong>Laba/Rugi Bersih</strong></td>
        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp</td>
        <td style="color: #993333;" class="text-right">
            <strong>
                <?php
                $totalLabaRugiBersih = $totalLabaRugiOperasi + $totalPendapatanLuarUsaha - $totalBiayaNonOperasional;
                echo ic_rupiah($totalLabaRugiBersih);
                ?>
            </strong>
        </td>
    </tr>
</table>
<script>
    $(document).ready(function () {
        var amount = <?= $totalLabaRugiBersih ?>;
        var month = <?= $this->request->query['bulan'] ?>;
        var year = <?= $this->request->query['tahun'] ?>;
        $.ajax({
            url: "<?= Router::url("save_data_laba_rugi/$totalLabaRugiBersih/{$this->request->query['bulan']}/{$this->request->query['tahun']}", true) ?>",
            type: "GET",
            dataType: "JSON",
            data: {},
            success: function (response) {
//                console.log(response);
            }
        });
    });
</script>