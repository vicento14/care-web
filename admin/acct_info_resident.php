<?php
include("header.php");
if ($_SESSION['dept_id'] != 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Residents</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Account Modal -->
    <div class="modal fade" id="insertAccountModal" tabindex="-1" role="dialog" aria-labelledby="insertAccountModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertAccountModalTitle">Add Residents Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="i_user_email">Email :</label>
                            <input type="email" id="i_user_email" name="i_user_email" placeholder="Email" maxlength="320">
                        </p>
                        <p>
                            <label for="i_account_name">Account Name :</label>
                            <input type="textbox" id="i_account_name" name="i_account_name" placeholder="Account Name" maxlength="255">
                        </p>
                        <p>
                            <label for="Barangay">Barangays</label>
                            <select name="Barangay" id="brgy_id_1">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="insert_resident">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Verify Account Modal -->
    <div class="modal fade" id="verifyAccountModal" tabindex="-1" role="dialog" aria-labelledby="verifyAccountModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyAccountModal">Verify Resident Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="vy_account_id">Account ID :</label>
                            <label name="vy_account_id" id="vy_account_id">AC-000000001</label>
                        </p>
                        <p> <label for="vy_user_id">User ID :</label>
                            <label name="vy_user_id" id="vy_user_id">AD00001</label>
                        </p>
                        <p>
                            <label for="vy_user_email">Email :</label>
                            <label for="vy_user_email" id="vy_user_email">Juan Delacruz</label>
                        </p>
                        <p id="valid_id"></p>
                    </form>
                    <p id="verify_valid_id_info"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="reject_valid_id" data-dismiss="modal">Reject</button>
                    <button type="button" class="btn btn-success" id="verify_valid_id" data-dismiss="modal">Verify</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Account Info Modal -->
    <div class="modal fade" id="viewAccountInfoModal" tabindex="-1" role="dialog" aria-labelledby="viewAccountInfoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAccountInfoModal">View Account Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="v_account_id">Account ID :</label>
                            <label name="v_account_id" id="v_account_id">AC-000000001</label>
                        </p>
                        <p> <label for="v_user_id">User ID :</label>
                            <label name="v_user_id" id="v_user_id">AD00001</label>
                        </p>
                        <p>
                            <label for="v_user_email">Email :</label>
                            <label for="v_user_email" id="v_user_email">Juan Delacruz</label>
                        </p>
                        <p>
                            <label for="Brgy">Barangay :</label>
                            <label for="Brgy" id="v_brgy_name">San Juan</label>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Account Info Modal -->
    <div class="modal fade" id="updateAccountInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateAccountInfoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAccountInfoModal">Edit Account Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="u_account_id">Account ID :</label>
                            <label name="u_account_id" id="u_account_id">AC-000000001</label>
                        </p>
                        <p> 
                            <label for="u_user_id">User ID :</label>
                            <label name="u_user_id" id="u_user_id">AD00001</label>
                        </p>
                        <p>
                            <label for="u_user_email">Email :</label>
                            <input type="email" id="u_user_email" name="u_user_email" value="user_email" maxlength="320">
                        </p>
                        <p>
                            <label for="u_account_name">Account Name :</label>
                            <input type="textbox" id="u_account_name" name="u_account_name" value="Account Name" maxlength="255">
                        </p>
                        <p>
                            <label for="Barangay">Barangays</label>
                            <select name="Barangay" id="brgy_id_2">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="update_resident">Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Pass Modal -->
    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePassModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePassModal">Change Resident Account Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="text" name="hidden_user_email1" id="hidden_user_email1" value="user_email" style="display: none;" autocomplete="username email">
                        <p>
                            <label for="cp_account_id">Account ID :</label>
                            <label name="cp_account_id" id="cp_account_id">AC-000000001</label>
                        </p>
                        <p>
                            <label for="cp_user_id">User ID :</label>
                            <label name="cp_user_id" id="cp_user_id">AD00001</label>
                        </p>
                        <p>
                            <label for="cp_new_pass">New Password</label>
                            <input type="password" id="cp_new_pass" name="cp_new_pass" placeholder="New Password" autocomplete="new-password" maxlength="255">
                        </p>
                        <p>
                            <label for="cp_retype_pass">Retype Password</label>
                            <input type="password" id="cp_retype_pass" name="cp_retype_pass" placeholder="Retype Password" autocomplete="new-password" maxlength="255">
                        </p>
                        <p>
                            <input type="checkbox" id="cp_retype_pass_chkbx" onclick="cPass()">
                            <label for="cp_retype_pass_chkbx">Show Password</label>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="update_resident_pass">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_account_id" id="del_account_id">
                    <p>Are you sure you want to delete this Record?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" id="delete_resident" value="Delete" name="Delete">
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1 class="h3 mb-0 text-gray-800">Residents Accounts Table</h1>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshAccountTable">Refresh <i class="fas fa-sync-alt"></i></button>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="insertAccount" data-toggle="modal" data-target="#insertAccountModal">Add Accounts <i class="fas fa-plus"></i></button>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Account ID</th>
                            <th style="text-align: center;">User ID</th>
                            <th style="text-align: center;">Account Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Barangay ID</th>
                            <th style="text-align: center;">Barangay Name</th>
                            <th style="text-align: center;">Verification Status</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>12345</td>
                            <td>12345</td>
                            <td>Account Name</td>
                            <td>User</td>
                            <td>12345</td>
                            <td>Brgy Name</td>
                            <td>Status</td>
                            <td>
                                <!-- Actions Button -->
                                <div class="dropdown no-arrow container" style="text-align:center">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                        <!-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> -->
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Actions</div>
                                        <a class="dropdown-item newStyle" href="#" data-toggle="modal" data-target="#verifyAccountModal">Verify Account</a>
                                        <a class="dropdown-item newStyle" href="#" data-toggle="modal" data-target="#viewAccountInfoModal">View Account Info</a>
                                        <a class="dropdown-item newStyle" href="#" data-toggle="modal" data-target="#updateAccountInfoModal">Edit Account Info</a>
                                        <a class="dropdown-item newStyle" href="#" data-toggle="modal" data-target="#changePassModal">Change Password</a>
                                        <a class="dropdown-item newStyle" href="#" data-toggle="modal" data-target="#DeletePHP">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- inserted for assurance -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>

<script>
function cPass() {
    var x = document.getElementById("cp_new_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    var y = document.getElementById("cp_retype_pass");
    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
}
</script>

<script>
    let account_id, del_account_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/acct_info_resident_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "account_id"},
                {"data": "user_id"},
                {"data": "account_name"},
                {"data": "user_email"},
                {"data": "barangay_id"},
                {"data": "barangay_name"},
                {"data": "verification_status"},
                {
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": `<div class="dropdown no-arrow container" style="text-align:center">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Actions</div>
                                                <a class="dropdown-item newStyle" id="verifyAccount" href="#" data-toggle="modal" data-target="#verifyAccountModal">Verify Account</a>
                                                <a class="dropdown-item newStyle" id="viewAccountInfo" href="#" data-toggle="modal" data-target="#viewAccountInfoModal">View Account Info</a>
                                                <a class="dropdown-item newStyle" id="updateAccountInfo" href="#" data-toggle="modal" data-target="#updateAccountInfoModal">Edit Account Info</a>
                                                <a class="dropdown-item newStyle" id="changePassword" href="#" data-toggle="modal" data-target="#changePassModal">Change Password</a>
                                                <a class="dropdown-item newStyle" id="deleteAccount" href="#" data-toggle="modal" data-target="#deleteAccountModal">Delete Account</a>
                                            </div>
                                        </div>`
                }
            ],
            "order": [[ 1, 'asc' ]]
        });
        
    });

    // HttpRequest Data
    const sendHttpRequest = (method, url, data) => {
        const promise = new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.responseType = "text";
            if(data){
                xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
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

    // GET
    const getData = (url, html_el_id) => {
        sendHttpRequest('GET', url).then(responseData => {
            createElementFromHTML(responseData, html_el_id);
        });
    };

    // POST
    const sendData = (data, url) => {
        sendHttpRequest('POST', url, data).then(responseData => {
            if(url == "../controllers/admin/acct_info_resident_load_valid.php"){
                let response_array = JSON.parse(responseData);
                createElementFromHTML(response_array.data, "#valid_id");
                if (response_array.has_valid_id != 0) {
                    if (response_array.is_verified != 0) {
                        let verify_message = `This resident account has been verified`
                        document.getElementById("verify_valid_id").disabled = true;
                        document.getElementById("reject_valid_id").disabled = true;
                        createElementFromHTML(verify_message, "#verify_valid_id_info");
                    } else {
                        let verify_message = `<p>Please check the valid ID carefully. The address should be located at this municipality.</p>
                        <p>Verifying this resident account is only done once.</p>
                        <p>The resident will try sending another valid ID if reject option was chosen.</p>
                        <p class="text-warning">
                            <small>This action cannot be undone if the account was verified.</small>
                        </p>`
                        document.getElementById("verify_valid_id").disabled = false;
                        document.getElementById("reject_valid_id").disabled = false;
                        createElementFromHTML(verify_message, "#verify_valid_id_info");
                    }
                } else {
                    let verify_message = `This resident account cannot be verify without a valid ID`
                    document.getElementById("verify_valid_id").disabled = true;
                    document.getElementById("reject_valid_id").disabled = true;
                    createElementFromHTML(verify_message, "#verify_valid_id_info");
                }
            }
        });
    };

    // append html element and text
    const createElementFromHTML = (htmlString, html_el_id) => {
        var parentNode = document.querySelector(`${html_el_id}`);
        parentNode.innerHTML = htmlString.trim();

        // Change this to div.childNodes to support multiple top-level nodes
        return parentNode.firstChild;
    }

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validateName(name) {
        const re = /^[A-Za-z\s]+$/;
        return re.test(name);
    }
    
    getData("../controllers/admin/brgy_dropdown.php", "#brgy_id_1");
    getData("../controllers/admin/brgy_dropdown.php", "#brgy_id_2");

    // Insert/Update single record post function
    const insert_update_resident = (url, opt) => {
        let user_email, account_name, data;
        let is_null = 0;
        if (opt == 0) {
            user_email = $.trim($('#i_user_email').val());
            account_name = $.trim($('#i_account_name').val());
            brgy_opt = document.querySelector("#brgy_id_1");
            brgy_id = brgy_opt.options[brgy_opt.selectedIndex].value;
            if (user_email == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the email";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (!validateEmail(user_email)) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Invalid Email Format";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (account_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the account name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (account_name.length < 2) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Account Name should at least 2 or more characters";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (!validateName(account_name)) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Only letters and white space allowed";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (brgy_id == 0) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please choose a barangay. Note: You can't add new resident account when barangay table is empty";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {user_email:user_email, account_name:account_name, barangay_id:brgy_id};
                $("#i_user_email").val(null);
                $("#i_account_name").val(null);
                document.getElementById('brgy_id_1').getElementsByTagName('option')[0].selected = 'selected';
                $('#insertAccountModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Adding New Resident Account. Please wait...";
            }
        } else {
            account_id = $.trim($('#u_account_id').text());
            user_email = $.trim($('#u_user_email').val());
            account_name = $.trim($('#u_account_name').val());
            brgy_opt = document.querySelector("#brgy_id_2");
            brgy_id = brgy_opt.options[brgy_opt.selectedIndex].value;
            if (user_email == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the email";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (!validateEmail(user_email)) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Invalid Email Format";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (account_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the account name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (account_name.length < 2) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Account Name should at least 2 or more characters";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (!validateName(account_name)) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Accounts Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Only letters and white space allowed";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else if (brgy_id == 0) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please choose a barangay";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {account_id:account_id, user_email:user_email, account_name:account_name, barangay_id:brgy_id};
                $("#u_account_id").text(null);
                $("#u_user_id").text(null);
                $("#u_user_email").val(null);
                $("#u_account_name").val(null);
                document.getElementById('brgy_id_2').getElementsByTagName('option')[0].selected = 'selected';
                $('#updateAccountInfoModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Saving Resident Account Information. Please wait...";
            }
        }
        if (is_null == 0) {
            $.ajax({
                url: url,
                type: "POST",
                datatype:"json",
                data:  data,
                beforeSend: function () {
                    document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                    $('#LoadModal').modal('show');
                }, 
                success: function(result) {
                    if (opt == 0) {
                        let folder_name = result;
                        let folder_role = 1;
                        data = {folder_name:folder_name, folder_role:folder_role};
                        insert_resident_upload_folder("../controllers/admin/acct_create_folder.php", data);
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Resident Account Added Successfully";
                    } else {
                        document.querySelector('#MsgboxModalBody').innerHTML = "Resident Account Information Saved Successfully";
                        table.ajax.reload(null, false);
                    }
                }
            }).done(function () {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                    $('#MsgboxModal').modal('show');
                },500);
            });
        }
    }

    const insert_resident_upload_folder = (url, data) => {
        $.ajax({
            url: url,
            type: "POST",
            datatype:"json",
            data: data,
            success: function(result) {
                table.ajax.reload(null, false);
            }
        });
    }

    // Verify account post function
    $(document).on("click", "#verify_valid_id", () => {
        $.ajax({
            url: "../controllers/admin/acct_info_resident_verify.php",
            type: "POST",
            datatype:"json",
            data:  {account_id:account_id},
            beforeSend: function () {
                $('#verifyAccountModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                document.querySelector('#LoadModalBody').innerHTML = "Verifying Resident Account Valid ID. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Resident Account Valid ID Verified Successfully";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Reject valid id post function
    $(document).on("click", "#reject_valid_id", () => {
        $.ajax({
            url: "../controllers/admin/acct_info_resident_reject.php",
            type: "POST",
            datatype:"json",
            data:  {account_id:account_id},
            beforeSend: function () {
                $('#verifyAccountModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                document.querySelector('#LoadModalBody').innerHTML = "Rejecting Resident Account Valid ID. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Resident Account Valid ID Rejected Successfully";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Insert single record post function
    $("#insert_resident").click(() => {insert_update_resident("../controllers/admin/acct_info_resident_insert.php", 0)});

    // Update single record post function
    $("#update_resident").click(() => {insert_update_resident("../controllers/admin/acct_info_resident_update.php", 1)});

    // Change Password post function
    $(document).on("click", "#update_resident_pass", () => {
        account_id = $.trim($('#cp_account_id').text());
        let new_pass = $.trim($('#cp_new_pass').val());
        let retype_pass = $.trim($('#cp_retype_pass').val());
        if (new_pass != '') {
            if (retype_pass == new_pass) {
                $('#changePassModal').modal('hide');
                $.ajax({
                    url: "../controllers/admin/acct_info_resident_changepass.php",
                    type: "POST",
                    datatype:"json",
                    data:  {account_id:account_id, new_pass:new_pass},
                    beforeSend: function () {
                        document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                        document.querySelector('#LoadModalBody').innerHTML = "Saving New Resident Account Password. Please wait...";
                        $('#LoadModal').modal('show');
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                    }
                }).done(function () {
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Resident Account Password Saved Successfully";
                        $('#MsgboxModal').modal('show');
                    },500);
                });
            } else {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "New password not match to retype password! Please try again";
                $('#MsgboxModal').modal('show');
            }
        } else {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your new password";
            $('#MsgboxModal').modal('show');
        }
    });

    // Delete single record post function
    $(document).on("click", "#delete_resident", () => {
        $.ajax({
            url: "../controllers/admin/acct_info_resident_delete.php",
            type: "POST",
            datatype:"json",
            data:  {account_id:account_id},
            beforeSend: function () {
                $('#deleteAccountModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Resident Account Password. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Resident Account Deleted Successfully";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Insert single record modal
    $("#insertAccount").click(function() {
        account_id = null;
        let user_email = null;
        let account_name = null;
        $("#i_user_email").val(user_email);
        $("#i_account_name").val(account_name);
    });

    // Verify account modal
    $(document).on("click", "#verifyAccount", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let data = `account_id=${account_id}`;
        sendData(data, "../controllers/admin/acct_info_resident_load_valid.php");
        let user_id = row.find('td:eq(1)').text();
        let user_email = row.find('td:eq(3)').text();
        $("#vy_account_id").text(account_id);
        $("#vy_user_id").text(user_id);
        $("#vy_user_email").text(user_email);
    });
    
    // View single record modal
    $(document).on("click", "#viewAccountInfo", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let user_id = row.find('td:eq(1)').text();
        let account_name = row.find('td:eq(2)').text();
        let user_email = row.find('td:eq(3)').text();
        let brgy_name = row.find('td:eq(5)').text();
        $("#v_account_id").text(account_id);
        $("#v_user_id").text(user_id);
        $("#v_account_name").text(account_name);
        $("#v_user_email").text(user_email);
        $("#v_brgy_name").text(brgy_name);
    });

    // Update single record modal
    $(document).on("click", "#updateAccountInfo", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let user_id = row.find('td:eq(1)').text();
        let account_name = row.find('td:eq(2)').text();
        let user_email = row.find('td:eq(3)').text();
        let brgy_id = row.find('td:eq(4)').text();
        $("#u_account_id").text(account_id);
        $("#u_user_id").text(user_id);
        $("#u_account_name").val(account_name);
        $("#u_user_email").val(user_email);
        $("#brgy_id_2").val(brgy_id);
    });

    // Change Pass modal
    $(document).on("click", "#changePassword", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let user_id = row.find('td:eq(1)').text();
        let new_pass = null;
        let retype_pass = null;
        $("#cp_account_id").text(account_id);
        $("#cp_user_id").text(user_id);
        $("#cp_new_pass").val(new_pass);
        $("#cp_retype_pass").val(retype_pass);
    });
    
    // Delete single record
    $(document).on("click", "#deleteAccount", function(){
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
    });
    
    // Refresh
    $('#refreshAccountTable').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php
}
include('footer.php');
?>
