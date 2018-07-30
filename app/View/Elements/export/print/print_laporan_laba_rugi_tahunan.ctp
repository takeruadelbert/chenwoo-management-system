<center>
    <div class="container-print" style="width:955px; margin:10px auto;">
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
        <h2 style="color: #3366cc;">LABA RUGI</h2>
        <p style="color: #993333; font-size: 20px; font-weight: bold;">
            <?php
            if (!empty($this->request->query['year'])) {
                echo $this->request->query['year'];
            }
            ?>
        </p>
    </div>
</center>
<table width="100%" class="" style="border: none !important; font-size:14px;">
    <tr bgcolor="#d1d1e0">
        <th colspan="5" class="text-left">Nama Rekening</th>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            ?>
            <th width="7%" class="text-center"><?= $this->Echo->singkatanBulan($i) ?></th>
            <?php
        }
        ?>
    </tr>

    <!-- Pendapatan -->
    <tr>
        <td></td>
        <td colspan="16"><strong>Pendapatan</strong></td>
    </tr>
    <tr>
        <td></td>
        <td width="1%"></td>
        <td colspan="15"><strong>Penjualan</strong></td>
    </tr>
    <?php
    $index = 0;
    foreach ($dataPenjualan as $penjualan) {
        ?>
        <tr>
            <td></td>
            <td width="1%"></td>
            <td width="1%"></td>
            <td width="6%"><?= $penjualan['GeneralEntryType']['code'] ?></td>
            <td><?= $penjualan['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataRincianPenjualan as $rincianPenjualan) {
                ?>
                <td class="text-right">
                    <?php
                    if (!empty($rincianPenjualan[$index])) {
                        if (!empty($penjualan['GeneralEntry']['shipment_id'])) {
                            if ($penjualan['Shipment']["Sale"]['Buyer']['buyer_type_id'] == 2) {
                                $total = $rincianPenjualan[$index]['GeneralEntry']['credit'] * $rincianPenjualan[$index]['Shipment']['Sale']['exchange_rate'];
                            } else {
                                $total = $rincianPenjualan[$index]['GeneralEntry']['credit'];
                            }
                        } else if (!empty($penjualan['GeneralEntry']['sale_product_additional_id'])) {
                            $total = $rincianPenjualan[$index]['GeneralEntry']['credit'];
                        } else if (!empty($penjualan['GeneralEntry']['material_additional_sale_id'])) {
                            $total = $rincianPenjualan[$index]['GeneralEntry']['credit'];
                        }
                        echo ic_rupiah($total);
                    } else {
                        echo ic_rupiah(0);
                    }
                    ?>                        
                </td>
                <?php
            }
            $index++;
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Total Pendapatan</strong></td>
        <?php
        foreach ($dataAnnualPenjualan as $annualPenjualan) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($annualPenjualan[0]['Nominal']) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Pembelian -->
    <tr>
        <td colspan="17"><strong>Pengeluaran</strong></td>
    </tr>
    <!-- Pembelian Ikan -->
    <tr>
        <td></td>
        <td width="1%"></td>
        <td colspan="15"><strong>Pembelian</strong></td>
    </tr>
    <tr>
        <td></td>
        <td width="1%"></td>
        <td width="1%"></td>
        <td><?= $dataPembelianIkan['GeneralEntryType']['code'] ?></td>
        <td><?= $dataPembelianIkan['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualPembelianIkan as $annualPembelianIkan) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualPembelianIkan[0]['Nominal']) ?></td>
            <?php
        }
        ?>
    </tr>

    <!-- Pembelian Material Pembantu -->
    <tr>
        <td></td>
        <td width="1%"></td>
        <td width="1%"></td>
        <td><?= $dataPembelianMaterialPembantu['GeneralEntryType']['code'] ?></td>
        <td><?= $dataPembelianMaterialPembantu['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataRincianPembelianMaterialPembantu as $rincianMaterialPembantu) {
            ?>
            <td class="text-right"><?= !empty($rincianMaterialPembantu) ? ic_rupiah($rincianMaterialPembantu[0]['GeneralEntry']['debit']) : ic_rupiah(0) ?></td>
            <?php
        }
        ?>
    </tr>

    <!-- Biaya Overhead -->
    <?php
//    debug($dataRincianBiayaOverhead);
//    die;
    foreach ($dataBiayaOverhead as $index => $overhead) {
        ?>
        <tr>
            <td></td>
            <td width="1%"></td>
            <td width="1%"></td>
            <td><?= $overhead['GeneralEntryType']['code'] ?></td>
            <td><?= $overhead["GeneralEntryType"]['name'] ?></td>
            <?php
            foreach ($dataRincianBiayaOverhead as $rincianBiayaOverhead) {
                ?>
                <td class="text-right"><?= !empty($rincianBiayaOverhead[$index]) ? ic_rupiah($rincianBiayaOverhead[$index]['GeneralEntry']['debit']) : ic_rupiah(0) ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>

    <?php
    $totalPembelian = [];
    for ($i = 0; $i < 12; $i++) {
        $totalPembelian[$i] = $dataAnnualPembelianIkan[$i][0]['Nominal'] + $dataAnnualPembelianMaterialPembantu[$i][0]['Nominal'] + $dataAnnualBiayaOverhead[$i][0]['Nominal'];
    }
    ?>
    <tr>
        <td colspan="2"></td>
        <td colspan="3"><strong>Total Pembelian</strong></td>
        <?php
        foreach ($totalPembelian as $pembelianTotal) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($pembelianTotal) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Biaya Produksi -->
    <tr>
        <td></td>
        <td width="1%"></td>
        <td colspan="15"><strong>Biaya Produksi</strong></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td><?= $dataGajiHarian['GeneralEntryType']['code'] ?></td>
        <td><?= $dataGajiHarian['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualGajiHarian as $annualGajiHarian) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualGajiHarian[0]['Nominal']) ?></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="3"><strong>Total Biaya Produksi</strong></td>
        <?php
        $totalBiayaProduksi = [];
        for ($i = 0; $i < 12; $i++) {
            $totalBiayaProduksi[$i] = $dataAnnualGajiHarian[$i][0]['Nominal'];
        }
        foreach ($totalBiayaProduksi as $totalProduksi) {
            ?>
            <td class="text-right">
                <strong><?= ic_rupiah($totalProduksi) ?></strong>
            </td>
            <?php
        }
        ?>
    </tr>    

    <!-- Laba/Rugi Kotor -->
    <tr bgcolor="#d1d1e0">
        <td colspan="5"><strong>Laba/Rugi Kotor</strong></td>
        <?php
        foreach ($labaRugiKotor as $kotor) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($kotor) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Biaya Administrasi & Umum -->
    <tr>
        <td colspan="17"><strong>Biaya Administrasi & Umum</strong></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td><?= $dataGajiBulanan['GeneralEntryType']['code'] ?></td>
        <td><?= $dataGajiBulanan['GeneralEntryType']['name'] ?></td>
        <?php
        foreach ($dataAnnualGajiBulanan as $annualGajiBulanan) {
            ?>
            <td class="text-right"><?= ic_rupiah($annualGajiBulanan[0]['Nominal']) ?></td>
            <?php
        }
        ?>
    </tr>

    <?php
    foreach ($dataAdminUmum as $coaAdminUmum) {
        ?>
        <tr>
            <td colspan="3"></td>
            <td><?= $coaAdminUmum['GeneralEntryType']['code'] ?></td>
            <td><?= $coaAdminUmum['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataRincianAdminUmum as $rincianAdminUmum) {
                $total_rincian = 0;
                if (!empty($rincianAdminUmum)) {
                    foreach ($rincianAdminUmum as $rincian) {
                        if ($rincian['GeneralEntryType']['id'] == $coaAdminUmum['GeneralEntryType']['id']) {
                            $total_rincian += $rincian['GeneralEntry']['debit'];
                        }
                    }
                }
                ?>
                <td class="text-right"><?= ic_rupiah($total_rincian) ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Total Biaya Administrasi & Umum</strong></td>
        <?php
        $totalBiayaAdminUmum = [];
        for ($i = 0; $i < 12; $i++) {
            $totalBiayaAdminUmum[$i] = $dataAnnualGajiBulanan[$i][0]['Nominal'] + $dataAnnualAdminUmum[$i][0]['Nominal'];
        }
        foreach ($totalBiayaAdminUmum as $totalAdminUmum) {
            ?>
            <td class="text-right">
                <strong><?= ic_rupiah($totalAdminUmum) ?></strong>
            </td>
            <?php
        }
        ?>
    </tr>

    <!-- Biaya Pemasaran -->
    <tr>
        <td colspan="17"><strong>Biaya Pemasaran</strong></td>
    </tr>
    <?php
    $index = 0;
    foreach ($dataPemasaran as $pemasaran) {
        ?>
        <tr>
            <td colspan="3"></td>
            <td><?= $pemasaran['GeneralEntryType']['code'] ?></td>
            <td><?= $pemasaran['GeneralEntryType']['name'] ?></td>
            <?php
            if(!empty($dataRincianPemasaran)) {
                $index = 0;
                foreach ($dataRincianPemasaran as $rincianPemasaran) {
                    ?>
                    <td class="text-right">
                        <?php
                        if (!empty($rincianPemasaran)) {
                            if (!empty($rincianPemasaran[$index]['Shipment']['id'])) {
                                if ($rincianPemasaran[$index]['Shipment']['Sale']['Buyer']['buyer_type_id'] == 1) {
                                    echo ic_rupiah($rincianPemasaran[$index]['GeneralEntry']['debit']);
                                } else {
                                    echo ic_rupiah($rincianPemasaran[$index]['GeneralEntry']['debit'] * $rincianPemasaran[$index]['Shipment']['Sale']['exchange_rate']);
                                }
                            } else {
                                echo ic_rupiah($rincianPemasaran[$index]['GeneralEntry']['debit']);
                            }
                        } else {
                            echo ic_rupiah(0);
                        }
                        ?>
                    </td>
                    <?php
                }
            } else {
                echo ic_rupiah(0);
            }
            $index++;
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Total Biaya Pemasaran</strong></td>
        <?php
        foreach ($dataAnnualPemasaran as $annualPemasaran) {
            ?>
            <td class="text-right">
                <strong><?= ic_rupiah($annualPemasaran[0]['Nominal']) ?></strong>
            </td>
            <?php
        }
        ?>
    </tr>

    <!-- Laba/Rugi Operasi -->
    <tr bgcolor="#d1d1e0">
        <td colspan="5"><strong>Laba/Rugi Operasi</strong></td>
        <?php
        foreach ($labaRugiOperasi as $operasi) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($operasi) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Pendapatan Non Operasional -->
    <tr>
        <td></td>
        <td colspan="16"><strong>Pendapatan Non Operasional</strong></td>
    </tr>
    <tr>
        <td></td>
        <td width="1%"></td>
        <td colspan="15"><strong>Pendapatan Luar Usaha</strong></td>
    </tr>
    <?php
    $index = 0;
    foreach ($dataPendapatanLuarUsaha as $pendapatanLuarUsaha) {
        ?>
        <tr>
            <td></td>
            <td width="1%"></td>
            <td width="1%"></td>
            <td width="6%"><?= $pendapatanLuarUsaha['GeneralEntryType']['code'] ?></td>
            <td><?= $pendapatanLuarUsaha['GeneralEntryType']['name'] ?></td>
            <?php
            $index = 0;
            foreach ($dataRincianPendapatanLuarUsaha as $rincianPendapatanLuarUsaha) {
                ?>
                <td class="text-right"><?= !empty($rincianPendapatanLuarUsaha) ? ic_rupiah($rincianPendapatanLuarUsaha[$index]['GeneralEntry']['credit']) : ic_rupiah(0) ?></td>
                <?php
            }
            $index++;
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Total Pendapatan Luar Usaha</strong></td>
        <?php
        foreach ($dataAnnualPendapatanLuarUsaha as $annualPendapatanLuarUsaha) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($annualPendapatanLuarUsaha[0]['Nominal']) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Biaya Non Operasional -->
    <tr>
        <td></td>
        <td colspan="16"><strong>Biaya Non Operasional</strong></td>
    </tr>
    <tr>
        <td></td>
        <td width="1%"></td>
        <td colspan="15"><strong>Pengeluaran Luar Usaha</strong></td>
    </tr>
    <?php
    foreach ($dataPengeluaranLuarUsaha as $pengeluaranLuarUsaha) {
        ?>
        <tr>
            <td colspan="3"></td>
            <td><?= $pengeluaranLuarUsaha['GeneralEntryType']['code'] ?></td>
            <td><?= $pengeluaranLuarUsaha['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataRincianPengeluaranLuarUsaha as $rincianPengeluaranLuarUsaha) {
                $total = 0;
                if (!empty($rincianPengeluaranLuarUsaha)) {
                    foreach ($rincianPengeluaranLuarUsaha as $rincian) {
                        if ($rincian['GeneralEntryType']['id'] == $pengeluaranLuarUsaha['GeneralEntryType']['id']) {
                            $total += $rincian['GeneralEntry']['debit'];
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
    if (!empty($dataBiayaPenyusutan)) {
        ?>
        <tr>
            <td></td>
            <td width="1%"></td>
            <td width="1%"></td>
            <td width="6%"><?= $dataBiayaPenyusutan[0]['GeneralEntryType']['code'] ?></td>
            <td><?= $dataBiayaPenyusutan[0]['GeneralEntryType']['name'] ?></td>
            <?php
            foreach ($dataRincianBiayaPenyusutan as $rincianBiayaPenyusutan) {
                ?>
                <td class="text-right"><?= ic_rupiah($rincianBiayaPenyusutan) ?></td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="5"></td>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="5"><strong>Total Pengeluaran Luar Usaha</strong></td>
        <?php
        foreach ($dataAnnualPengeluaranLuarUsaha as $index => $annualPengeluaranLuarUsaha) {
            $total_pengeluaran_luar_usaha = $annualPengeluaranLuarUsaha[0]['Nominal'] + $dataRincianBiayaPenyusutan[$index];
            ?>
            <td class="text-right"><strong><?= ic_rupiah($total_pengeluaran_luar_usaha) ?></strong></td>
            <?php
        }
        ?>
    </tr>

    <!-- Laba/Rugi Bersih -->
    <tr bgcolor="#d1d1e0">
        <td colspan="5"><strong>Laba/Rugi Bersih</strong></td>
        <?php
        foreach ($labaRugiBersih as $bersih) {
            ?>
            <td class="text-right"><strong><?= ic_rupiah($bersih) ?></strong></td>
                    <?php
                }
                ?>
    </tr>
</table>