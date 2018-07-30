<?php echo $this->Form->create("AttendanceEmployeeUid", array("class" => "form-horizontal form-separate", "action" => "simple_view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("UID Absensi Pegawai") ?>
                        <div class="pull-right">
                            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                            <input type="reset" value="Reset" class="btn btn-info">
                            <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
                        </div>
                        <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                    </h6>
                </div>
                <div class="table-responsive stn-table">
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
                                        <div class="false">
                                            <?= $this->Form->input("Dummy.$i.name", [ "value" => $employee["Account"]["Biodata"]["full_name"], "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
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
                                                    <?= $this->Form->input("AttendanceEmployeeUid.$i.uid", ["value" => $listUid[$attendanceMachine["AttendanceMachine"]["id"]]["uid"], "div" => false, "class" => "form-control", "label" => false]) ?>
                                                    <?= $this->Form->hidden("AttendanceEmployeeUid.$i.id", ["value" => $listUid[$attendanceMachine["AttendanceMachine"]["id"]]["id"]]) ?>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <?= $this->Form->input("AttendanceEmployeeUid.$i.uid", ["div" => false, "class" => "form-control", "label" => false]) ?>
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
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>