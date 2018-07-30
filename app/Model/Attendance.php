<?php

class Attendance extends AppModel {

    var $name = 'Attendance';
    var $belongsTo = array(
        "AttendanceType",
        "Employee",
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
        "d" => "date(dt)",
        "t" => "time(dt)",
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    //$employeeIds if false, select all
    function buildReport($start_date, $end_date, $employeeIds = false, $include_unactive_employee = false, $ignorePassDate = false) {
        $attendanceTypes = ClassRegistry::init("AttendanceType")->find("list", ["fields" => ["AttendanceType.name", "AttendanceType.id"]]);
        $employeeCond = [];
        $attendanceCond = [];
        if ($employeeIds !== false) {
            $employeeCond = [
                "Employee.id" => $employeeIds,
            ];
            $attendanceCond = [
                "Attendance.employee_id" => $employeeIds,
            ];
        }
        if(!$include_unactive_employee) {
            $employeeCond["not"] = [
                "Account.id" => ClassRegistry::init("Employee")->excludedEmployee(),
            ];
        }
        $employees = ClassRegistry::init("Employee")->find("all", [
            "contain" => [
                "WorkingHourType" => [
                    "WorkingHourTypeDetail" => [
                        "Day"
                    ],
                ],
                "Account",
            ],
            "conditions" => [
                $employeeCond,
            ],
        ]);
        $workingHourComparator = [];
        $mapEmployeeType = [];
        $mapEmployeeAuto = [];
        $employeeIdList = [];
        foreach ($employees as $employee) {
            $workingHourComparator[$employee["Employee"]["id"]] = [];
            if (!$employee["WorkingHourType"]["is_custom"]) {
                foreach ($employee["WorkingHourType"]["WorkingHourTypeDetail"] as $workingHourTypeDetail) {
                    $workingHourComparator[$employee["Employee"]["id"]][$workingHourTypeDetail["Day"]["php_n"]] = $workingHourTypeDetail;
                }
            }
            $mapEmployeeType[$employee["Employee"]["id"]] = $employee["Employee"]["employee_type_id"];
            $mapEmployeeAuto[$employee["Employee"]["id"]] = !$employee["WorkingHourType"]["is_custom"];
            $employeeIdList[] = $employee["Employee"]["id"];
        }
        $rows = $this->find("all", [
            "conditions" => [
                "date(Attendance.dt) between '$start_date' and '$end_date'",
                $attendanceCond,
                "Attendance.employee_id" => $employeeIdList,
            ],
            "recursive" => -1,
            "order" => "Attendance.employee_id,Attendance.dt",
        ]);
        $preData = [];
        foreach ($rows as $row) {
            if ($mapEmployeeAuto[$row["Attendance"]["employee_id"]]) {
                if ($row["Attendance"]["attendance_type_id"] == 2 && empty($row["Attendance"]["miss_attendance_id"])) {
                    $n_attendance = date("N", strtotime($row["Attendance"]["dt"]));
                    if (!isset($workingHourComparator[$row["Attendance"]["employee_id"]][$n_attendance])) {
                        $n_attendance--;
                        if ($n_attendance <= 0) {
                            $n_attendance = 7;
                        }
                        if (!isset($workingHourComparator[$row["Attendance"]["employee_id"]][$n_attendance])) {
                            continue;
                        }
                    } else {
                        $workingHourTypeDetail = $workingHourComparator[$row["Attendance"]["employee_id"]][$n_attendance];
                    }
                    $startHomeT = $workingHourTypeDetail["start_home"];
                    $endHomeT = $workingHourTypeDetail["end_home"];
                    $d = $row['Attendance']['d'];
                    $startHomeDt = $d . " " . $startHomeT;
                    if (strtotime($startHomeT) < strtotime($endHomeT)) {
                        $endHomeDt = $d . " " . $endHomeT;
                    } else {
                        $endHomeDt = date("Y-m-d", strtotime($d . " +1 day")) . " " . $endHomeT;
                    }
                    if (strtotime($startHomeDt) <= strtotime($row["Attendance"]["dt"]) && strtotime($row["Attendance"]["dt"]) <= strtotime($endHomeDt)) {
                        
                    } else {
                        $d = date("Y-m-d", strtotime($d . " -1 day"));
                    }
//                debug($row["Attendance"]["dt"]);
//                debug($startHomeT);
//                debug($endHomeT);
//                debug($startHomeDt);
//                debug($endHomeDt);
//                debug($d);
//                debug(strtotime($startHomeDt) <= strtotime($row["Attendance"]["dt"]) && strtotime($row["Attendance"]["dt"]) <= strtotime($endHomeDt));
//                debug("========================================================================");
                    if (!isset($preData[$row['Attendance']['employee_id']][$d][$row['Attendance']['attendance_type_id']]) || $row['Attendance']['t'] < $preData[$row['Attendance']['employee_id']][$d][$row['Attendance']['attendance_type_id']]) {
                        $preData[$row['Attendance']['employee_id']][$d][$row['Attendance']['attendance_type_id']] = $row['Attendance']['t'];
                    }
                } else if ($row["Attendance"]["attendance_type_id"] == 5) {
                    $countOT = $this->find("count", [
                        "recursive" => -1,
                        "conditions" => [
                            "DATE_FORMAT(Attendance.dt,'%Y-%m-%d')" => date("Y-m-d", strtotime($row["Attendance"]["dt"])),
                            "DATE_FORMAT(Attendance.dt,'%H:%i:%s') <= '{$row["Attendance"]["dt"]}'",
                            "Attendance.employee_id" => $row["Attendance"]["employee_id"],
                            "Attendance.attendance_type_id" => [$attendanceTypes["ot_out"]],
                        ],
                    ]);
                    if (empty($countOT)) {
                        $preData[$row['Attendance']['employee_id']][$row['Attendance']['d']][$row['Attendance']['attendance_type_id']] = $row['Attendance']['t'];
                    }
                } else {
                    if (!isset($preData[$row['Attendance']['employee_id']][$row['Attendance']['d']][$row['Attendance']['attendance_type_id']]) || $row['Attendance']['t'] < $preData[$row['Attendance']['employee_id']][$row['Attendance']['d']][$row['Attendance']['attendance_type_id']]) {
                        $preData[$row['Attendance']['employee_id']][$row['Attendance']['d']][$row['Attendance']['attendance_type_id']] = $row['Attendance']['t'];
                    }
                }
            } else {
                $d = $row['Attendance']['d'];
                $dminone = date("Y-m-d", strtotime($d . " -1 day"));
                if ($row['Attendance']['attendance_type_id'] == 2 && !isset($preData[$row['Attendance']['employee_id']][$d][1]) && !isset($preData[$row['Attendance']['employee_id']][$dminone][2])) {
                    $preData[$row['Attendance']['employee_id']][$dminone][$row['Attendance']['attendance_type_id']] = $row['Attendance']['t'];
                } else {
                    $preData[$row['Attendance']['employee_id']][$row['Attendance']['d']][$row['Attendance']['attendance_type_id']] = $row['Attendance']['t'];
                }
            }
        }
        $holidays = ClassRegistry::init("Holiday")->find("all", [
            "conditions" => [
                "or" => [
                    "date(Holiday.start_date) between '$start_date' and '$end_date'",
                    "date(Holiday.end_date) between '$start_date' and '$end_date'",
                ]
            ]
        ]);
        $allHolidays = [];
        foreach ($holidays as $holiday) {
            $allHolidays = array_merge($allHolidays, createDateRangeArray($holiday['Holiday']['start_date'], $holiday['Holiday']['end_date']));
        }
        $build = [];
        $permitData = [];
        $missAttendanceData = [];
        $overtimeData = [];
        foreach ($employees as $employee) {
            $permitData[$employee['Employee']['id']] = [];
            $missAttendanceData[$employee['Employee']['id']] = [];
            $overtimeData[$employee['Employee']['id']] = [];
            $date = $start_date;
            $workDays = [];
            if (!$employee["WorkingHourType"]["is_custom"]) {
                foreach ($employee['WorkingHourType']['WorkingHourTypeDetail'] as $workingHour) {
                    $workDays[] = $workingHour['Day']['php_n'];
                    $build[$employee['Employee']['id']]['info']['jam_kerja'][$workingHour['day_id']] = $workingHour;
                }
            }
            while (strtotime($date) <= strtotime($end_date)) {
                if ($employee['WorkingHourType']["is_custom"]) {
                    $build[$employee['Employee']['id']]['data'][$date] = [];
                    $build[$employee['Employee']['id']]['data'][$date]['libur'] = false;
                } else if (!$employee['WorkingHourType']['ignore_holiday']) {
                    if (in_array(date("N", strtotime($date)), $workDays) && !in_array($date, $allHolidays)) {
                        $build[$employee['Employee']['id']]['data'][$date] = [];
                        $build[$employee['Employee']['id']]['data'][$date]['libur'] = false;
                    } else {
                        $build[$employee['Employee']['id']]['data'][$date] = [];
                        $build[$employee['Employee']['id']]['data'][$date]['libur'] = true;
                    }
                } else {
                    if (in_array(date("N", strtotime($date)), $workDays)) {
                        $build[$employee['Employee']['id']]['data'][$date] = [];
                        $build[$employee['Employee']['id']]['data'][$date]['libur'] = false;
                    } else {
                        $build[$employee['Employee']['id']]['data'][$date] = [];
                        $build[$employee['Employee']['id']]['data'][$date]['libur'] = true;
                    }
                }

                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        }
        $permits = ClassRegistry::init("Permit")->find("all", [
            "conditions" => [
                "and" => [
                    "permit_status_id" => 2,
                    "or" => [
                        "date(Permit.start_date) between '$start_date' and '$end_date'",
                        "date(Permit.end_date) between '$start_date' and '$end_date'",
                    ],
                ]
            ],
            "contain" => [
                "PermitType" => [
                    "PermitCategory",
                ],
            ],
        ]);
        foreach ($permits as $permit) {
            if (isset($permitData[$permit['Permit']['employee_id']])) {
                foreach (createDateRangeArray($permit['Permit']['start_date'], $permit['Permit']['end_date']) as $dt) {
                    $permitData[$permit['Permit']['employee_id']][] = [
                        "dt" => $dt,
                        "type" => $permit["PermitType"]["uniq_name"],
                        "category" => $permit["PermitType"]["PermitCategory"]["name"],
                    ];
                }
            }
        }
        $permitTypeList = ClassRegistry::init("PermitType")->find("list", ["fields" => ["PermitType.uniq_name", "PermitType.name"]]);
        $permitCategories = ClassRegistry::init("PermitCategory")->find("all", [
            "contain" => [
                "PermitType",
            ],
        ]);
        $missAttendances = ClassRegistry::init("MissAttendance")->find("all", [
            "conditions" => [
                "and" => [
                    "miss_attendance_status_id" => 2,
                    "or" => [
                        "date(MissAttendance.miss_date) between '$start_date' and '$end_date'",
                    ]
                ]
            ]
        ]);

        foreach ($missAttendances as $missAttendance) {
            if (isset($missAttendanceData[$missAttendance['MissAttendance']['employee_id']])) {
                $missAttendanceData[$missAttendance['MissAttendance']['employee_id']] = array_merge($missAttendanceData[$missAttendance['MissAttendance']['employee_id']], [$missAttendance['MissAttendance']['miss_date']]);
            }
        }
        $overtimes = ClassRegistry::init("Overtime")->find("all", [
            "conditions" => [
                "and" => [
                    "Overtime.validate_status_id" => 2,
                    "or" => [
                        "date(Overtime.overtime_date) between '$start_date' and '$end_date'",
                    ]
                ]
            ],
            "recursive" => -1,
        ]);

        foreach ($overtimes as $overtime) {
            if (isset($overtimeData[$overtime['Overtime']['employee_id']])) {
                $overtimeData[$overtime['Overtime']['employee_id']] = array_merge($overtimeData[$overtime['Overtime']['employee_id']], [$overtime['Overtime']['overtime_date'] => ["start_time" => $overtime['Overtime']['start_time'], "end_time" => $overtime['Overtime']['end_time']]]);
            }
        }
        $today = date("Y-m-d");
        foreach ($build as $employee_id => $dateData) {
            $build[$employee_id]['summary'] = [
                "jumlah_telat" => 0,
                "jumlah_hadir" => 0,
                "jumlah_absen" => 0,
                "jumlah_lupa_absen" => 0,
                "jumlah_kerja" => 0,
                "jumlah_hadir_libur" => 0,
                "jumlah_jam_kerja_libur" => 0,
                "jumlah_jam_kerja" => 0,
                "jumlah_jam_lembur" => 0,
                "jumlah_jam_kerja_seharusnya" => 0,
                "jumlah_jam_telat" => 0,
                "jumlah_cepat_pulang" => 0,
                "permit" => [],
            ];
            foreach ($permitCategories as $permitCategory) {
                $build[$employee_id]['summary']["permit"]["jumlah_{$permitCategory["PermitCategory"]["name"]}"] = 0;
                $build[$employee_id]['summary']["permit"]["detail_{$permitCategory["PermitCategory"]["name"]}"] = [];
                foreach ($permitCategory["PermitType"] as $permitType) {
                    $build[$employee_id]['summary']["permit"]["detail_{$permitCategory["PermitCategory"]["name"]}"][$permitType["uniq_name"]] = 0;
                }
            }
            $build[$employee_id]["info"]["lupa_absen"] = $missAttendanceData[$employee_id];
            foreach ($dateData['data'] as $date => $dateEntity) {
                $build[$employee_id]['data'][$date]['masuk'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['work_in']]);
                $build[$employee_id]['data'][$date]['pulang'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['work_out']]);
                $build[$employee_id]['data'][$date]['keluar_istirahat'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['break_out']]);
                $build[$employee_id]['data'][$date]['kembali_istirahat'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['break_in']]);
                $build[$employee_id]['data'][$date]['lembur_masuk'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['ot_in']]);
                $build[$employee_id]['data'][$date]['lembur_pulang'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['ot_out']]);
                $build[$employee_id]['data'][$date]['absen'] = issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['work_in']]) == null || issetAndNotEmpty(@$preData[$employee_id][$date][$attendanceTypes['work_out']]) == null;
                $build[$employee_id]['data'][$date]['jenis_ijin'] = false;
                $build[$employee_id]['data'][$date]['permit_category'] = false;
                $build[$employee_id]['data'][$date]['permit'] = false;
                $build[$employee_id]['data'][$date]['belum_absen'] = false;
                $build[$employee_id]['data'][$date]['ispasseddate'] = true;
                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = 0;
                if ($build[$employee_id]['data'][$date]['lembur_masuk'] >= $build[$employee_id]['data'][$date]['lembur_pulang']) {
                    $build[$employee_id]['data'][$date]['lembur_masuk'] = null;
                }
                if (($idx = array_search($date, array_column($permitData[$employee_id], "dt"))) !== false) {
                    $build[$employee_id]['data'][$date]['permit'] = true;
                    $build[$employee_id]['data'][$date]['jenis_ijin'] = $permitData[$employee_id][$idx]["type"];
                    $build[$employee_id]['data'][$date]['permit_category'] = $permitData[$employee_id][$idx]["category"];
                    //detail ijin
                } else {
                    $build[$employee_id]['data'][$date]['permit'] = false;
                }
                if (in_array($date, $missAttendanceData[$employee_id])) {
                    $build[$employee_id]['data'][$date]['lupa_absen'] = true;
                } else {
                    $build[$employee_id]['data'][$date]['lupa_absen'] = false;
                }

                if ($build[$employee_id]['data'][$date]['masuk'] != null && ($build[$employee_id]['data'][$date]['pulang'] != null || $build[$employee_id]['data'][$date]['lembur_pulang'] != null)) {
                    if ($build[$employee_id]['data'][$date]['pulang'] != null) {
                        $startWork = issetAndNotEmpty(@$build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                        if (!empty($startWork) && (strtotime($startWork) > strtotime($build[$employee_id]['data'][$date]['masuk']))) {
                            $startTime = $startWork;
                        } else {
                            $startTime = $build[$employee_id]['data'][$date]['masuk'];
                        }
                        if (!$build[$employee_id]['data'][$date]['libur']) {
                            if (strtotime($build[$employee_id]['data'][$date]['pulang']) < strtotime($build[$employee_id]['data'][$date]['masuk'])) {
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['pulang'] . " +1 day") - strtotime($startTime);
                            } else {
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['pulang']) - strtotime($startTime);
                            }
                        } else {
                            $startOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["start_time"], false);
                            $endOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["end_time"], false);
                            if ($startOvertimeForm != false && strtotime($startOvertimeForm) > strtotime($startTime)) {
                                $startTime = $startOvertimeForm;
                            }
                            if ($endOvertimeForm != false && strtotime($endOvertimeForm) < strtotime($build[$employee_id]['data'][$date]['pulang'])) {
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($endOvertimeForm) - strtotime($startTime);
                            } else {
                                if (strtotime($build[$employee_id]['data'][$date]['pulang']) < strtotime($build[$employee_id]['data'][$date]['masuk'])) {
                                    $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['pulang'] . " +1 day") - strtotime($startTime);
                                } else {
                                    $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['pulang']) - strtotime($startTime);
                                }
                            }
                        }
                        $build[$employee_id]['data'][$date]['absen'];
                    } else if (!isset($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))])) {
                        $startWork = "8:30:00";
                        $startHourly = "16:30:00";
                        $endHourly = "16:30:01";
                        $startOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["start_time"], false);
                        $endOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["end_time"], false);
                        if (!empty($build[$employee_id]['data'][$date]['lembur_pulang']) && !empty($build[$employee_id]['data'][$date]['lembur_masuk'])) {
                            $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['lembur_pulang']) - strtotime($build[$employee_id]['data'][$date]['lembur_masuk']);
                            $endHourly = $build[$employee_id]['data'][$date]['lembur_pulang'];
                        } else if (!empty($build[$employee_id]['data'][$date]['lembur_pulang']) && !empty($build[$employee_id]['data'][$date]['masuk'])) {
                            if (strtotime($startWork) > strtotime($build[$employee_id]['data'][$date]['masuk'])) {
                                $startTime = $startWork;
                            } else {
                                $startTime = $build[$employee_id]['data'][$date]['masuk'];
                            }
                            if ($startOvertimeForm != false && strtotime($startOvertimeForm) > strtotime($startTime)) {
                                $startTime = $startOvertimeForm;
                            }
                            if ($endOvertimeForm != false) {
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($endOvertimeForm) - strtotime($startTime);
                            } else {
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($build[$employee_id]['data'][$date]['lembur_pulang']) - strtotime($startTime);
                            }
                            $endHourly = $build[$employee_id]['data'][$date]['lembur_pulang'];
                        } else {
                            $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = 0;
                        }
                        $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = strtotime($endHourly) - strtotime($startHourly);
                        if ($build[$employee_id]['data'][$date]['jumlah_jam_lembur'] < 0) {
                            if (strtotime($endHourly) < strtotime($startWork)) {
                                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = (strtotime("23:59:59") - strtotime($startHourly)) + (strtotime($endHourly) - strtotime("00:00:00"));
                            } else {
                                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = 1;
                            }
                        }
                        $build[$employee_id]['data'][$date]['absen'] = false;
                    } else if ($build[$employee_id]['data'][$date]['lembur_pulang'] != null) {
                        $startWork = $build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work'];
                        $endTime = $endwork = $build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work'];
                        if (strtotime($startWork) > strtotime($build[$employee_id]['data'][$date]['masuk'])) {
                            $startTime = $startWork;
                        } else {
                            $startTime = $build[$employee_id]['data'][$date]['masuk'];
                        }

                        $startOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["start_time"], false);
                        $endOvertimeForm = e_isset(@$overtimeData[$employee_id][$date]["end_time"], false);

                        if ($build[$employee_id]['data'][$date]['libur']) {
                            if ($startOvertimeForm != false && strtotime($startOvertimeForm) > strtotime($startTime)) {
                                $startTime = $startOvertimeForm;
                            }

                            if ($endOvertimeForm != false && strtotime($endOvertimeForm) < strtotime($endwork)) {
                                $endwork = $endOvertimeForm;
                            }
                        }
                        //jam lembur
                        $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = strtotime($endwork) - strtotime($startTime);
                        $build[$employee_id]['data'][$date]['pulang'] = date("H:i:s", strtotime($endTime));
                        $build[$employee_id]['data'][$date]['absen'] = false;
                        if (isset($overtimeData[$employee_id][$date])) {
                            if (!empty($build[$employee_id]['data'][$date]['lembur_masuk'])) {
//                                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = strtotime($build[$employee_id]['data'][$date]['lembur_pulang']) - strtotime($build[$employee_id]['data'][$date]['lembur_masuk']);
                                $startOvertime = $build[$employee_id]['data'][$date]['lembur_masuk'];
                                $endOvertime = $build[$employee_id]['data'][$date]['lembur_pulang'];
                            } else {
                                $build[$employee_id]['data'][$date]['lembur_masuk'] = date("H:i:s", strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['overtime_in']));
//                                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = strtotime($build[$employee_id]['data'][$date]['lembur_pulang']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['overtime_in']);
                                $startOvertime = $build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['overtime_in'];
                                $endOvertime = $build[$employee_id]['data'][$date]['lembur_pulang'];
                            }
                            if (strtotime($overtimeData[$employee_id][$date]["end_time"]) <= strtotime($endOvertime)) {
                                $endOvertime = $overtimeData[$employee_id][$date]["end_time"];
                            }
                            $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = strtotime($endOvertime) - strtotime($startOvertime);
                            if ($build[$employee_id]['data'][$date]['jumlah_jam_lembur'] < 0) {
                                if (strtotime($endOvertime) < strtotime($startWork)) {
                                    $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = (strtotime("23:59:59") - strtotime($startOvertime)) + (strtotime($endOvertime) - strtotime("00:00:00"));
                                } else {
                                    $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] = 1;
                                }
                            }
                            //potongan istirahat lembur
                            if (strtotime(_START_LEMBUR) >= strtotime($startOvertime)) {
                                if (strtotime($endOvertime) < strtotime(_START_LEMBUR)) {
                                    $potonganIstirahat = 0;
                                } else if (strtotime($endOvertime) <= strtotime(_END_LEMBUR)) {
                                    $potonganIstirahat = strtotime($endOvertime) - strtotime(_START_LEMBUR);
                                } else {
                                    $potonganIstirahat = strtotime(_END_LEMBUR) - strtotime(_START_LEMBUR);
                                }
                            } else {
                                if (strtotime($startOvertime) > strtotime(_END_LEMBUR)) {
                                    $potonganIstirahat = 0;
                                } else if (strtotime($endOvertime) <= strtotime(_END_LEMBUR)) {
                                    $potonganIstirahat = strtotime($endOvertime) - strtotime($startOvertime);
                                } else {
                                    $potonganIstirahat = strtotime(_END_LEMBUR) - strtotime($startOvertime);
                                }
                            }
//                        $build[$employee_id]['data'][$date]['jumlah_jam_lembur']-=$potonganIstirahat;
                        }
                    } else {
                        $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = 0;
                    }
                } else {
                    $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = 0;
                }

                if (!$build[$employee_id]['data'][$date]['libur'] && $mapEmployeeAuto[$employee_id]) {
                    if ($build[$employee_id]['data'][$date]['masuk'] === null) {
                        $build[$employee_id]['data'][$date]['terlambat'] = -1;
                    } else {
                        $build[$employee_id]['data'][$date]['terlambat'] = strtotime($build[$employee_id]['data'][$date]['masuk']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']) - ($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['tolerance_late'] * 60);
                    }
                    if ($build[$employee_id]['data'][$date]['pulang'] === null) {
                        $build[$employee_id]['data'][$date]['pulang_lebih_awal'] = -1;
                    } else {
                        if (strtotime($build[$employee_id]['data'][$date]['pulang']) < strtotime($build[$employee_id]['data'][$date]['masuk'])) {
                            $build[$employee_id]['data'][$date]['pulang_lebih_awal'] = strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']) - strtotime($build[$employee_id]['data'][$date]['pulang'] . " +1 day") - ($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['tolerance_home_early'] * 60);
                        } else {
                            $build[$employee_id]['data'][$date]['pulang_lebih_awal'] = strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']) - strtotime($build[$employee_id]['data'][$date]['pulang']) - ($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['tolerance_home_early'] * 60);
                        }
                        if (($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['tolerance_home_early'] * 60) <= $build[$employee_id]['data'][$date]['pulang_lebih_awal']) {
                            $build[$employee_id]['summary']["jumlah_cepat_pulang"] ++;
                        }
                    }
                    $build[$employee_id]['data'][$date]['jumlah_jam_kerja_seharusnya'] = strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                } else {
                    $build[$employee_id]['data'][$date]['jumlah_jam_kerja_seharusnya'] = 0;
                    $build[$employee_id]['data'][$date]['pulang_lebih_awal'] = -1;
                    $build[$employee_id]['data'][$date]['terlambat'] = -1;
                }
                if (!$ignorePassDate && ($date > $today)) {
                    $build[$employee_id]['data'][$date]['ispasseddate'] = false;
                    $build[$employee_id]['data'][$date]['absen'] = false;
                    $build[$employee_id]['data'][$date]['permit'] = false;
                    $build[$employee_id]['data'][$date]['lupa_absen'] = false;
                    $build[$employee_id]['data'][$date]['jenis_ijin'] = false;
                    $build[$employee_id]['data'][$date]['permit_category'] = false;
                    $build[$employee_id]['data'][$date]['pulang_lebih_awal'] = -1;
                    $build[$employee_id]['data'][$date]['terlambat'] = -1;
                    $build[$employee_id]['data'][$date]['status'] = "Belum ada data";
                    continue;
                }
                if (!$build[$employee_id]['data'][$date]['libur']) {
                    if ($build[$employee_id]['data'][$date]['permit']) {
                        $build[$employee_id]['summary']["permit"]["detail_{$permitData[$employee_id][$idx]["category"]}"][$permitData[$employee_id][$idx]["type"]] ++;
                        $build[$employee_id]['summary']["permit"]["jumlah_{$permitData[$employee_id][$idx]["category"]}"] ++;
                        $build[$employee_id]['data'][$date]['status'] = $permitTypeList[$permitData[$employee_id][$idx]["type"]];
                        $build[$employee_id]['data'][$date]["jenis_ijin"] = $permitData[$employee_id][$idx]["type"];
                        $build[$employee_id]['data'][$date]['permit_category'] = $permitData[$employee_id][$idx]["category"];
                    } else {
                        if ($build[$employee_id]['data'][$date]['lupa_absen']) {
                            $build[$employee_id]['summary']['jumlah_lupa_absen'] ++;
                            $build[$employee_id]['summary']['jumlah_hadir'] ++;
                            $build[$employee_id]['data'][$date]['status'] = "Lupa Absen";

                            //total jumlah jam kerja
                            $build[$employee_id]['summary']['jumlah_jam_kerja']+=$build[$employee_id]['data'][$date]['jumlah_jam_kerja'];
                            //total jumlah jam kerja seharusnya
                            if ($mapEmployeeAuto[$employee_id]) {
                                $build[$employee_id]['summary']['jumlah_jam_kerja_seharusnya']+=strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                            }
                        } else if ($build[$employee_id]['data'][$date]['terlambat'] > 0) {
                            if (!$build[$employee_id]['data'][$date]['absen']) {
                                $build[$employee_id]['summary']['jumlah_telat'] ++;
                                $build[$employee_id]['summary']['jumlah_hadir'] ++;
                                $build[$employee_id]['data'][$date]['status'] = "Terlambat " . (round($build[$employee_id]['data'][$date]['terlambat'] / 60)) . " menit";

                                $build[$employee_id]['summary']['jumlah_jam_telat'] +=$build[$employee_id]['data'][$date]['terlambat'];
                                //total jumlah jam kerja
                                $build[$employee_id]['summary']['jumlah_jam_kerja']+=$build[$employee_id]['data'][$date]['jumlah_jam_kerja'];
                                //total jumlah jam kerja seharusnya
                                $build[$employee_id]['summary']['jumlah_jam_kerja_seharusnya']+=strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                            } else {
                                if ($build[$employee_id]['data'][$date]['pulang'] != null || $build[$employee_id]['data'][$date]['lembur_pulang'] != null) {
                                    $build[$employee_id]['data'][$date]['status'] = "Absen (Tidak ada finger masuk)";
                                    $build[$employee_id]['data'][$date]['belum_absen'] = true;
                                } else if ($build[$employee_id]['data'][$date]['masuk'] != null || $build[$employee_id]['data'][$date]['lembur_masuk'] != null) {
                                    $build[$employee_id]['data'][$date]['status'] = "Absen (Tidak ada finger pulang)";
                                    $build[$employee_id]['data'][$date]['belum_absen'] = true;
                                } else {
                                    $build[$employee_id]['data'][$date]['status'] = "Absen";
                                }
                            }
                        } else if ($build[$employee_id]['data'][$date]['jumlah_jam_kerja_seharusnya'] <= $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] && $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] > 0) {
                            $build[$employee_id]['summary']['jumlah_hadir'] ++;
                            $build[$employee_id]['data'][$date]['status'] = "Ok";

                            //total jumlah jam kerja
                            $build[$employee_id]['summary']['jumlah_jam_kerja']+=$build[$employee_id]['data'][$date]['jumlah_jam_kerja'];
                            //total jumlah jam kerja seharusnya
                            if ($mapEmployeeAuto[$employee_id]) {
                                $build[$employee_id]['summary']['jumlah_jam_kerja_seharusnya']+=strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                            }
                        } else if ($build[$employee_id]['data'][$date]['jumlah_jam_kerja'] <= 0) {
                            $build[$employee_id]['summary']['jumlah_absen'] ++;
                            if ($build[$employee_id]['data'][$date]['pulang'] != null || $build[$employee_id]['data'][$date]['lembur_pulang'] != null) {
                                $build[$employee_id]['data'][$date]['status'] = "Absen (Tidak ada finger masuk)";
                                $build[$employee_id]['data'][$date]['belum_absen'] = true;
                            } else if ($build[$employee_id]['data'][$date]['masuk'] != null || $build[$employee_id]['data'][$date]['lembur_masuk'] != null) {
                                $build[$employee_id]['data'][$date]['status'] = "Absen (Tidak ada finger pulang)";
                                $build[$employee_id]['data'][$date]['belum_absen'] = true;
                            } else {
                                $build[$employee_id]['data'][$date]['status'] = "Absen";
                            }
                            //total jumlah jam kerja seharusnya
                            if (isset($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))])) {
                                $build[$employee_id]['summary']['jumlah_jam_kerja_seharusnya']+=strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                            }
                        } else {
                            $build[$employee_id]['summary']['jumlah_hadir'] ++;
                            $build[$employee_id]['data'][$date]['status'] = "Hadir tetapi tidak memenuhi jam kerja";

                            //total jumlah jam kerja
                            $build[$employee_id]['summary']['jumlah_jam_kerja']+=$build[$employee_id]['data'][$date]['jumlah_jam_kerja'];
                            //total jumlah jam kerja seharusnya
                            $build[$employee_id]['summary']['jumlah_jam_kerja_seharusnya']+=strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['end_work']) - strtotime($build[$employee_id]['info']['jam_kerja'][date("N", strtotime($date))]['start_work']);
                        }
                        $build[$employee_id]['summary']['jumlah_kerja'] ++;
                        if ($build[$employee_id]['data'][$date]['jumlah_jam_kerja'] < 3600 * 5 && $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] > 1800) {
                            $build[$employee_id]['summary']['jumlah_hadir']-=0.5;
                        }
                    }
                } else {
                    if ($build[$employee_id]['data'][$date]['jumlah_jam_kerja'] > 0) {
                        if (isset($overtimeData[$employee_id][$date])) {
                            $build[$employee_id]['summary']['jumlah_jam_kerja_libur'] += $build[$employee_id]['data'][$date]['jumlah_jam_kerja'];
                            if ($mapEmployeeType[$employee_id] == 2) {
                                $build[$employee_id]['data'][$date]['jumlah_jam_lembur'] += ($build[$employee_id]['data'][$date]['jumlah_jam_kerja'] * 2);
                                $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] = 0;
                            }
                            $build[$employee_id]['data'][$date]['status'] = "Kerja pada hari libur";
                            $build[$employee_id]['summary']['jumlah_hadir_libur'] ++;
                            if ($build[$employee_id]['data'][$date]['jumlah_jam_kerja'] < 3600 * 6 && $build[$employee_id]['data'][$date]['jumlah_jam_kerja'] > 1800) {
                                $build[$employee_id]['summary']['jumlah_hadir_libur']-=0.5;
                            }
                        } else {
                            $build[$employee_id]['data'][$date]['status'] = "Hadir pada hari libur (belum ada form)";
                        }
                    } else {
                        $build[$employee_id]['data'][$date]['status'] = "Libur";
                    }
                }
//                $build[$employee_id]['summary']['jumlah_kerja'] = $build[$employee_id]['summary']['jumlah_hadir'] + $build[$employee_id]['summary']['jumlah_lupa_absen'];
                $build[$employee_id]['summary']['jumlah_jam_lembur']+=$build[$employee_id]['data'][$date]['jumlah_jam_lembur'];
                $totalPermit = 0;
                foreach ($build[$employee_id]['summary']["permit"] as $permitDetail) {
                    if (is_numeric($permitDetail)) {
                        $totalPermit+=$permitDetail;
                    }
                }
                $build[$employee_id]['summary']['jumlah_tidak_hadir'] = $build[$employee_id]['summary']['jumlah_absen'] + $totalPermit;
            }
        }
        return $build;
    }

}

?>
