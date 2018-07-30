<?php

class Holiday extends AppModel {

    var $name = 'Holiday';
    var $belongsTo = array(
    );
    var $hasOne = array(
    );
    var $hasMany = array(
    );
    var $validate = array(
    );
    var $virtualFields = array(
    );

    function beforeValidate($options = array()) {
        
    }

    function deleteData($id = null) {
        return $this->delete($id);
    }

    function findFromRange($start_date, $end_date) {
        $holidays = $this->find("all", [
            "conditions" => [
                "or" => [
                    "date(Holiday.start_date) between '$start_date' and '$end_date'",
                    "date(Holiday.end_date) between '$start_date' and '$end_date'",
                ]
            ]
        ]);
        $allHolidays = [];
        foreach ($holidays as $holiday) {
            $dates = createDateRangeArray($holiday['Holiday']['start_date'], $holiday['Holiday']['end_date']);
            foreach ($dates as $date) {
                if (!isset($allHolidays[$date])) {
                    $allHolidays[$date] = $holiday['Holiday']["name"];
                } else {
                    $allHolidays[$date] .= " | " . $holiday['Holiday']["name"];
                }
            }
        }
        return $allHolidays;
    }

}

?>
