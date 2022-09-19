<?php
include("header.php");
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Notifications</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1 class="h3 mb-0 text-gray-800">Notifications Table</h1>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshNotifTable">Refresh <i class="fas fa-sync-alt"></i></button>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Transaction ID</th>
                            <th style="text-align: center;">Report Type ID</th>
                            <th style="text-align: center;">Report Type</th>
                            <th style="text-align: center;">Account ID</th>
                            <th style="text-align: center;">Message</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12345</td>
                            <td>12345</td>
                            <td>12345</td>
                            <td>12345</td>
                            <td>report type</td>
                            <td>12345</td>
                            <td>Message</td>
                            <td>
                            <!-- Actions Button -->
                                <div class="dropdown no-arrow container" style="text-align:center">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Actions</div>
                                        <a class="dropdown-item newStyle" href="#"data-toggle="modal" data-target="#updateNotifInfoModal" >Edit</a>
                                        <a class="dropdown-item newStyle" href="#"data-toggle="modal" data-target="#DeletePHP" >Delete</a>
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
    let current_notif_id, del_notif_id, table, row;
    let current_transaction_id, current_report_type_id;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/notif_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "notif_id"},
                {"data": "notif_date"},
                {"data": "transaction_id"},
                {"data": "report_type_id"},
                {"data": "report_type_name"},
                {"data": "from_account_id"},
                {"data": "notif_msg_details"},
                {
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": `<div class="dropdown no-arrow container" style="text-align:center">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <button class="btn btn-success" id="actionsBtn">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Actions</div>
                                                <a class="dropdown-item newStyle" id="viewReport">View</a>
                                                <a class="dropdown-item newStyle" id="read_notif">Mark as read</a>
                                            </div>
                                        </div>`
                }
            ],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 2 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 3 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 5 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            "order": [[ 1, 'desc' ]]
        });

    });

    $('#dataTable tbody').on('click', 'tr', function () {
        let tdata = table.row(this).data();
        current_notif_id = tdata['notif_id'];
        current_transaction_id = tdata['transaction_id'];
        current_report_type_id = tdata['report_type_id'];
    });

    var pusher = new Pusher('8ff31fe73cdbafda41bc', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('care-app-143');
    channel.bind('admin-notif', function(data) {
        var notif_id = data["notif_id"];
        var notif_date = data["notif_date"];
        var notif_msg_details = data["notif_msg_details"];
        var transaction_id = data["transaction_id"];
        var from_account_id = data["from_account_id"];
        var report_type_id = data["report_type_id"];
        var report_type_name = data["report_type_name"];
        var admin_id = data["admin_id"];
        var current_admin_id = <?php echo $_SESSION['admin_id'];?>;
        var is_reciever = false;
        if (current_admin_id == admin_id) {
            is_reciever = true;
        }
        if (is_reciever == true) {
            table.ajax.reload(null, false);
            /*
            if (table.rows().count() === 0) {
                table.ajax.reload(null, false);
            } else {
                $("#dataTable > tbody:last-child").append(`
                    <tr>
                        <td>${notif_id}</td>
                        <td>${notif_date}</td>
                        <td>${transaction_id}</td>
                        <td>${report_type_id}</td>
                        <td>${report_type_name}</td>
                        <td>${from_account_id}</td>
                        <td>${notif_msg_details}</td>
                        <td>
                            <div class="dropdown no-arrow container" style="text-align:center">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Actions</div>
                                    <a class="dropdown-item newStyle" id="viewReport">View</a>
                                    <a class="dropdown-item newStyle" id="read_notif">Mark as read</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            }*/
        }
    });

    // View single record
    $(document).on("click", "#viewReport", function() {
        if (window.localStorage.getItem("transaction_id")) {
            window.localStorage.removeItem("transaction_id");
        }
        window.localStorage.setItem("transaction_id", current_transaction_id);
        if (current_report_type_id == 0) {
            window.location.href = '../admin/report_complaints_details.php';
        } else {
            window.location.href = '../admin/report_concerns_details.php';
        }
    });

    // read single record post function
    $(document).on("click", "#read_notif", () => {
        $.ajax({
            url: "../controllers/admin/notif_delete.php",
            type: "POST",
            datatype:"json",
            data:  {notif_id:current_notif_id}, 
            beforeSend: function () {
                document.querySelector('#LoadModalTitle').innerHTML = "Notifications";
                document.querySelector('#LoadModalBody').innerHTML = "Setting a notification as read. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
            },500);
        });
    });
    
    // Refresh
    $('#refreshNotifTable').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php
}
include('footer.php');
?>
