<?php 
require "../assets/php/fpdf.php";
require "../controllers/database/config.php";

session_start();

if (!isset($_SESSION['account_auth_id'])) {
	header('location:https://careappsoftware.ml/admin/index.php');
} else if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else if (!isset($_POST['report_print'])) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {

    $transaction_id = $_POST['transaction_id_print'];
    $admin_id = $_SESSION['admin_id'];
    $is_lock = 0;

    $user_id = "";
    $user_account_id = "";
    $user_account_name = "";
    $user_email = "";
    $user_cellphone_number = "";
    $barangay_name = "";
    $report_id = "";
    $report_name = "";
    $report_type_name = "";
    $report_details = "";
    $upload_set_id = "";
    $dept_name = "";
    $admin_name = "";
    $is_resolved = "";
    $is_anonymous = 0;
    $transaction_end_date = "";
    $transaction_array = array();

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT assistance_transactions.transaction_id, 
    assistance_transactions.user_id, 
    account_information.account_id, 
    account_information.email, 
    account_information.cellphone_number, 
    barangays.barangay_name, 
    assistance_transactions.report_id, 
    reports.report_name, 
    reports.report_details, 
    assistance_transactions.report_type_id, 
    assistance_transactions.report_convo_id, 
    assistance_transactions.upload_set_id, 
    assistance_transactions.dept_id, 
    departments.dept_name, 
    assistance_transactions.admin_id,  
    assistance_transactions.is_resolved, 
    assistance_transactions.is_anonymous, 
    assistance_transactions.transaction_start_date, 
    assistance_transactions.transaction_end_date 
    FROM `assistance_transactions` 
    INNER JOIN `account_information` ON assistance_transactions.user_id = account_information.user_id 
    INNER JOIN `barangays` ON assistance_transactions.barangay_id = barangays.barangay_id 
    INNER JOIN `reports` ON assistance_transactions.report_id = reports.report_id 
    INNER JOIN `departments` ON assistance_transactions.dept_id = departments.dept_id 
    WHERE assistance_transactions.transaction_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            if ($row['is_resolved'] == 0) {
                $is_resolved = "pending";
            } else {
                $is_resolved = "resolved";
            }
            if ($admin_id == $row['admin_id']) {
                $is_lock = 1;
            } else if ($row['admin_id'] == 0) {
                $is_lock = 2;
            } else {
                $is_lock = 0;
            }
            if ($row['report_type_id'] == 0) {
                $report_type_name = "Complaint";
            } else {
                $report_type_name = "Concern";
            }
            $user_id = $row['user_id'];
            $user_account_id = $row['account_id'];
            $user_email = $row['email'];
            $user_cellphone_number = $row['cellphone_number'];
            $barangay_name = $row['barangay_name'];
            $report_id = $row['report_id'];
            $report_name = $row['report_name'];
            $report_details = $row['report_details'];
            $upload_set_id = $row['upload_set_id'];
            $dept_name = $row['dept_name'];
            $v_admin_id = $row['admin_id'];
            $is_anonymous = intval($row['is_anonymous']);
            $transaction_end_date = $row['transaction_end_date'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        echo "<script>console.log('Query Error (report_print.php stmt1->prepare) : $stmt1->errno : $stmt1->error');</script>";
    }

    if ($stmt2 -> prepare("
    SELECT admin_name
    FROM `admins`
    WHERE admin_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $v_admin_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $admin_name = $row['admin_name'];
            }
        }

        // Close statement
        $stmt2 -> close();

    } else {
        echo "<script>console.log('Query Error (report_print.php stmt2->prepare) : $stmt2->errno : $stmt2->error');</script>";
    }

    if ($stmt3 -> prepare("
    SELECT account_name
    FROM `accounts`
    WHERE account_id = ?;")) {
        // Bind parameters
        $stmt3 -> bind_param("s", $user_account_id);

        // Execute query
        $stmt3 -> execute();

        // Fetch values
        $result = $stmt3 -> get_result();
        while($row = $result -> fetch_assoc()){
            $user_account_name = $row['account_name'];
        }

        // Close statement
        $stmt3 -> close();

    } else {
        echo "<script>console.log('Query Error (report_print.php stmt3->prepare) : $stmt3->errno : $stmt3->error');</script>";
    }

    function get_starred($str) {
        $len = strlen($str);
        return substr($str, 0, 1).str_repeat('*', $len - 2);
    }
    
    function get_starred_phone($str) {
        $len = strlen($str);
        return str_repeat('*', $len - 2).substr($str, $len - 1, 1);
    }
    
    function hide_mail($email) {
        $mail_segments = explode("@", $email);
        $mail_segments[0] = str_repeat("*", strlen($mail_segments[0]));
    
        return implode("@", $mail_segments);
    }
    
    if ($is_anonymous == 1) {
        $user_account_name = get_starred($user_account_name);
        $user_email = hide_mail($user_email);
        if ($user_cellphone_number != "") {
            $user_cellphone_number = get_starred_phone($user_cellphone_number);
        }
    }

    $transaction_end_date = date("Y-m-d h:iA", strtotime($transaction_end_date));

    class ReportPDF extends FPDF {
        /**
         * Declaration of Variables
         */
        private $report_id;
        
        function getUserId() {
            return $this -> report_id;
        }
        function setUserId($report_id) {
            $this -> report_id = $report_id;
        }

        function header() {
            $this -> Image('../assets/img/faviconlogo.jpg', 10, 6, 30, 30);
            $this -> Image('../assets/img/CARELogo.png', 177.5, 6, 30, 30);
            $this -> SetFont('Times','B',12);
            $this -> Cell(197.5, 7, 'Republic of the Philippines', 0, 2, 'C');
            $this -> Cell(197.5, 7, 'Province of Batangas', 0, 2, 'C');
            $this -> Cell(197.5, 7, 'Municipality of Malvar', 0, 2, 'C');
            $this -> SetFont('Times','',12);
            $this -> Cell(197.5, 7, 'Malvar Municipal Hall', 0, 0, 'C');
            $this -> Ln(20);
        }
        function footer() {
            $this -> SetY(-15);
            $this -> SetFont('Times','',8);
            $this -> Cell(0,10,'Page '.$this -> PageNo(). '/{nb}', 0, 0, 'C');
        }
    }

    $report_pdf = new ReportPDF();
    $report_pdf -> setUserId($report_id);
    $report_pdf -> SetTitle("CARE_" . $report_type_name . "Report_" . $report_id . "-" . $transaction_id . "-" . $user_id, true);
    $report_pdf -> SetAuthor("CARE", true);
    $report_pdf -> SetCreator("CARE", true);
    $report_pdf -> SetSubject($report_type_name . " Report", true);
    $report_pdf -> AliasNbPages();
    $report_pdf -> AddPage('P','Letter',0);

    // report id
    $report_pdf -> SetFont('Times','B',12);
    $report_pdf -> Cell(197.5, 5, 'Report ID : ' . $report_pdf -> getUserId(), 0, 2, 'L');
    $report_pdf -> Cell(197.5, 10, 'Transaction ID : ' . $transaction_id, 0, 2, 'L');
    $report_pdf -> Ln(5);

    // resident info
    $report_pdf -> SetFont('Times','B',12);
    $report_pdf -> Cell(197.5, 5, 'Resident Information', 0, 0, 'L');
    
    $report_pdf -> Ln(10);
    $report_pdf -> SetFont('Times','',12);
    $report_pdf -> Cell(197.5, 5, 'User ID : ' . $user_id, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Resident Name : ' . $user_account_name, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Barangay Name : ' . $barangay_name, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Email : ' . $user_email, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Cellphone Number : ' . $user_cellphone_number, 0, 2, 'L');
    $report_pdf -> Ln(10);

    // body
    $report_pdf -> SetFont('Times','B',12);
    $report_pdf -> Cell(197.5, 5, $report_type_name . ' Report Information', 0, 0, 'L');
    
    $report_pdf -> Ln(10);
    $report_pdf -> SetFont('Times','',12);
    $report_pdf -> Cell(197.5, 5, 'Report Name : ' . $report_name, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Date : ' . $transaction_end_date, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Department Involved : ' . $dept_name, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Admin Involved : ' . $admin_name, 0, 2, 'L');
    $report_pdf -> Cell(197.5, 5, 'Report Status : ' . $is_resolved, 0, 2, 'L');
    $report_pdf -> Ln(10);
    $report_pdf -> SetFont('Times','B',12);
    $report_pdf -> Cell(197.5, 5, 'Report Details', 0, 2, 'L');
    $report_pdf -> Ln(5);
    $report_pdf -> SetFont('Times','',12);
    //$report_pdf -> Cell(197.5, 5, '     ' . $report_details, 0, 2, 'L');
    $report_pdf -> MultiCell(197.5, 5,'     ' . $report_details, 0,'L');
    $report_pdf -> Ln(10);
    $report_pdf -> SetFont('Times','B',12);
    $report_pdf -> Cell(197.5, 5, 'Uploads', 0, 2, 'L');
    $report_pdf -> Ln(5);
    $report_pdf -> Cell(30, 5, 'Upload ID', 1, 0, 'C');
    $report_pdf -> Cell(30, 5, 'Upload Set ID', 1, 0, 'C');
    $report_pdf -> Cell(137.5, 5, 'Upload Filename', 1, 0, 'C');
    $report_pdf -> Ln();
    $report_pdf -> SetFont('Times','',12);
    if ($stmt4 -> prepare("
    SELECT *
    FROM `uploads`
    WHERE upload_set_id = ?;")) {
        // Bind parameters
        $stmt4 -> bind_param("s", $upload_set_id);

        // Execute query
        $stmt4 -> execute();

        // Fetch values
        $result = $stmt4 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $report_pdf -> Cell(30, 5, $row['upload_id'], 1, 0, 'C');
                $report_pdf -> Cell(30, 5, $row['upload_set_id'], 1, 0, 'C');
                $report_pdf -> Cell(137.5, 5, $row['upload_filename'], 1, 0, 'C');
                $report_pdf -> Ln();
            }
        } else {
            $report_pdf -> Cell(197.5, 5, "No Files Uploaded", 1, 0, 'C');
            $report_pdf -> Ln();
        }

        // Close statement
        $stmt4 -> close();

    } else {
        echo "<script>console.log('Query Error (report_print.php stmt4->prepare) : $stmt4->errno : $stmt4->error');</script>";
    }

    // execute output
    $report_pdf -> Output();

}

$conn -> close();

?>