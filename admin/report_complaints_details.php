<?php
include('header.php');
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Complaint Details</title>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-end mb-4">
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="backReport"><i class="fas fa-arrow-left"></i> Back to Complaint Report</button>
    </div>

    <input type="hidden" name="transaction_id" id="transaction_id">

    <div class="row">

        <div class="col-xl-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-between">

                        <div class="col mr-2">
                            <p style="color:black; font-size: 34px;" id="report_name">Reporter Name</p>
                            <br>
                            <p>Report ID : <span id="report_id" > 0000000000000</span></p>
                            <p>User ID : <span id="user_id"> 0000000000000</span></p>
                            <p>Name : <span id="user_account_name"> 0000000000000</span></p>
                            <p>Barangay : <span id="barangay_name"> 0000000000000</span></p>
                            <p>Email : <span id="user_email"> 0000000000000</span></p>
                            <p>Contact Number : <span id="user_cellphone_number"> 0000000000000</span></p>
                        </div>

                        <div class="col-auto">
                            <p style="color:black; font-size: 34px;" id="transaction_end_date"> 4/3/21 8:00 AM</p>
                            <br>
                            <p>Department Involved : <span id="dept_name"> 0000000000000</span></p>
                            <p>Department Admin Involved : <span id="admin_name"> 0000000000000</span></p>
                            <p>Report Status : <span id="is_resolved"> 0000000000000</span></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-between">

                        <div class="col mr-2">
                            <p class="mb-4" style="color:black; font-size: 34px;">Details</p>
                            <textarea class="form-control" name="report_details" id="report_details" cols="100" rows="10"></textarea>
                        </div>

                        <div class="col-auto"></div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <p class="mb-4" style="color:black; font-size: 34px;">Uploads</p>
                    <div class="row" id="uploaded_files"></div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">

            <div class="card border-left-success shadow py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-between">
                        <div class="col mr-2">
                            <p class="mb-4" style="color:black; font-size: 34px;">Responses</p>
                        </div>
                    </div>
                </div>

                <div class="messaging">
                    <div class="inbox_msg">
                        <div class="inbox_people">
                            <div class="headind_srch">
                                <div class="card-header">
                                    <div class="d-inline-block" id="msg_user_account_name">
                                        <img src="../assets/img/noimage_person.png" class="rounded-circle" style="height:50px; width:50px;" alt="">
                                        Live Chat
                                    </div>
                                    <span class="d-inline-block btn float-right "></span>
                                </div>
                            </div>
                        </div>
                        <div class="mesgs">
                            <div class="msg_history" id="msg_history"></div>
                            <div class="type_msg">
                                <div class="input_msg_write">
                                    <input type="text" class="write_msg" id="report_response_details" placeholder="Type a message" />
                                    <button class="msg_send_btn" type="button" id="insert_report_response"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-4">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <div class="d-flex align-items-stretch">
                        <form action="#lock" method="post" class="form">
                            <input type="button" class="btn btn-success  ml-5 mb-4" id="lock_unlock_report_complaints" value="Lock">
                        </form>

                        <form action="#Mark" method="post" class="form">
                            <input type="button" class="btn btn-success  ml-5 mb-4" id="resolve_report_complaints"value="Mark as Resolved">
                        </form>

                        <form action="./report_print.php" method="post" target="_blank" class="form">
                            <input type="hidden" name="transaction_id_print" id="transaction_id_print">    
                            <input type="submit" class="btn btn-success  ml-5 mb-4" name="report_print" value="Print">
                        </form>

                        <form action="#Back" method="post" class="form">
                            <input type="button" class="btn btn-success  ml-5 mb-4" id="back_report_complaints" value="Back">
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
    const backReport = document.querySelector('#backReport');
    const lock_unlock_report_complaints = document.querySelector('#lock_unlock_report_complaints');
    const resolve_report_complaints = document.querySelector('#resolve_report_complaints');
    const back_report_complaints = document.querySelector('#back_report_complaints');
    const insert_report_response = document.querySelector('#insert_report_response');
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
                resolve(xhr.response);
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
        if (url == "../controllers/admin/report_complaints_lock_unlock.php") {
            document.querySelector('#LoadModalTitle').innerHTML = "Reports";
            document.querySelector('#LoadModalBody').innerHTML = "Changing Admin Involvement on Report. Please wait...";
            $('#LoadModal').modal('show');
        } else if (url == "../controllers/admin/report_complaints_resolve.php") {
            document.querySelector('#LoadModalTitle').innerHTML = "Reports";
            document.querySelector('#LoadModalBody').innerHTML = "Updating Report Status. Please wait...";
            $('#LoadModal').modal('show');
        }
        sendHttpRequest('POST', url, data).then(responseData => {
            if(url == "../controllers/admin/report_complaints_view.php"){
                let transaction_array = JSON.parse(responseData);
                document.getElementById("transaction_end_date").innerHTML = transaction_array.transaction_end_date;
                document.getElementById("report_name").innerHTML = transaction_array.report_name;
                document.getElementById("report_id").innerHTML = transaction_array.report_id;
                document.getElementById("user_id").innerHTML = transaction_array.user_id;
                document.getElementById("user_account_name").innerHTML = transaction_array.user_account_name;
                document.getElementById("barangay_name").innerHTML = transaction_array.barangay_name;
                document.getElementById("user_email").innerHTML = transaction_array.user_email;
                document.getElementById("user_cellphone_number").innerHTML = transaction_array.user_cellphone_number;
                document.getElementById("dept_name").innerHTML = transaction_array.dept_name;
                document.getElementById("admin_name").innerHTML = transaction_array.admin_name;
                document.getElementById("is_resolved").innerHTML = transaction_array.is_resolved;
                document.getElementById("report_details").value = transaction_array.report_details;
                document.getElementById("msg_user_account_name").innerHTML = `<img src='../assets/img/noimage_person.png' class='rounded-circle' style='height:50px; width:50px;' alt=''>${transaction_array.user_account_name}`;
                if (transaction_array.is_resolved == "pending") {
                    if (transaction_array.is_lock == 1) {
                        document.getElementById("resolve_report_complaints").disabled = false;
                        document.getElementById("lock_unlock_report_complaints").value = "Unlock";
                        document.getElementById("lock_unlock_report_complaints").disabled = false;
                        document.getElementById("report_response_details").disabled = false;
                        document.getElementById("insert_report_response").disabled = false;
                    } else if (transaction_array.is_lock == 2) {
                        document.getElementById("resolve_report_complaints").disabled = true;
                        document.getElementById("lock_unlock_report_complaints").value = "Lock";
                        document.getElementById("lock_unlock_report_complaints").disabled = false;
                        document.getElementById("report_response_details").disabled = true;
                        document.getElementById("insert_report_response").disabled = true;
                    }
                } else {
                    document.getElementById("resolve_report_complaints").disabled = true;
                    document.getElementById("lock_unlock_report_complaints").value = "Lock";
                    document.getElementById("lock_unlock_report_complaints").disabled = true;
                    document.getElementById("report_response_details").disabled = true;
                    document.getElementById("insert_report_response").disabled = true;
                }
                var current_dept_name = "<?php echo $_SESSION['dept_name'];?>";
                if (current_dept_name != transaction_array.dept_name) {
                    document.getElementById("resolve_report_complaints").disabled = true;
                    document.getElementById("lock_unlock_report_complaints").value = "Lock";
                    document.getElementById("lock_unlock_report_complaints").disabled = true;
                    document.getElementById("report_response_details").disabled = true;
                    document.getElementById("insert_report_response").disabled = true;
                }
            } else if (url == "../controllers/admin/report_complaints_lock_unlock.php") {
                let response_array = JSON.parse(responseData);
                if (response_array.response_msg == "success" && response_array.is_lock == 1) {
                    document.querySelector("#lock_unlock_report_complaints").value = "Unlock";
                    document.getElementById("resolve_report_complaints").disabled = false;
                    document.getElementById("report_response_details").disabled = false;
                    document.getElementById("insert_report_response").disabled = false;
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Reports";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Report Lock Successfully";
                        $('#MsgboxModal').modal('show');
                    },500);
                } else if (response_array.response_msg == "success" && response_array.is_lock == 0) {
                    document.querySelector("#lock_unlock_report_complaints").value = "Lock";
                    document.getElementById("resolve_report_complaints").disabled = true;
                    document.getElementById("report_response_details").disabled = true;
                    document.getElementById("insert_report_response").disabled = true;
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Reports";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Report Unlock Successfully";
                        $('#MsgboxModal').modal('show');
                    },500);
                } else {
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Reports";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Report Lock/Unlock Failed";
                        $('#MsgboxModal').modal('show');
                    },500);
                }
                refresh_report();
            } else if (url == "../controllers/admin/report_complaints_resolve.php") {
                if (responseData == "success") {
                    document.getElementById("resolve_report_complaints").disabled = true;
                    document.getElementById("lock_unlock_report_complaints").value = "Lock";
                    document.getElementById("lock_unlock_report_complaints").disabled = true;
                    document.getElementById("report_response_details").disabled = true;
                    document.getElementById("insert_report_response").disabled = true;
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Reports";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Report Status Saved Successfully";
                        $('#MsgboxModal').modal('show');
                    },500);
                } else {
                    setTimeout(function () {
                        $('#LoadModal').modal('hide');
                        document.querySelector('#MsgboxModalTitle').innerHTML = "Reports";
                        document.querySelector('#MsgboxModalBody').innerHTML = "Report Status Save Failed";
                        $('#MsgboxModal').modal('show');
                    },500);
                }
                refresh_report();
            } else if (url == "../controllers/admin/report_response_view.php") {
                createElementFromHTML(responseData, "#msg_history");
            } else if (url == "../controllers/admin/report_upload_view.php") {
                createElementFromHTML(responseData, "#uploaded_files");
            } else {
                let transaction_id = document.querySelector("#transaction_id").value;
                data = `transaction_id=${transaction_id}`;
                //sendData(data, "../controllers/admin/report_response_view.php");
            }
        }).catch(err => {
            console.log(err);
        });
    };

    // append html element and text
    const createElementFromHTML = (htmlString, html_el_id) => {
        var parentNode = document.querySelector(`${html_el_id}`);
        parentNode.innerHTML = htmlString.trim();

        // Change this to div.childNodes to support multiple top-level nodes
        return parentNode.firstChild;
    }

    const refresh_report = () => {
        document.querySelector("#transaction_id").value = transaction_id;
        let data = `transaction_id=${transaction_id}`;
        if (transaction_id != ''){
            sendData(data, "../controllers/admin/report_complaints_view.php");
            sendData(data, "../controllers/admin/report_response_view.php");
            sendData(data, "../controllers/admin/report_upload_view.php");
        } else {
            alert("Internal Error! the transaction id was not fetched");
        }
    }

    document.getElementById("lock_unlock_report_complaints").disabled = true;
    document.getElementById("resolve_report_complaints").disabled = true;
    document.getElementById("report_response_details").disabled = true;
    document.getElementById("insert_report_response").disabled = true;
    document.getElementById("report_details").readOnly = true;

    let transaction_id = window.localStorage.getItem("transaction_id");

    document.querySelector("#transaction_id").value = transaction_id;
    document.querySelector("#transaction_id_print").value = transaction_id;
    let data = `transaction_id=${transaction_id}`;
    if (transaction_id != ''){
        sendData(data, "../controllers/admin/report_complaints_view.php");
        sendData(data, "../controllers/admin/report_response_view.php");
        sendData(data, "../controllers/admin/report_upload_view.php");
    } else {
        alert("Internal Error! the transaction id was not fetched");
    }

    var pusher = new Pusher('8ff31fe73cdbafda41bc', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('care-app-143');
    channel.bind('user-response', function(data) {
        var report_response_sender_name = data["report_response_sender_name"];
        var report_response_details = data["report_response_details"];
        var date_responded = data["date_responded"];
        var transaction_id = data["transaction_id"];
        var current_transaction_id = document.querySelector("#transaction_id").value;
        var admin_id = data["admin_id"];
        var current_admin_id = <?php echo $_SESSION['admin_id'];?>;
        var is_reciever = false;
        if (current_admin_id == admin_id) {
            if (current_transaction_id == transaction_id) {
                is_reciever = true;
            }
        }
        if (is_reciever == true) {
            $(".msg_history").append(`
                <div class='incoming_msg'>
                    <div class='incoming_msg_img'>
                        <img src='../assets/img/CARELogo.png' alt='sunil'>
                    </div>
                    <div class='received_msg'>
                        <div class='received_withd_msg'>
                            <h6 class='text-success m-2'>${report_response_sender_name}</h6>
                            <p>${report_response_details}</p>
                            <span class='time_date'>${date_responded}</span>
                        </div>
                    </div>
                </div>
            `);
        }
    });
    channel.bind('admin-response-web', function(data) {
        var report_response_details = data["report_response_details"];
        var date_responded = data["date_responded"];
        var transaction_id = data["transaction_id"];
        var current_transaction_id = document.querySelector("#transaction_id").value;
        var admin_id = data["admin_id"];
        var current_admin_id = <?php echo $_SESSION['admin_id'];?>;
        var is_reciever = false;
        if (current_admin_id == admin_id) {
            if (current_transaction_id == transaction_id) {
                is_reciever = true;
            }
        }
        if (is_reciever == true) {
            $(".msg_history").append(`
                <div class='outgoing_msg'>
                    <div class='sent_msg'>
                        <p>${report_response_details}</p>
                        <span class='time_date'>${date_responded}</span>
                    </div>
                </div>
            `);
        }
    });

    lock_unlock_report_complaints.addEventListener('click', () => {
        let transaction_id = document.querySelector("#transaction_id").value;
        let is_lock;
        if (document.querySelector("#lock_unlock_report_complaints").value === "Lock") {
            is_lock = 1;
            let data = `transaction_id=${transaction_id}&is_lock=${is_lock}`;
            if (transaction_id != ''){
                sendData(data, "../controllers/admin/report_complaints_lock_unlock.php")
            } else {
                alert("Internal Error! the transaction id was not fetched");
            }
        } else {
            is_lock = 0;
            let data = `transaction_id=${transaction_id}&is_lock=${is_lock}`;
            if (transaction_id != ''){
                sendData(data, "../controllers/admin/report_complaints_lock_unlock.php");
            } else {
                alert("Internal Error! the transaction id was not fetched");
            }
        }
    })
    resolve_report_complaints.addEventListener('click', () => {
        let transaction_id = document.querySelector("#transaction_id").value;
        let data = `transaction_id=${transaction_id}`;
        if (transaction_id != ''){
            sendData(data, "../controllers/admin/report_complaints_resolve.php");
        } else {
            alert("Internal Error! the transaction id was not fetched");
        }
    })
    insert_report_response.addEventListener('click', () => {
        let transaction_id = document.querySelector("#transaction_id").value;
        let report_response_details = document.querySelector("#report_response_details").value;
        let data = `transaction_id=${transaction_id}&report_response_details=${report_response_details}`;
        if (transaction_id != ''){
            if (report_response_details.trim() != "") {
                sendData(data, "../controllers/admin/report_response_insert.php");
                document.querySelector("#report_response_details").value = "";
            }
        } else {
            alert("Internal Error! the transaction id was not fetched");
        }
    })
    back_report_complaints.addEventListener('click', () => {
        window.localStorage.removeItem("transaction_id");
        window.location.href = "../admin/report_complaints.php";
    })
    backReport.addEventListener('click', () => {
        window.localStorage.removeItem("transaction_id");
        window.location.href = "../admin/report_complaints.php";
    })
</script>

<?php
}
include('footer.php');
?>
