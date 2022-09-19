<?php
function notif_insert($opt, $transaction_id) {
    include('../database/config.php');
    include('../../vendor/autoload.php');

    $notif_msg_id = 0;
    $notif_id = 0;
    $user_id = 0;
    $admin_id = 0;
    $dept_admins_array = array();
    $dept_id = 0;
    $to_account_id = 0;
    $to_accounts_array = array();
    $from_account_id = 0;
    $from_barangay_name = "";
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
    $stmt8 = $conn -> stmt_init();
    $stmt9 = $conn -> stmt_init();
    $stmt10 = $conn -> stmt_init();
    $stmt11 = $conn -> stmt_init();

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
        "SELECT barangays.barangay_name, 
        assistance_transactions.user_id, 
        assistance_transactions.admin_id, 
        assistance_transactions.dept_id, 
        assistance_transactions.report_type_id, 
        report_types.report_type_name
        FROM `assistance_transactions` 
        INNER JOIN `barangays` ON assistance_transactions.barangay_id = barangays.barangay_id 
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
                $from_barangay_name = $row['barangay_name'];
                $user_id = intval($row['user_id']);
                $admin_id = intval($row['admin_id']);
                $dept_id = intval($row['dept_id']);
                $report_type_id = intval($row['report_type_id']);
                $report_type_name = $row['report_type_name'];
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
        "SELECT admin_id FROM `admins_departments` 
        WHERE dept_id = ?;")) {
        // Bind parameters
        $stmt4 -> bind_param("s", $dept_id);
        
        // Execute query
        $stmt4 -> execute();
    
        // Fetch values
        $result = $stmt4 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($dept_admins_array, intval($row['admin_id']));
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

    switch ($opt) {
        case 1:
            if ($stmt5 -> prepare(
                "SELECT account_id FROM `account_information` 
                WHERE admin_id = ?;")) {
                // Bind parameters
                $stmt5 -> bind_param("s", $admin_id);
                
                // Execute query
                $stmt5 -> execute();
            
                // Fetch values
                $result = $stmt5 -> get_result();
                $numRows = $result -> num_rows;
                if ($numRows > 0) {
                    while($row = $result -> fetch_assoc()){
                        $to_account_id = intval($row['account_id']);
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
            break;
        case 2:
            if ($stmt6 -> prepare(
                "SELECT account_id FROM `account_information` 
                WHERE admin_id = ?;")) {
                foreach ($dept_admins_array as $value) {
                    // Bind parameters
                    $stmt6 -> bind_param("s", $value);
                    
                    // Execute query
                    $stmt6 -> execute();
                
                    // Fetch values
                    $result = $stmt6 -> get_result();
                    $numRows = $result -> num_rows;
                    if ($numRows > 0) {
                        while($row = $result -> fetch_assoc()){
                            array_push($to_accounts_array, intval($row['account_id']));
                        }
                    } else {
                        $success = 0;
                    }
                }
        
                // Close statement
                $stmt6 -> close();
            } else {
                $success = 0;
                echo "Query Error (notif_insert.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
            }
            break;
        default:
            $success = 0;
    }

    if ($stmt7 -> prepare(
        "SELECT account_id FROM `account_information` WHERE user_id = ?;")) {
        // Bind parameters
        $stmt7 -> bind_param("s", $user_id);
        
        // Execute query
        $stmt7 -> execute();
    
        // Fetch values
        $result = $stmt7 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $from_account_id = intval($row['account_id']);
            }
        } else {
            $success = 0;
        }

        // Close statement
        $stmt7 -> close();
    } else {
        $success = 0;
        echo "Query Error (notif_insert.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
    }

    switch ($opt) {
        case 1:
            $notif_msg_details = "A resident of Barangay ". $from_barangay_name . " sent you a message.";
            break;
        case 2:
            $notif_msg_details = "A resident of Barangay ". $from_barangay_name . " submitted a report.";
            break;
        default:
            $success = 0;
    }

    if ($success != 0) {

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

        switch ($opt) {
            case 1:
                if ($stmt8 -> prepare(
                    "INSERT INTO `cms_notif_msg` 
                    (notif_msg_id, notif_msg_details) 
                    VALUES (?, ?);")) {
                    // Bind parameters
                    $stmt8 -> bind_param("ss", $notif_msg_id, $notif_msg_details);
                    
                    // Execute query
                    $stmt8 -> execute();
            
                    // Close statement
                    $stmt8 -> close();
                } else {
                    $success = 0;
                    echo "Query Error (notif_insert.php stmt8->prepare) : $stmt8->errno : $stmt8->error";
                }
                if ($stmt9 -> prepare(
                    "INSERT INTO `cms_notif_info` 
                    (notif_id, notif_date, 
                    notif_msg_id, transaction_id, 
                    to_account_id, from_account_id, 
                    is_read, is_read_date, 
                    is_deleted, is_deleted_date) 
                    VALUES (?, ?, ?, ?, ?, ?, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');")) {
                    // Bind parameters
                    $stmt9 -> bind_param("ssssss", $notif_id, $notif_date, $notif_msg_id, $transaction_id, $to_account_id, $from_account_id);
                    
                    // Execute query
                    $stmt9 -> execute();
            
                    // Close statement
                    $stmt9 -> close();
                } else {
                    $success = 0;
                    echo "Query Error (notif_insert.php stmt9->prepare) : $stmt9->errno : $stmt9->error";
                }

                $notif_date = date("Y-m-d h:iA", strtotime($notif_date));

                $data = array(
                    'notif_id' => $notif_id,
                    'notif_date' => $notif_date,
                    'notif_msg_details' => $notif_msg_details,
                    'transaction_id' => $transaction_id,
                    'from_account_id' => $from_account_id,
                    'report_type_id' => $report_type_id, 
                    'report_type_name' => $report_type_name, 
                    'admin_id' => $admin_id 
                );

                $pusher->trigger('care-app-143', 'admin-notif', $data);

                break;
            case 2:
                $i = 0;
                foreach ($to_accounts_array as $value) {
                    if ($stmt10 -> prepare(
                        "INSERT INTO `cms_notif_msg` 
                        (notif_msg_id, notif_msg_details) 
                        VALUES (?, ?);")) {
                        // Bind parameters
                        $stmt10 -> bind_param("ss", $notif_msg_id, $notif_msg_details);
                        
                        // Execute query
                        $stmt10 -> execute();

                    } else {
                        $success = 0;
                        echo "Query Error (notif_insert.php stmt10->prepare) : $stmt10->errno : $stmt10->error";
                    }
                    if ($stmt11 -> prepare(
                        "INSERT INTO `cms_notif_info` 
                        (notif_id, notif_date, 
                        notif_msg_id, transaction_id, 
                        to_account_id, from_account_id, 
                        is_read, is_read_date, 
                        is_deleted, is_deleted_date) 
                        VALUES (?, ?, ?, ?, ?, ?, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');")) {
                        // Bind parameters
                        $stmt11 -> bind_param("ssssss", $notif_id, $notif_date, $notif_msg_id, $transaction_id, $value, $from_account_id);
                        
                        // Execute query
                        $stmt11 -> execute();

                    } else {
                        $success = 0;
                        echo "Query Error (notif_insert.php stmt11->prepare) : $stmt11->errno : $stmt11->error";
                    }

                    $notif_date_2 = date("Y-m-d h:iA", strtotime($notif_date));

                    $data = array(
                        'notif_id' => $notif_id,
                        'notif_date' => $notif_date_2,
                        'notif_msg_details' => $notif_msg_details,
                        'transaction_id' => $transaction_id,
                        'from_account_id' => $from_account_id,
                        'report_type_id' => $report_type_id, 
                        'report_type_name' => $report_type_name, 
                        'admin_id' => $dept_admins_array[$i] 
                    );

                    $pusher->trigger('care-app-143', 'admin-notif', $data);

                    $notif_msg_id++;
                    $notif_id++;
                    $i++;
                }

                // Close statement
                $stmt10 -> close();
                $stmt11 -> close();

                break;
            default:
                $success = 0;
        }

        if ($success != 0) {
            $success = 1;
        }

    }

    $conn->close();

    return $success;
}
?>