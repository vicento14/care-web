<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../../assets/php/PHPMailer-master/src/PHPMailer.php';
    require '../../assets/php/PHPMailer-master/src/SMTP.php';
    require '../../assets/php/PHPMailer-master/src/Exception.php';

    session_start();

    $email = $_SESSION['email'];

    $result_array = array();
    $result_array['success'] = 1;
    $result_array['message'] = "";

    $six_digit_random_number = random_int(100000, 999999);

    $code_mail = new PHPMailer();
    $code_mail -> isSMTP();
    //$code_mail -> SMTPDebug = 2;
    $code_mail -> Mailer = "smtp";
    /*
    $code_mail -> SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
    */
    $code_mail -> Host = gethostbyname('ssl://smtp.gmail.com');
    $code_mail -> SMTPAuth = true;
    $code_mail -> SMTPAutoTLS = false;
    $code_mail -> Username = '143.careappsoftware@gmail.com';
    $code_mail -> Password = 't3nDeRl0v!n6c4rE';
    $code_mail -> SMTPSecure = 'ssl';
    $code_mail -> Port = 465;
    $code_mail -> setFrom('143.careappsoftware@gmail.com', 'Malvar CARE System');
    $code_mail -> addAddress($email);
    $code_mail -> Subject = 'CARE - Recovery Code';
    $code_mail -> Body = "Your recovery code is {$six_digit_random_number}";
    
    if ($code_mail -> Send()) {
        $result_array['message'] .= "Code Sent Successfully. ";
        $_SESSION['code'] = $six_digit_random_number;
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Code Sent Failed. Mailer Error: {$code_mail -> ErrorInfo}";
    }

    $code_mail -> smtpClose();

    if ($result_array['success'] != 0) {
        $result_array['success'] = 1;
        $result_array['message'] = "Success";
    }

    echo json_encode($result_array);

?>