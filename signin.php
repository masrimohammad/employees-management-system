<?php
if(isset($_REQUEST['employee'])){
    $output = array('error'=>false);

    include 'conn.php';
    include 'timezone.php';

    $employee = $_REQUEST['employee'];

    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
        $row = $query->fetch_assoc();
        $id = $row['id'];

        $date_now = date('Y-m-d');
        $time_now = date('H:i:s');

        $sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
            $echoMsg = 'Hi '.$row['firstname'].', You have timed in for today!';
        }
        else{
            //updates
            $sched = $row['schedule_id'];
            $lognow = date('H:i:s');
            $sql = "SELECT * FROM schedules WHERE id = '$sched'";
            $squery = $conn->query($sql);
            $srow = $squery->fetch_assoc();
            $logstatus = ($lognow > $srow['time_in']) ? 0 : 1;
            //
            $sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', '$time_now', '$logstatus')";
            if($conn->query($sql)){
                $echoMsg = 'You have timed in successfully! '. $time_now . ' <br><br>';
                $echoMsg .= 'Thanks '.$row['firstname'].' You smell productive ;)';
            }
            else{
                $echoMsg = 'Hi '.$row['firstname'].', Something Went Wrong. Please try again! '. $time_now;
            }
        }

        if($query->num_rows > 0){
            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);
            if($query->num_rows < 1){
                $echoMsg = 'Hi '.$row['firstname'].', Please time in first!';
            }
            else{
                $row = $query->fetch_assoc();
                if($row['time_out'] != '00:00:00'){
                    $echoMsg = 'Hi '.$row['firstname'].', You have timed out for today!';
                }
                else{

                    $sql = "UPDATE attendance SET time_out = '".$time_now."' WHERE id = '".$row['uid']."'";
                    if($conn->query($sql)){
                        $echoMsg = 'You have timed out successfully! '. $time_now . ' <br><br>';
                        $echoMsg .= 'Thanks '.$row['firstname'].' Have a nice day :)';

                        $sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
                        $query = $conn->query($sql);
                        $urow = $query->fetch_assoc();

                        $time_in = $urow['time_in'];
                        $time_out = $urow['time_out'];

                        $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
                        $query = $conn->query($sql);
                        $srow = $query->fetch_assoc();

                        if($srow['time_in'] > $urow['time_in']){
                            $time_in = $srow['time_in'];
                        }

                        if($srow['time_out'] < $urow['time_in']){
                            $time_out = $srow['time_out'];
                        }

                        $time_in = new DateTime($time_in);
                        $time_out = new DateTime($time_out);
                        $interval = $time_in->diff($time_out);
                        $hrs = $interval->format('%h');
                        $mins = $interval->format('%i');
                        $mins = $mins/60;
                        $int = $hrs + $mins;
                        if($int > 4){
                            $int = $int - 1;
                        }

                        $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '".$row['uid']."'";
                        $conn->query($sql);
                    }
                    else{
                        $echoMsg = 'Hi '.$row['firstname'].', Something Went Wrong. Please try again! '. $time_now;
                    }
                }

            }
        }
    }
    else{
        $echoMsg = 'Are you an intruder? Please use your own identifier! ';
    }

    echo '<h1 style="margin-top:20%; text-align: center">'.$echoMsg.'</h1>';
}
?>