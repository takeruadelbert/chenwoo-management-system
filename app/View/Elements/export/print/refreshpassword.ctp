<div style="width:100%">
    <?php
    foreach ($result as $entity) {
        ?>
        <span style="float:left;display:inline-block;page-break-inside: avoid;border:1px solid black;padding:5px;">
            <table class="table-data" style="width:300px">
                <tbody>
                    <tr>
                        <td style="width:60px">Nama</td>
                        <td style="width:5px">:</td>
                        <td><?= $entity["full_name"] ?></td>
                    </tr>
                    <tr>
                        <td>Nip</td>
                        <td>:</td>
                        <td><?= $entity["nip"] ?></td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>:</td>
                        <td><?= $entity["department"] ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?= $entity["office"] ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><?= $entity["username"] ?></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><?= $entity["new_password"] ?></td>
                    </tr>
                </tbody>
            </table>
        </span>
        <?php
    }
    ?>
</div>
<style>
    .table-data tbody td:first-child{
        text-align:left !important;
        font-size:12px !important;
    }
</style>