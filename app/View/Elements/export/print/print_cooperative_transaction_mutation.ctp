<?php
if (!empty($data['rows'])) {
    ?>
    <table>
        <tr>
            <td colspan="2">
                <table>
                    <tr><td>Nomor Mutasi</td><td>: <?= $data['rows']['CooperativeTransactionMutation']['id_number'] ?></td></tr>
                    <tr><td>Jenis Transaksi</td><td>: <?= $data['rows']['CooperativeTransactionType']['name'] ?></td></tr>
                    <tr><td>Pegawai Pelaksana</td><td>: <?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td></tr>
                    <tr><td>NIK Pelaksana</td><td>: <?= $data['rows']['Employee']['nip'] ?></td></tr>
                    <tr><td>Jumlah Transaksi</td><td>: <?= $this->Html->IDR($data['rows']['CooperativeTransactionMutation']['nominal']) ?></td></tr>
                    <tr><td>Terbilang</td><td>: <strong><?= angka2kalimat($data['rows']['CooperativeTransactionMutation']['nominal']) ?> rupiah.</strong></td></tr>
                </table>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">
                <div style="border:1px solid black"></div>
            </td>
        </tr>
    </table>
<?php } ?>