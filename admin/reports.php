<?php
include_once('header.php');
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Reports</title>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1 class="h3 mb-0 text-gray-800">Reports Table</h1>
    </div>
    <div class="p-2">
        <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshComplaintTable">Refresh <i class="fas fa-sync-alt"></i></button>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Transaction ID</th>
                        <th style="text-align: center;">Report Type</th>
                        <th style="text-align: center;">Barangay</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>04-03-21 08:00:00</td>
                        <td>12345</td>
                        <td>Complaint/Concern</td>
                        <td>Barangay</td>
                        <td>Pending/Resolved</td>
                        <td>
                        <!-- Actions Button -->
                            <div class="dropdown no-arrow container" style="text-align:center">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Actions</div>
                                    <a class="dropdown-item newStyle" id="viewReport">View</a>
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

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- inserted for assurance -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>

<script>
    let transaction_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/report_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "transaction_end_date"},
                {"data": "transaction_id"},
                {"data": "report_type_name"},
                {"data": "barangay_name"},
                {"data": "is_resolved"},
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
                                                <a class="dropdown-item newStyle" id="viewReport">View</a>
                                            </div>
                                        </div>`
                }
            ],
            "columnDefs": [
                {
                    "render": function (data) {
                        if (data == 0) {
                            return "pending";
                        } else return "resolved";
                    },
                    "targets": 4
                }
            ],
            "order": [[ 0, 'desc' ]]
        });

    });

    // View single record
    $(document).on("click", "#viewReport", function() {
        row = $(this).closest("tr");
        transaction_id = parseInt(row.find('td:eq(1)').text());

        if (window.localStorage.getItem("transaction_id")) {
            window.localStorage.removeItem("transaction_id");
        }
        window.localStorage.setItem("transaction_id", transaction_id);
        window.location.href = '../admin/report_details.php';
    });
    
    // Refresh
    $('#refreshComplaintTable').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php
}
include('footer.php');
?>
