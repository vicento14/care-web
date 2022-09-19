<?php 
session_start();

if(isset($_SESSION['account_auth_id'])) {

    header('location:../admin/dashboard.php');

} else if (!isset($_SESSION['email'])) { 

    echo "<script>window.location.href = './index.php';</script>";

} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CARE | Forgot Password </title>
    <link rel="shortcut icon" href="../assets/img/faviconlogo.jpg" />
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    
</head>

<body>
    <div class="overlay">
        <div class="container">
            <div class="wrapper">
                <div class="title">Forgot Password</div>
                <form>
                    <div class="row">
                        <i class="fas fa-lock"></i>
                        <label for="fp_code"><b>Code</b></label>
                        <input type="text" placeholder="Enter Code" id="fp_code" name="fp_code" maxlength="6">
                    </div>
                    <div class="row button">
                        <input type="button" id="fp_next" name="fp_next" value="Next">
                        <input type="button" id="fp_back" name="fp_back" value="Back">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- script for sign-in -->
    <script>
        const fp_back = document.querySelector('#fp_back');
        const fp_next = document.querySelector('#fp_next');
        fp_next.addEventListener('click', () => {
            let fp_code = document.querySelector('#fp_code').value;
            var data = `code=${fp_code}`;
            if (fp_code != ''){
                sendData(data, "../controllers/admin/fp_verify_code.php");
            } else {
                alert("Please type the code");
            }
        });
        fp_back.addEventListener('click', () => {
            window.location.href = "../admin/forgot_pass_step1.php";
        });
        // HttpRequest Data
        const sendHttpRequest = (method, url, data) => {
            const promise = new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);
                if(data){
                    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                }
                xhr.onload = () => {
                    if (xhr.status >= 400){
                        reject(xhr.response);
                    }
                    resolve(xhr.response);
                };
                xhr.onerror = () => {
                    reject('Error');
                };
                xhr.send(data);
            });
            return promise;
        };

        // POST
        const sendData = (data, url) => {
            sendHttpRequest('POST', url, data).then(responseData => {
                if (responseData == 1) {
                    window.location.href = "../admin/forgot_pass_step3.php";
                    document.getElementById("fp_code").value = '';
                } else {
                    alert("Incorrect Code");
                }
            }).catch(err => {
                console.log(err);
            });
        };
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>
<?php } ?>