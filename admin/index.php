<?php 
session_start();

if(isset($_SESSION['account_auth_id'])) {

    header('location:../admin/dashboard.php');

} else { 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CARE | Login </title>
    <link rel="shortcut icon" href="../assets/img/faviconlogo.jpg" />
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <!--<script src="https://www.google.com/recaptcha/api.js" aysnc defer></script>-->
    <script src="https://www.recaptcha.net/recaptcha/api.js" async defer></script>
    
</head>

<style>
    .overlayNEW {
    
        background-image: url('../assets/img/bg11.png');
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: .8;
        z-index: -1;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-color: #8fefcc;
        /*height: max-content !important;*/

    }
</style>

<body>
    <div class="overlayNEW">
        <!--login-->
        <div class="container">
            <div class="wrapper">
                <div class="title">
                    <img src="../assets/img/CARELogo.png" alt="" style="width: 100px; height: auto;">
                </div>
                <form>
                    <div class="row">
                        <i class="fas fa-user"></i>
                        <label for="uname"><b>Email</b></label>
                        <input type="text" placeholder="Enter email" id="user_email" name="user_email" autocomplete="username email" maxlength="320" required>
                    </div>
                    <div class="row">
                        <i class="fas fa-lock"></i>
                        <label for="psw"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" id="password" name="password" autocomplete="current-password" maxlength="255">
                        <span>
                            <i class="fas fa-eye-slash" id="eye"></i>
                        </span>
                    </div>
                    <div class="row">
                        <div class="g-recaptcha" data-sitekey="6LeAPT0dAAAAACqMIaACMhQZ8MAGKMfOcblNkqQY"></div>
                    </div>
                    <!--Login button-->
                    <div class="row button">
                        <input type="button" id="sign_in" name="sign_in" value="sign-in">
                    </div>
                    <div class="fp"><a href="./forgot_pass_step1.php">Forgot password?</a></div>
                </form>
            </div>
        </div>
    </div>

    <!--eye toggle-->
    <script>
        var state = false;
        document.getElementById("eye").style.color = '#828b82';
        const togglePassword = document.querySelector('#eye');

        togglePassword.addEventListener('click', () => {
            if (state) {
                document.getElementById("password").setAttribute("type", "password");
                document.getElementById("eye").style.color = '#828b82';
                document.getElementById("eye").className = "fas fa-eye-slash";
                state = false;
            } else {
                document.getElementById("password").setAttribute("type", "text");
                document.getElementById("eye").style.color = '#1cc88a';
                document.getElementById("eye").className = "fas fa-eye";
                state = true;
            }
        });
    </script>

    <!-- script for sign-in -->
    <script>
        const signin = document.querySelector('#sign_in');
        signin.addEventListener('click', () => {
            let user_email = document.querySelector('#user_email').value;
            let password = document.querySelector('#password').value;
            let recaptcha_response = grecaptcha.getResponse();
            if (user_email == ''){
                alert("Please type your email");
            } else if (recaptcha_response.length == 0) {
                alert("Please check the \"I'm not a robot\" option");
            } else {
                var login_data = `user_email=${user_email}&password=${password}&recaptcha_response=${recaptcha_response}`;
                sendData(login_data, "../controllers/admin/sign-in.php");
            }
        })
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
        const sendData = (login_data, url) => {
            sendHttpRequest('POST', url, login_data).then(responseData => {
                if (responseData == "success") {
                    window.location.href = "../admin/dashboard.php";
                    document.getElementById("user_email").value = '';
                    document.getElementById("password").value = '';
                } else {
                    alert(responseData);
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