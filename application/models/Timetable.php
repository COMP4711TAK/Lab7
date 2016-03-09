<?php

class Timetable extends CI_Model {
    protected $xml     = null;
    protected $days    = array();
    protected $periods = array();
    protected $courses = array();

    function __construct() {
        parent::__construct();

        $this->xml = simplexml_load_file('/data/schedule.xml');

        foreach ($this->xml->days->day as $day) {
            $record = new stdClass();

            $record->day_of_the_week = (string) $day->day_of_the_week;
            $record->booking         = array();

            foreach ($day->booking as $booking) {
                array_push($record->booking, new Booking($booking));
            }
        }
    }
}

public class Booking extends CI_Model {

}