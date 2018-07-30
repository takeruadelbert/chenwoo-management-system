<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data UID Absensi Pegawai
    </div>
</div>
<br>
<table width="100%" class="table table-bordered table-hover">
    <thead>
        <tr bordercolor="#000000">
            <th rowspan="2" width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
            <th rowspan="2" width="350" align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
            <th colspan="<?= count($attendanceMachines) ?>" align="center" valign="middle" bgcolor="#feffc2">Mesin</th>
        </tr>
        <tr>
            <?php
            foreach ($dataAttendanceMachine as $attendanceMachine) {
                ?>
                <th><?= $attendanceMachine["AttendanceMachine"]["name"] ?></th>
                <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($dataEmployee as $k => $employee) {
            $listUid = [];
            foreach ($employee["AttendanceEmployeeUid"] as $attendanceEmployeeUid) {
                $listUid[$attendanceEmployeeUid["attendance_machine_id"]] = [
                    "id" => $attendanceEmployeeUid["id"],
                    "uid" => $attendanceEmployeeUid["uid"]
                ];
            }
            ?>
            <tr>
                <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                <td>
                    <div class="false text-left">
                        <?= $employee["Account"]["Biodata"]["full_name"] ?>
                    </div>
                </td>
                <?php
                foreach ($dataAttendanceMachine as $attendanceMachine) {
                    ?>
                    <td>
                        <div class="false">
                            <?= $this->Form->hidden("AttendanceEmployeeUid.$i.attendance_machine_id", ["value" => $attendanceMachine["AttendanceMachine"]["id"]]) ?>
                            <?= $this->Form->hidden("AttendanceEmployeeUid.$i.employee_id", ["value" => $employee["Employee"]["id"]]) ?>
                            <?php
                            if (isset($listUid[$attendanceMachine["AttendanceMachine"]["id"]])) {
                                ?>
                                <?= $listUid[$attendanceMachine["AttendanceMachine"]["id"]]["uid"] ?>
                                <?= $this->Form->hidden("AttendanceEmployeeUid.$i.id", ["value" => $listUid[$attendanceMachine["AttendanceMachine"]["id"]]["id"]]) ?>
                                <?php
                            } else {
                                ?>
                                
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                    <?php
                    $i++;
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </tbody>  
</table>