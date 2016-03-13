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
        $this->data['error'] = "";
        $this->data['bingo'] = "";
        $this->data['results'] = "";

		$this->render();
	}

    public function search() {
        $error = false;
        $day = $this->input->post('day');
        $time = $this->input->post('time');

        $this->data['days']       = $this->timetable->getDays();
        $this->data['periods']    = $this->timetable->getPeriods();
        $this->data['courses']    = $this->timetable->getCourses();
        $this->data['dayDDL']     = form_dropdown('day',  $this->timetable->getWeekDays());
        $this->data['timeDDL']    = form_dropdown('time', $this->timetable->getTimeslots());

        $days = $this->timetable->getBookingsFromDays($day, $time);
        $periods = $this->timetable->getBookingsFromPeriods($day, $time);
        $courses = $this->timetable->getBookingsFromCourses($day, $time);

        $check = array();
        $this->data['pageTitle'] = "Homepage";
        $this->data['pagebody']  = "homepage";
        if (count($days) != 1) {
            $this->data['error'] = "ERROR:" ."<br/>" . "By Days has more/less bookings returned than 1";
            $error = true;
        }
        if (count($periods) != 1) {
            $this->data['error'] = "ERROR:" ."<br/>" . "By Periods has more/less bookings returned than 1";
            $error = true;
        }
        if (count($courses) != 1) {
            $this->data['error'] = "ERROR:" ."<br/>" . "By Courses has more/less bookings returned than 1";
            $error = true;
        }

        if(!$error) {
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
                $this->data['error'] = "ERROR:" ."<br/>" . "All three bookings returned are not the same";
                $error = true;
            }
        }

        if ($error) {
            $this->data['results'] = "";
            $this->data['bingo']   = "";
            $this->render();
            return;
        } else {
            $this->data['error']   = "";
            $this->data['bingo']   = "Bingo";
            $this->data['results'] = "Day: " . $result['day'] . "<br/>"
                                     . "Time: " . $result['time'] . "<br/>"
                                     . "Type: " . $result['type'] . "<br/>"
                                     . "Course: " . $result['course'] . "<br/>"
                                     . "Instructor: " . $result['first_name']  . " " . $result['last_name'] . "<br/>"
                                     . "Building: " . $result['building'] . "<br/>"
                                     . "Room: " . $result['number'];
            $this->render();
        }
    }
}
