<div class="row">
    <div class="col-md-6">
        <h3>Days</h3>
        {days}
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">{day_of_the_week}</div>

            <table class="table">
                <tr>
                    <th>Time</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Building</th>
                    <th>Room</th>
                    <th>Instructor</th>
                </tr>
                {bookings}
                <tr>
                    <td>{time}</td>
                    <td>{course}</td>
                    <td>{type}</td>
                    <td>{building}</td>
                    <td>{number}</td>
                    <td>{first_name} {last_name}</td>
                </tr>
                {/bookings}
            </table>
        </div>
        {/days}
    </div>
    <div class="col-md-6">
        <h3>Periods</h3>
        {periods}
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">{startTime}</div>

            <table class="table">
                <tr>
                    <th>Day</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Building</th>
                    <th>Room</th>
                    <th>Instructor</th>
                </tr>
                {bookings}
                <tr>
                    <td>{day}</td>
                    <td>{course}</td>
                    <td>{type}</td>
                    <td>{building}</td>
                    <td>{number}</td>
                    <td>{first_name} {last_name}</td>
                </tr>
                {/bookings}
            </table>
        </div>
        {/periods}
    </div>
    <div class="col-md-6">
        <h3>Courses</h3>
        {courses}
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">{id} - {title} - {first_name} {last_name}</div>

            <table class="table">
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Building</th>
                    <th>Room</th>
                    <th>Instructor</th>
                </tr>
                {bookings}
                <tr>
                    <td>{day}</td>
                    <td>{time}</td>
                    <td>{type}</td>
                    <td>{building}</td>
                    <td>{number}</td>
                </tr>
                {/bookings}
            </table>
        </div>
        {/courses}
    </div>
</div>