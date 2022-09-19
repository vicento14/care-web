<?php
include('header.php');
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Services</title>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Delete Dept Svc Modal -->
<div id="deleteDeptSvcModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Department Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_dept_svc_id" id="del_dept_svc_id">
                <p>Are you sure you want to delete this Record?</p>
                <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                <input type="submit" class="btn btn-danger" id="delete_dept_svc" value="Delete" name="Delete">
            </div>
        </div>
    </div>
</div>

<!-- Page Heading -->
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1 class="h3 mb-0 text-gray-800">Department Services Table</h1>
    </div>
    <div class="p-2">
        <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshDeptSvc">Refresh <i class="fas fa-sync-alt"></i></button>
    </div>
    <div class="p-2">
        <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="insertDeptSvc">Add Services<i class="fas fa-plus"></i></button>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Dept Svc ID</th>
                        <th style="text-align: center;">Category Name</th>
                        <th style="text-align: center;">Sub Category Name</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>Category Name</td>
                        <td>Sub Category Name</td>
                        <td>
                        <!-- Actions Button -->
                            <div class="dropdown no-arrow container" style="text-align:center">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Actions</div>
                                    <a class="dropdown-item newStyle" id="viewDeptSvc">Edit</a>
                                    <a class="dropdown-item newStyle" id="deleteDeptSvc" href="#" data-toggle="modal" data-target="#deleteDeptSvcModal">Delete</a>
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
    let dept_svc_id, del_dept_svc_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/dept_mgt_svc_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "dept_svc_id"},
                {"data": "dept_svc_category_name"},
                {"data": "dept_svc_subcategory_name"},
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
                                                <a class="dropdown-item newStyle" id="viewDeptSvc">View</a>
                                                <a class="dropdown-item newStyle" id="deleteDeptSvc" href="#" data-toggle="modal" data-target="#deleteDeptSvcModal">Delete</a>
                                            </div>
                                        </div>`
                }
            ],
            "order": [[ 0, 'asc' ]]
        });

    });

    // Delete single record post function
    $(document).on("click", "#delete_dept_svc", () => {
        $.ajax({
            url: "../controllers/admin/dept_mgt_svc_delete.php",
            type: "POST",
            datatype:"json",
            data:  {dept_svc_id:dept_svc_id}, 
            beforeSend: function () {
                $('#deleteDeptSvcModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Department Service. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Department Service Deleted Successfully";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Delete single record
    $(document).on("click", "#deleteDeptSvc", function() {
        row = $(this).closest("tr");
        dept_svc_id = parseInt(row.find('td:eq(0)').text());
    });
    
    // Refresh
    $('#refreshDeptSvc').click(() => {
        table.ajax.reload(null, false);
    });

    // View
    $(document).on("click", "#viewDeptSvc", function() {
        row = $(this).closest("tr");
        dept_svc_id = parseInt(row.find('td:eq(0)').text());
        let dept_svc_opt = true;
        if (window.localStorage.getItem("dept_svc_id")) {
            window.localStorage.removeItem("dept_svc_id");
        }
        window.localStorage.setItem("dept_svc_id", dept_svc_id);
        $.ajax({
            url: "../controllers/admin/dept_mgt_svc_opt.php",
            type: "POST",
            datatype:"json",
            data:  {dept_svc_opt:dept_svc_opt}, 
            success: function(data) {
                window.location.href = "../admin/dept_mgt_svc_details.php";
                table.ajax.reload(null, false);
            }
        });
    });
    
    // Insert
    $(document).on("click", "#insertDeptSvc", function() {
        let dept_svc_opt = false;
        $.ajax({
            url: "../controllers/admin/dept_mgt_svc_opt.php",
            type: "POST",
            datatype:"json",
            data:  {dept_svc_opt:dept_svc_opt}, 
            success: function(data) {
                window.location.href = "../admin/dept_mgt_svc_details.php";
                table.ajax.reload(null, false);
            }
        });
    });

</script>

<?php
}
include('footer.php');
?>
