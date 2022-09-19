<?php
function notif_insert($opt, $transaction_id, $admin_id) {
    
    include('../database/config.php');
    include('../../vendor/autoload.php');

    //session_start();

    //$admin_id = $_SESSION['admin_id'];

    $notif_msg_id = 0;
    $notif_id = 0;
    $user_id = 0;
    $to_account_id = 0;
    $from_account_id = 0;
    $from_dept_name = "";
    $notif_msg_details = "";
    $report_type_id = 0;
    $report_type_name = "";

    date_default_timezone_set("Asia/Manila");
    $notif_date = date('Y-m-d H:i:s');

    $success = 1;

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();
    $stmt5 = $conn -> stmt_init();
    $stmt6 = $conn -> stmt_init();
    $stmt7 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "SELECT notif_msg_id FROM `cms_notif_msg` ORDER BY notif_msg_id DESC LIMIT 1;")) {
        // Execute query
        $stmt1 -> execute();
    
        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $notif_msg_id = intval($row['notif_msg_id']);
            }
        }

        // Close statement
        $stmt1 -> close();

        $notif_msg_id++;

    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare(
        "SELECT notif_id FROM `cms_notif_info` ORDER BY notif_id DESC LIMIT 1;")) {
        // Execute query
        $stmt2 -> execute();
    
        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $notif_id = intval($row['notif_id']);
            }
        }

        // Close statement
        $stmt2 -> close();

        $notif_id++;

    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    if ($stmt3 -> prepare(
        "SELECT departments.dept_name, 
        assistance_transactions.report_type_id, 
        report_types.report_type_name, 
        assistance_transactions.user_id, 
        assistance_transactions.admin_id 
        FROM `assistance_transactions` 
        INNER JOIN `departments` ON assistance_transactions.dept_id = departments.dept_id 
        INNER JOIN `report_types` ON assistance_transactions.report_type_id = report_types.report_type_id 
        WHERE assistance_transactions.transaction_id = ?;")) {
        // Bind parameters
        $stmt3 -> bind_param("s", $transaction_id);
        
        // Execute query
        $stmt3 -> execute();
    
        // Fetch values
        $result = $stmt3 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $from_dept_name = $row['dept_name'];
                $report_type_id = intval($row['report_type_id']);
                $report_type_name = $row['report_type_name'];
                $user_id = intval($row['user_id']);
                if ($opt == 2) {
                    $admin_id = intval($row['admin_id']);
                }
            }
        } else {
            $success = 0;
        }

        // Close statement
        $stmt3 -> close();
    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
    }

    if ($stmt4 -> prepare(
        "SELECT account_id FROM `account_information` 
        WHERE user_id = ?;")) {
        // Bind parameters
        $stmt4 -> bind_param("s", $user_id);
        
        // Execute query
        $stmt4 -> execute();
    
        // Fetch values
        $result = $stmt4 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $to_account_id = intval($row['account_id']);
            }
        } else {
            $success = 0;
        }

        // Close statement
        $stmt4 -> close();
    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
    }

    if ($stmt5 -> prepare(
        "SELECT account_id FROM `account_information` WHERE admin_id = ?;")) {
        // Bind parameters
        $stmt5 -> bind_param("s", $admin_id);
        
        // Execute query
        $stmt5 -> execute();
    
        // Fetch values
        $result = $stmt5 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $from_account_id = intval($row['account_id']);
            }
        } else {
            $success = 0;
        }

        // Close statement
        $stmt5 -> close();
    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
    }

    switch ($opt) {
        case 1:
            $notif_msg_details = "The LGU Office Staff from ". $from_dept_name . " sent you a message.";
            break;
        case 2:
            $notif_msg_details = "The LGU Office Staff from ". $from_dept_name . " accepts your report.";
            break;
        case 3:
            $notif_msg_details = "The LGU Office Staff from ". $from_dept_name . " left your report. Someone will accept your report later.";
            break;
        case 4:
            $notif_msg_details = "The LGU Office Staff from ". $from_dept_name . " mark your report as resolved.";
            break;
        default:
            $success = 0;
    }

    if ($success != 0) {

        if ($stmt6 -> prepare(
            "INSERT INTO `cms_notif_msg` 
            (notif_msg_id, notif_msg_details) 
            VALUES (?, ?);")) {
            // Bind parameters
            $stmt6 -> bind_param("ss", $notif_msg_id, $notif_msg_details);
            
            // Execute query
            $stmt6 -> execute();
    
            // Close statement
            $stmt6 -> close();
        } else {
            $success = 0;
            echo "Query Error (notif_insert.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
        }

        if ($stmt7 -> prepare(
            "INSERT INTO `cms_notif_info` 
            (notif_id, notif_date, 
            notif_msg_id, transaction_id, 
            to_account_id, from_account_id, 
            is_read, is_read_date, 
            is_deleted, is_deleted_date) 
            VALUES (?, ?, ?, ?, ?, ?, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');")) {
            // Bind parameters
            $stmt7 -> bind_param("ssssss", $notif_id, $notif_date, $notif_msg_id, $transaction_id, $to_account_id, $from_account_id);
            
            // Execute query
            $stmt7 -> execute();
    
            // Close statement
            $stmt7 -> close();
        } else {
            $success = 0;
            echo "Query Error (notif_insert.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
        }

        if ($success != 0) {
            $success = 1;
        }

    }

    $notif_date = date("Y-m-d h:iA", strtotime($notif_date));

    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    
    $pusher = new Pusher\Pusher(
        '8ff31fe73cdbafda41bc',
        '97b072e991cee5747e1b',
        '1275373',
        $options
    );

    $data = array(
        'notif_id' => $notif_id,
        'notif_date' => $notif_date,
        'notif_msg_details' => $notif_msg_details,
        'transaction_id' => $transaction_id,
        'report_type_id' => $report_type_id,
        'report_type_name' => $report_type_name,
        'user_id' => $user_id
    );
    
    $pusher->trigger('care-app-143', 'user-notif', $data);

    $conn->close();

}
?>