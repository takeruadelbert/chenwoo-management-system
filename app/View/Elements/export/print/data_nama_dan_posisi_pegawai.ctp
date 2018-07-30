<!--<table width = "100%">
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Nomor Induk Karyawan</th>
        <th>Posisi</th>
        <th>Mulai Bekerja</th>
    </tr>
    <?php
    $count = 0;
    foreach ($data['rows'][0]['Department'] as $departments) {
        ?>
        <tr>
            <td colspan="3"> DEPARTEMEN: <?= $departments['name'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>-->