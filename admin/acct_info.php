<?php
include('header.php');
$account_name = $_SESSION['account_name'];
$dept_name = $_SESSION['dept_name'];
$email = $_SESSION['email'];
$r_email = $_SESSION['r_email'];
$cellphone_number = $_SESSION['cellphone_number'];
?>

<title>CARE | Account Information</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!--  MODAL  -->

    <!-- Name modal -->
    <div class="modal fade" id="ChangeName" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Old Account Name</label>
                            <input type="text" class="form-control" id="old_account_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">New Account Name</label>
                            <input type="text" class="form-control" id="new_account_name" placeholder="New Account Name" maxlength="255">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="change_name">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo modal -->
    <div class="modal fade" id="ChangePhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_change_photo" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="file" name="account_photo" id="upload_photo" accept="image/*"><br> 
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="change_photo" id="change_photo">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Email -->
    <div class="modal fade" id="ChangeEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Email Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Old Email </label>
                        <input type="email" class="form-control" id="old_email" readonly> 
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">New Email</label>
                        <input type="email" class="form-control" id="new_email" placeholder="New Email" maxlength="320">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="change_email">Save</button>
            </div>
            </div>
        </div>
    </div>

    <!-- New Phone Number -->
    <div class="modal fade" id="ChangePhone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Phone Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Old Phone Number </label>
                    <input type="text" class="form-control" id="old_phone_num" readonly>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">New Phone Number</label>
                    <input type="text" class="form-control" id="new_phone_num" placeholder="New Phone Number" maxlength="11">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="change_phone_num">Save</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="modal fade" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" name="hidden_user_email1" id="hidden_user_email1" value="user_email" style="display: none;" autocomplete="username email">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Old Password</label>
                        <input type="password" class="form-control" id="old_pass" placeholder="Old Password" autocomplete="current-password" maxlength="255">
                        <input type="checkbox" onclick="oldPass()">Show Password<br>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">New Password</label>
                        <input type="password" id="new_pass" class="form-control" placeholder="New Password" autocomplete="new-password" maxlength="255">
                        <input type="checkbox" onclick="NewPass()">Show Password<br>

                        <label for="message-text" class="col-form-label">Confrm New Password</label>
                        <input type="password" id="retype_pass" class="form-control" placeholder="Retype Password" autocomplete="new-password" maxlength="255">
                        <input type="checkbox" onclick="cPass()">Show Password
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="change_pass">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Recovery Email -->
    <div class="modal fade" id="ChangeRecoveryEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Recovery Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Old Recovery Email</label>
                    <input type="email" class="form-control" id="old_r_email" readonly>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">New Recovery Email</label>
                    <input type="email" class="form-control" id="new_r_email" placeholder="New Recovery Email" maxlength="320">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="change_r_email">Save</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="row">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Basic Info</h1>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="d-flex">
                    <div class="p-2" id="disp_account_photo">
                        <img id="account_photo" src="../assets/img/noimage_person.png" alt="your image" style="height: 150px; width:auto;" class="p-3 rounded-circle" />
                    </div>
                    <div class="p-2">
                        <br>
                        <h4 id="disp_account_name"></h4>
                        <h6 id="disp_dept_name"></h6>
                    </div>
                    <div class="ml-auto p-2">
                        <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#ChangeName">Change</button>
                        <br>
                        <span class="btn btn-success mt-2" data-toggle="modal" data-target="#ChangePhoto">Change<br> Photo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contact Info</h1>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="d-flex">
                    <div class="p-2">
                        <label for="email" class="mb-4">Email :</label><br>
                        <label for="phone" class="mb-4">Phone :</label>
                    </div>
                    <div class="p-2">
                        <label name="email" class="mb-4" id="disp_email"></label><br>
                        <label name="phone" class="mb-4" id="disp_phone_num"></label>
                    </div>
                    <div class="ml-auto p-2">
                        <button class="btn btn-success mb-4" data-toggle="modal" data-target="#ChangeEmail">Change</button><br>
                        <button class="btn btn-success  mb-4" data-toggle="modal" data-target="#ChangePhone">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Security</h1>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-white-800 round">Change Password</h1>
                </div>
                <div class="d-flex">
                    <div class="p-2">
                        <label for="disp_new_pass">Password :</label><br>
                    </div>
                    <div class="p-2">
                        <form>
                            <input type="text" name="hidden_user_email2" id="hidden_user_email2" value="user_email" style="display: none;" autocomplete="username email">
                            <input type="password" name="disp_new_pass" id="disp_new_pass" value="password" style="width: 100px;" autocomplete="current-password" readonly><br>
                        </form>
                    </div>
                    <div class="ml-auto p-2">
                        <button type="button" class="btn btn-success mb-4" data-toggle="modal" data-target="#ChangePassword">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 
    <div class="row">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Recovery Info</h1>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="d-flex">
                    <div class="p-2">
                        <label for="Remail">Recovery Email :</label>
                    </div>
                    <div class="p-2">
                        <label name="Remail" id="disp_r_email"></label>
                    </div>
                    <div class="ml-auto p-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#ChangeRecoveryEmail">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</div>

</div>
<!-- End of Main Content -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
function NewPass() {
    var x = document.getElementById("new_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function cPass() {
    var x = document.getElementById("retype_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function oldPass() {
    var x = document.getElementById("old_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<script>
    // HttpRequest Data
    const sendHttpRequest = (method, url, data) => {
        const promise = new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            if(data){
                xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhr.responseType = "text";
            }
            xhr.onload = () => {
                if (xhr.status >= 400){
                    reject(xhr.response);
                }
                resolve(xhr.responseText);
            };
            xhr.onerror = () => {
                reject('Error');
            };
            xhr.send(data);
        });
        return promise;
    };

    // POST
    const sendData = (data, url, urlOpt) => {
        let res = "";
        switch(urlOpt){
            case 1:
                document.querySelector('#new_account_name').value = "";
                $('#ChangeName').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Changing Account Name. Please wait...";
                break;
            case 2:
                document.querySelector('#new_email').value = "";
                $('#ChangeEmail').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Changing Account Email. Please wait...";
                break;
            case 3:
                document.querySelector('#new_phone_num').value = "";
                $('#ChangePhone').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Changing Account Phone Number. Please wait...";
                break;
            case 4:
                document.querySelector('#new_pass').value = "";
                document.querySelector('#retype_pass').value = "";
                $('#ChangePassword').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Changing Account Password. Please wait...";
                break;
            case 5:
                document.querySelector('#new_r_email').value = "";
                $('#ChangeRecoveryEmail').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Changing Account Recovery Email. Please wait...";
                break;
            default:
                break;
        }
        document.querySelector('#LoadModalTitle').innerHTML = "Accounts Management";
        $('#LoadModal').modal('show');
        sendHttpRequest('POST', url, data).then(responseData => {
            res = `${responseData}`;
            setTimeout(function () {
                switch(urlOpt){
                    case 1:
                        document.querySelector('#disp_account_name').innerHTML = res;
                        document.querySelector('#old_account_name').value = res;
                        document.querySelector('#header_account_name').innerHTML = res;
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Account Name Changed Successfully";
                        $('#MsgboxModal').modal('show');
                        break;
                    case 2:
                        document.querySelector('#disp_email').innerHTML = res;
                        document.querySelector('#old_email').value = res;
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Account Email Changed Successfully";
                        $('#MsgboxModal').modal('show');
                        break;
                    case 3:
                        document.querySelector('#disp_phone_num').innerHTML = res;
                        document.querySelector('#old_phone_num').value = res;
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Account Phone Number Changed Successfully";
                        $('#MsgboxModal').modal('show');
                        break;
                    case 4:
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Account Password Changed Successfully";
                        $('#MsgboxModal').modal('show');
                        break;
                    case 5:
                        document.querySelector('#disp_r_email').innerHTML = res;
                        document.querySelector('#old_r_email').value = res;
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Account Recovery Email Changed Successfully";
                        $('#MsgboxModal').modal('show');
                        break;
                    default:
                        break;
                }
            },500);
        }).catch(err => {
            console.log(err);
        });
    };

    // HttpRequest Data File Upload
    const uploadHttpRequest = (method, url) => {
        const promise = new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            let form_change_photo = document.querySelector("#form_change_photo");
            var formdata = new FormData(form_change_photo);
            xhr.open(method, url, true);
            xhr.onload = () => {
                if (xhr.status >= 400){
                    reject(xhr.response);
                }
                resolve(xhr.response);
            };
            xhr.onerror = () => {
                reject('Error');
            };
            xhr.send(formdata);
        });
        return promise;
    };

    // POST File Upload
    const uploadData = (url) => {
        $('#ChangePhoto').modal('hide');
        document.querySelector('#LoadModalBody').innerHTML = "Changing Account Profile Picture. Please wait...";
        document.querySelector('#LoadModalTitle').innerHTML = "Accounts Management";
        $('#LoadModal').modal('show');
        uploadHttpRequest('POST', url).then(responseData => {
            setTimeout(function () {
                if (url == "../controllers/admin/acct_info_change_photo.php") {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                    document.querySelector('#MsgboxModalBody').innerHTML = responseData;
                    $('#MsgboxModal').modal('show');
                    refresh_account_photo();
                }
            },500);
        }).catch(err => {
            console.log(err);
        });
    };

    // GET
    const getData = (url, html_el_id) => {
        sendHttpRequest('GET', url).then(responseData => {
            createElementFromHTML(responseData, html_el_id);
        });
    };

    // append html element and text
    const createElementFromHTML = (htmlString, html_el_id) => {
        var parentNode = document.querySelector(`${html_el_id}`);
        parentNode.innerHTML = htmlString.trim();

        // Change this to div.childNodes to support multiple top-level nodes
        return parentNode.firstChild;
    }

    getData("../controllers/admin/acct_info_load_photo.php", "#disp_account_photo");

    const refresh_account_photo = () => {
        getData("../controllers/admin/acct_info_load_photo.php", "#disp_account_photo");
    }

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validateName(name) {
        const re = /^[A-Za-z\s]+$/;
        return re.test(name);
    }

    function validatePhoneNumber(number) {
        const re = /^[0-9]{11}$/;
        return re.test(number);
    }

    let current_account_name = "<?php echo $account_name; ?>";
    let current_dept_name = "<?php echo $dept_name; ?>";
    let current_email = "<?php echo $email; ?>";
    let current_phone_num = "<?php echo $cellphone_number; ?>";
    let current_r_email = "<?php echo $r_email; ?>";

    document.getElementById('disp_account_name').innerHTML = current_account_name;
    document.getElementById('disp_dept_name').innerHTML = current_dept_name;
    document.getElementById('disp_email').innerHTML = current_email;
    document.getElementById('disp_phone_num').innerHTML = current_phone_num;
    //document.getElementById('disp_r_email').innerHTML = current_r_email;

    document.getElementById('old_account_name').value = current_account_name;
    document.getElementById('old_email').value = current_email;
    document.getElementById('old_phone_num').value = current_phone_num;
    document.getElementById('old_r_email').value = current_r_email;

    const change_name = document.querySelector('#change_name');
    const change_photo = document.querySelector('#change_photo');
    const change_email = document.querySelector('#change_email');
    const change_phone_num = document.querySelector('#change_phone_num');
    const change_pass = document.querySelector('#change_pass');
    const change_r_email = document.querySelector('#change_r_email');

    change_name.addEventListener('click', () => {
        var urlOpt = 1;
        var account_name = document.querySelector('#new_account_name').value;
        if (account_name == '') {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new account name";
            $('#MsgboxModal').modal('show');
        } else if (account_name.length < 2) {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Account Name should at least 2 or more characters";
            $('#MsgboxModal').modal('show');
        } else if (!validateName(account_name)) {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Only letters and white space allowed";
            $('#MsgboxModal').modal('show');
        } else {
            var data = `account_name=${account_name}`;
            sendData(data, "../controllers/admin/acct_info_name.php", urlOpt);
        }
    })
    change_photo.addEventListener('click', () => {
        let account_photo = document.querySelector("#upload_photo").files[0];
        if (account_photo) {
            uploadData("../controllers/admin/acct_info_change_photo.php");
        } else {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please upload a profile picture";
            $('#MsgboxModal').modal('show');
        }
    })
    change_email.addEventListener('click', () => {
        var urlOpt = 2;
        var email = document.querySelector('#new_email').value;
        if (email == '') {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new account email";
            $('#MsgboxModal').modal('show');
        } else if (!validateEmail(email)) {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Invalid Email Format";
            $('#MsgboxModal').modal('show');
        } else {
            var data = `email=${email}`;
            sendData(data, "../controllers/admin/acct_info_email.php", urlOpt);
        }
    })
    change_phone_num.addEventListener('click', () => {
        var urlOpt = 3;
        var phone_num = document.querySelector('#new_phone_num').value;
        if (phone_num == '') {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new account phone number";
            $('#MsgboxModal').modal('show');
        } else if (!validatePhoneNumber(phone_num)) {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Invalid Phone Number Format";
            $('#MsgboxModal').modal('show');
        } else {
            var data = `cellphone_number=${phone_num}`;
            sendData(data, "../controllers/admin/acct_info_cellnum.php", urlOpt);
        }
    })
    change_pass.addEventListener('click', () => {
        var urlOpt = 4;
        let old_pass = document.querySelector('#old_pass').value;
        let new_pass = document.querySelector('#new_pass').value;
        let retype_pass = document.querySelector('#retype_pass').value;
        var data = `old_pass=${old_pass}&new_pass=${new_pass}`;
        if (old_pass != '') {
            if (new_pass != '') {
                if (retype_pass == new_pass) {
                    if (old_pass != new_pass) {
                        sendData(data, "../controllers/admin/acct_info_changepass.php", urlOpt);
                        document.getElementById("old_pass").value = '';
                        document.getElementById("new_pass").value = '';
                        document.getElementById("retype_pass").value = '';
                    } else {
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "No changes where made! Please try again";
                        $('#MsgboxModal').modal('show');
                    }
                } else {
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                    document.querySelector('#MsgboxModalBody').innerHTML = "New password not match to retype password! Please try again";
                    $('#MsgboxModal').modal('show');
                }
            } else {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new password";
                $('#MsgboxModal').modal('show');
            }
        } else {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your old password";
            $('#MsgboxModal').modal('show');
        }
    })
    change_r_email.addEventListener('click', () => {
        var urlOpt = 5;
        var r_email = document.querySelector('#new_r_email').value;
        if (r_email == '') {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new account recovery email";
            $('#MsgboxModal').modal('show');
        } else if (!validateEmail(r_email)) {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Invalid Email Format";
            $('#MsgboxModal').modal('show');
        } else {
            var data = `r_email=${r_email}`;
            sendData(data, "../controllers/admin/acct_info_r_email.php", urlOpt);
        }
    })
</script>

<!-- Bootstrap core JavaScript-->
<?php include('footer.php'); ?>
