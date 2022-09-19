<?php
include("header.php");
if ($_SESSION['dept_id'] != 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | LGU Office Staff</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Account Modal -->
    <div class="modal fade" id="insertAccountModal" tabindex="-1" role="dialog" aria-labelledby="insertAccountModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertAccountModalTitle">Add Department Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="i_user_email">Email</label>
                            <input type="email" id="i_user_email" name="i_user_email" placeholder="Email" maxlength="320">
                        </p>
                        <p>
                            <label for="i_account_name">Account Name</label>
                            <input type="textbox" id="i_account_name" name="i_account_name" placeholder="Account Name" maxlength="255">
                        </p>
                        <p>
                            <label for="Department">Department</label>
                            <select name="Department" id="dept_id_1">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="insert_deptadmin">Add</button>
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
                            <label for="ACCID">Account ID :</label>
                            <label name="ACCID" id="v_account_id">AC-000000001</label>
                        </p>
                        <p>
                            <label for="ADID">Admin ID :</label>
                            <label  name="ADID" id="v_admin_id">AD00001</label>
                        </p>
                        <p>
                            <label for="user">Email :</label>
                            <label for="user" id="v_user_email">Juan Delacruz</label>
                        </p>
                        <p>
                            <label for="Acc">Account Name :</label>
                            <label name="Acc" id="v_account_name">Juan Delacruz</label>
                        </p>
                        <p>
                            <label for="Dept">Department :</label>
                            <label for="Dept" id="v_dept_name">President</label>
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
                            <label for="u_admin_id">Admin ID :</label>
                            <label name="u_admin_id" id="u_admin_id">AD00001</label>
                        </p>
                        <p>
                            <label for="u_user_email">Email :</label>
                            <input type="email" id="u_user_email" name="u_user_email" placeholder="user_email" maxlength="320">
                        </p>
                        <p>
                            <label for="u_account_name">Account Name :</label>
                            <input type="textbox" id="u_account_name" name="u_account_name" placeholder="Account Name" maxlength="255">
                        </p>
                        <p>
                            <label for="Department">Department :</label>
                            <select name="Department" id="dept_id_2">
                                <hr class="sidebar-divider">
                                <option value="President">President</option>
                                <option value="sample-1">.....</option>
                                <option value="sample-2">......</option>
                                <option value="sample-3">.....</option>
                            </select>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="update_deptadmin">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Pass Modal -->
    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePassModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePassModal">Change Department Admin Account Password</h5>
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
                            <label for="cp_admin_id">Admin ID :</label>
                            <label name="cp_admin_id" id="cp_admin_id">AD00001</label>
                        </p>
                        <p>
                            <label for="cp_new_pass">New Password :</label>
                            <input type="password" id="cp_new_pass" name="cp_new_pass" placeholder="New Password" autocomplete="new-password" maxlength="255">
                        </p>
                        <p>
                            <label for="cp_retype_pass">Retype Password :</label>
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
                    <button type="button" class="btn btn-success" id="update_deptadmin_pass">Save</button>
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
                    <input type="submit" class="btn btn-danger" id="delete_deptadmin" value="Delete" name="Delete">
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1 class="h3 mb-0 text-gray-800">Department Admin Accounts Table</h1>
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
                            <th style="text-align: center;">Admin ID</th>
                            <th style="text-align: center;">Account Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Dept ID</th>
                            <th style="text-align: center;">Dept Name</th>
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
                            <td>President</td>
                            <td>
                            <!-- Actions Button -->
                            <div class="dropdown no-arrow container" style="text-align:center">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Actions</div>
                                        <a class="dropdown-item newStyle" id="viewAccountInfo" href="#" data-toggle="modal" data-target="#viewAccountInfoModal" >View Account Info</a>
                                        <a class="dropdown-item newStyle" id="updateAccountInfo" href="#" data-toggle="modal" data-target="#updateAccountInfoModal" >Edit Account Info</a>
                                        <a class="dropdown-item newStyle" id="changePassword" href="#" data-toggle="modal" data-target="#changePassModal" >Change Password</a>
                                        <a class="dropdown-item newStyle" id="deleteAccount" href="#" data-toggle="modal" data-target="#deleteAccountModal" >Delete</a>
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
                "url": "../controllers/admin/acct_info_deptadmin_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "account_id"},
                {"data": "admin_id"},
                {"data": "account_name"},
                {"data": "user_email"},
                {"data": "dept_id"},
                {"data": "dept_name"},
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
    
    getData("../controllers/admin/dept_dropdown.php", "#dept_id_1");
    getData("../controllers/admin/dept_dropdown.php", "#dept_id_2");

    // Insert/Update single record post function
    const insert_update_deptadmin = (url, opt) => {
        let user_email, account_name, dept_opt, dept_id, data;
        let is_null = 0;
        if (opt == 0) {
            user_email = $.trim($('#i_user_email').val());
            account_name = $.trim($('#i_account_name').val());
            dept_opt = document.querySelector("#dept_id_1");
            dept_id = dept_opt.options[dept_opt.selectedIndex].value;
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
            } else if (dept_id == 0) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please choose a department. Note: You can't add new department admin account when department table is empty";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {user_email:user_email, account_name:account_name, dept_id:dept_id};
                $("#i_user_email").val(null);
                $("#i_account_name").val(null);
                document.getElementById('dept_id_1').getElementsByTagName('option')[0].selected = 'selected';
                $('#insertAccountModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Adding New Department Admin Account. Please wait...";
            }
        } else {
            account_id = $.trim($('#u_account_id').text());
            user_email = $.trim($('#u_user_email').val());
            account_name = $.trim($('#u_account_name').val());
            dept_opt = document.querySelector("#dept_id_2");
            dept_id = dept_opt.options[dept_opt.selectedIndex].value;
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
            } else if (dept_id == 0) {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please choose a department";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {account_id:account_id, user_email:user_email, account_name:account_name, dept_id:dept_id};
                $("#u_account_id").text(null);
                $("#u_admin_id").text(null);
                $("#u_user_email").val(null);
                $("#u_account_name").val(null);
                document.getElementById('dept_id_2').getElementsByTagName('option')[0].selected = 'selected';
                $('#updateAccountInfoModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Saving Department Admin Account Information. Please wait...";
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
                        let folder_role = 0;
                        data = {folder_name:folder_name, folder_role:folder_role};
                        insert_deptadmin_upload_folder("../controllers/admin/acct_create_folder.php", data);
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Department Admin Account Added Successfully";
                    } else {
                        document.querySelector('#MsgboxModalBody').innerHTML = "Department Admin Account Information Saved Successfully";
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

    const insert_deptadmin_upload_folder = (url, data) => {
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

    // Insert single record post function
    $("#insert_deptadmin").click(() => {insert_update_deptadmin("../controllers/admin/acct_info_deptadmin_insert.php", 0)});

    // Update single record post function
    $("#update_deptadmin").click(() => {insert_update_deptadmin("../controllers/admin/acct_info_deptadmin_update.php", 1)});

    // Change Password post function
    $(document).on("click", "#update_deptadmin_pass", () => {
        account_id = $.trim($('#cp_account_id').text());
        let new_pass = $.trim($('#cp_new_pass').val());
        let retype_pass = $.trim($('#cp_retype_pass').val());
        if (new_pass != '') {
            if (retype_pass == new_pass) {
                $('#changePassModal').modal('hide');
                $.ajax({
                    url: "../controllers/admin/acct_info_deptadmin_changepass.php",
                    type: "POST",
                    datatype:"json",
                    data:  {account_id:account_id, new_pass:new_pass},
                    beforeSend: function () {
                        document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                        document.querySelector('#LoadModalBody').innerHTML = "Saving New Department Admin Account Password. Please wait...";
                        $('#LoadModal').modal('show');
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                    }
                }).done(function () {
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Department Admin Account Password Saved Successfully";
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
    $(document).on("click", "#delete_deptadmin", () => {
        $.ajax({
            url: "../controllers/admin/acct_info_deptadmin_delete.php",
            type: "POST",
            datatype:"json",
            data:  {account_id:account_id},
            beforeSend: function () {
                $('#deleteAccountModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Account Management";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Department Admin Account. Please wait...";
                $('#LoadModal').modal('show');
            },
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Account Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Department Admin Account Deleted Successfully";
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
    
    // View single record modal
    $(document).on("click", "#viewAccountInfo", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let admin_id = row.find('td:eq(1)').text();
        let account_name = row.find('td:eq(2)').text();
        let user_email = row.find('td:eq(3)').text();
        let dept_name = row.find('td:eq(5)').text();
        $("#v_account_id").text(account_id);
        $("#v_admin_id").text(admin_id);
        $("#v_dept_name").text(dept_name);
        $("#v_user_email").text(user_email);
        $("#v_account_name").text(account_name);
    });

    // Update single record modal
    $(document).on("click", "#updateAccountInfo", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let admin_id = row.find('td:eq(1)').text();
        let account_name = row.find('td:eq(2)').text();
        let user_email = row.find('td:eq(3)').text();
        let dept_id = row.find('td:eq(4)').text();
        $("#u_account_id").text(account_id);
        $("#u_admin_id").text(admin_id);
        $("#u_user_email").val(user_email);
        $("#u_account_name").val(account_name);
        $("#dept_id_2").val(dept_id);
    });

    // Change Pass modal
    $(document).on("click", "#changePassword", function() {
        row = $(this).closest("tr");
        account_id = parseInt(row.find('td:eq(0)').text());
        let admin_id = row.find('td:eq(1)').text();
        let new_pass = null;
        let retype_pass = null;
        $("#cp_account_id").text(account_id);
        $("#cp_admin_id").text(admin_id);
        $("#cp_new_pass").val(new_pass);
        $("#cp_retype_pass").val(retype_pass);
    });
    
    // Delete single record
    $(document).on("click", "#deleteAccount", function() {
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
