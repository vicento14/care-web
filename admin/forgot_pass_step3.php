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
                    <input type="text" name="hidden_username" id="hidden_username" value="username" style="display: none;" autocomplete="username email">
                    <div class="row">
                        <i class="fas fa-lock"></i>
                        <label for="new_password"><b>New Password</b></label>
                        <input type="password" placeholder="Enter New Password" id="new_password" name="new_password" autocomplete="new-password" maxlength="255">
                        <span>
                            <i class="fas fa-eye-slash" id="eye"></i>
                        </span>
                    </div>
                    <div class="row">
                        <i class="fas fa-lock"></i>
                        <label for="retype_password"><b>Retype Password</b></label>
                        <input type="password" placeholder="Retype Password" id="retype_password" name="retype_password" autocomplete="new-password" maxlength="255">
                        <span>
                            <i class="fas fa-eye-slash" id="eye2"></i>
                        </span>
                    </div>
                    <div class="row button">
                        <input type="button" id="fp_cp" name="fp_cp" value="Change Password">
                        <input type="button" id="fp_cancel" name="fp_cancel" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--eye toggle-->
    <script>
        var state = false;
        var state2 = false;
        document.getElementById("eye").style.color = '#828b82';
        document.getElementById("eye2").style.color = '#828b82';
        const togglePassword = document.querySelector('#eye');
        const togglePassword2 = document.querySelector('#eye2');

        togglePassword.addEventListener('click', () => {
            if (state) {
                document.getElementById("new_password").setAttribute("type", "password");
                document.getElementById("eye").style.color = '#828b82';
                document.getElementById("eye").className = "fas fa-eye-slash";
                state = false;
            } else {
                document.getElementById("new_password").setAttribute("type", "text");
                document.getElementById("eye").style.color = '#2FA734';
                document.getElementById("eye").className = "fas fa-eye";
                state = true;
            }
        });

        togglePassword2.addEventListener('click', () => {
            if (state) {
                document.getElementById("retype_password").setAttribute("type", "password");
                document.getElementById("eye").style.color = '#828b82';
                document.getElementById("eye").className = "fas fa-eye-slash";
                state = false;
            } else {
                document.getElementById("retype_password").setAttribute("type", "text");
                document.getElementById("eye").style.color = '#2FA734';
                document.getElementById("eye").className = "fas fa-eye";
                state = true;
            }
        });
    </script>

    <!-- script for sign-in -->
    <script>
        const fp_cancel = document.querySelector('#fp_cancel');
        const fp_cp = document.querySelector('#fp_cp');
        fp_cp.addEventListener('click', () => {
            let new_password = document.querySelector('#new_password').value;
            let retype_password = document.querySelector('#retype_password').value;
            var data = `new_password=${new_password}`;
            if (new_password != '') {
                if (retype_password == new_password) {
                    sendData(data, "../controllers/admin/fp_change_pass.php");
                    document.getElementById("new_password").value = '';
                    document.getElementById("retype_password").value = '';
                } else {
                    alert("New password not match to retype password! Please try again");
                }
            } else {
                alert("Please type your new password");
            }
        });
        fp_cancel.addEventListener('click', () => {
            getData("../controllers/admin/fp_close.php");
            window.location.href = "../admin/index.php";
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
                    getData("../controllers/admin/fp_close.php");
                } else {
                    alert("Change Password Failed");
                }
            }).catch(err => {
                console.log(err);
            });
        };

        // GET
        const getData = (url) => {
            sendHttpRequest('GET', url).then(responseData => {
                window.location.href = "../admin/index.php";
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