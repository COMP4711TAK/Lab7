<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->data['pageTitle'] = 'Homepage';
		// this is the view we want shown
		$this->data['pagebody']   = 'homepage';
		$this->data['days']       = $this->timetable->getDays();
		$this->data['periods']    = $this->timetable->getPeriods();
		$this->data['courses']    = $this->timetable->getCourses();
		$this->data['dayDDL']     = form_dropdown('day',  $this->timetable->getWeekDays());
        $this->data['timeDDL']    = form_dropdown('time', $this->timetable->getTimeslots());

		$this->render();
	}

    public function search() {
        $day = $this->input->post('day');
        $time = $this->input->post('time');

        $days = $this->timetable->getBookingsFromDays($day, $time);
        $periods = $this->timetable->getBookingsFromPeriods($day, $time);
        $courses = $this->timetable->getBookingsFromCourses($day, $time);
        //print_r($days);
        //print_r($periods);
        //print_r($courses);
        $check = array();
        $this->data['pageTitle'] = "Search Result";
        $this->data['pagebody']  = "error";
        if (count($days) != 1) {
            $this->data['error'] = "By Days has more/less bookings returned than 1";
            $this->render();
            return;
        }
        if (count($periods) != 1) {
            $this->data['error'] = "By Periods has more/less bookings returned than 1";
            $this->render();
            return;
        }
        if (count($courses) != 1) {
            $this->data['error'] = "By Courses has more/less bookings returned than 1";
            $this->render();
            return;
        }
        $result = array();
        foreach($days[0] as $key => $info) {
            if(isset($info))
                $result[$key] = $info;
            array_push($check, $info);
        }
        foreach($periods[0] as $key => $info) {
            if(isset($info))
                $result[$key] = $info;
            array_push($check, $info);
        }
        foreach($courses[0] as $key => $info) {
            if(isset($info))
                $result[$key] = $info;
            array_push($check, $info);
        }
        $check = array_filter(array_unique($check));
        if(count($check) != 8 || count($result) != 8) {
            $this->data['error'] = "All three bookings returned are not the same";
            $this->render();
            return;
        }
        $this->data['pagebody'] = "result";
        $this->data['searchDay']  = $day;
        $this->data['searchTime'] = $time;
        $this->data['day']        = $result['day'];
        $this->data['type']       = $result['type'];
        $this->data['course']     = $result['course'];
        $this->data['time']       = $result['time'];
        $this->data['first_name'] = $result['first_name'];
        $this->data['last_name']  = $result['last_name'];
        $this->data['building']   = $result['building'];
        $this->data['number']     = $result['number'];
        $this->render();
    }
}
