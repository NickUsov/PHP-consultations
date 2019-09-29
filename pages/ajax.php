<?php
    include_once 'classes.php';
    $date = $_POST['date'];
    $pare = $_POST['pare'];
    $info = $_POST['info'];
    $customer_id = $_POST['user'];
    $user = Customer::fromDb($customer_id);
    $name = $user->getLogin();
    $room_id = $_POST['room_id'];
    $students = $_POST['students'];
    if($pare && $room_id && $students){
        $consult = new Consult( $room_id, $customer_id, $date, $pare, $students, $info, 0);
        $consult->intoDb();
        echo "<span>$name  $students</span>";
    }
    
?>