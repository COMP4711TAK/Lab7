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

        $this->type       = (string) $booking['type'];
        $this->day        = (string) $booking['day'];
        $this->course     = (string) $booking["course"];
        $this->time       = (string) $booking["time"];
        $this->first_name = (string) $booking->instructor->first_name;
        $this->last_name  = (string) $booking->instructor->last_name;
        $this->building   = (string) $booking->room->building;
        $this->number     = (string) $booking->room->number;

    }

}