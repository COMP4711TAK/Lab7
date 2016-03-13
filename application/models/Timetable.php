<?php

class Timetable extends CI_Model {
    protected $xml     = null;
    protected $days    = array();
    protected $periods = array();
    protected $courses = array();

    function __construct() {
        parent::__construct();

        $this->xml = simplexml_load_file('data/schedule.xml');

        foreach ($this->xml->days->day as $day) {
            $record = new stdClass();

            $record->day_of_the_week = (string) $day->day_of_the_week;
            $record->bookings         = array();

            foreach ($day->booking as $booking) {
                array_push($record->bookings, new Booking($booking));
            }
            array_push($this->days, $record);
        }

        foreach ($this->xml->courses->course as $course) {
            $record = new stdClass();

            $record->id         = (string) $course->id;
            $record->title      = (string) $course->title;
            $record->first_name = (string) $course->instructor->first_name;
            $record->last_name  = (string) $course->instructor->last_name;
            $record->bookings   = array();

            foreach ($course->booking as $booking) {
                array_push($record->bookings, new Booking($booking));
            }
            array_push($this->courses, $record);
        }

        foreach ($this->xml->periods->timeslot as $timeslot) {
            $record = new stdClass();

            $record->startTime     = (string) $timeslot['startTime'];
            $record->bookings = array();

            foreach ($timeslot->booking as $booking) {
                array_push($record->bookings, new Booking($booking));
            }
            array_push($this->periods, $record);
        }
        return $this->days;
    }
    
    function getDays() {
        return $this->days;
    }
    
    function getPeriods() {
        return $this->periods;
    }
    
    function getCourses() {
        return $this->courses;
    }

    function getWeekDays() {
        return array
           ("Monday"    => "Monday",
            "Tuesday"   => "Tuesday",
            "Wednesday" => "Wednesday",
            "Thursday"  => "Thursday",
            "Friday"    => "Friday");
    }

    function getTimeslots() {
        return array
           ("8:30"   => "8:30",
            "9:30"   => "9:30",
            "10:30"  => "10:30",
            "11:30"  => "11:30",
            "12:30"  => "12:30",
            "1:30"   => "1:30",
            "2:30"   => "2:30",
            "3:30"   => "3:30",
            "4:30"   => "4:30");
    }

    function getBookingsFromDays($day, $time) {
        $results = array();
        foreach($this->days as $weekDay){
            if($weekDay->day_of_the_week == $day) {
                foreach($weekDay->bookings as $booking) {
                    if ($booking->time == $time) {
                        array_push($results, $booking);
                    }
                }
            }
        }
        return $results;
    }

    function getBookingsFromPeriods($day, $time) {
        $results = array();
        foreach($this->periods as $timeslot) {
            if($timeslot->startTime) {
                foreach ($timeslot->bookings as $booking) {
                    if ($booking->day == $day) {
                        array_push($results, $booking);
                    }
                }
            }
        }
        return $results;
    }

    function getBookingsFromCourses($day, $time) {
        $results = array();
        foreach($this->courses as $course) {
            foreach ($course->bookings as $booking) {
                if ($booking->day == $day && $booking->time == $time) {
                    array_push($results, $booking);
                }
            }
        }
        return $results;
    }
}

class Booking extends CI_Model {
    public $type       = '';
    public $day        = null;
    public $course     = null;
    public $time       = null;
    public $first_name = null;
    public $last_name  = null;
    public $building   = '';
    public $number     = '';

    function __construct($booking) {
        parent::__construct();

        $this->type       = (string) $booking['type'];
        $this->day        = (isset($booking['day'])) ? (string) $booking['day'] : null;
        $this->course     = (isset($booking['course'])) ? (string) $booking["course"] : null;
        $this->time       = (isset($booking['time'])) ? (string) $booking["time"] : null;
        $this->first_name = (isset($booking->instructor->first_name)) ? (string) $booking->instructor->first_name : null;
        $this->last_name  = (isset($booking->instructor->last_name)) ? (string) $booking->instructor->last_name : null;
        $this->building   = (string) $booking->room->building;
        $this->number     = (string) $booking->room->number;

    }

}