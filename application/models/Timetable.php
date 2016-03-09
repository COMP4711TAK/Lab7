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

class Booking extends CI_Model {
    public $type       = '';
    public $day        = null;
    public $course     = null;
    public $time       = null;
    public $first_name = null;
    public $last_name  = null;
    public $room       = '';
    public $building   = '';
    public $number     = '';

    function __construct($booking) {
        parent::__construct();

        $this->type       = $booking['type'];
        $this->day        = $booking['day'];
        $this->course     = $booking["course"];
        $this->time       = $booking["time"];
        $this->first_name = $booking->instructor->first_name;
        $this->last_name  = $booking->instructor->last_name;
        $this->building   = $booking->room->building;
        $this->number     = $booking->room->number;

    }

}