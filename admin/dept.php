<?php
include("header.php");
if ($_SESSION['dept_id'] != 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Departments</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Dept Modal -->
    <div class="modal fade" id="insertDeptModal" tabindex="-1" role="dialog" aria-labelledby="insertDeptModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertDeptModalTitle">Add Department :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="i_dept_name">Department Name</label>
                            <input type="textbox" id="i_dept_name" name="i_dept_name" placeholder="Department Name" maxlength="255">
                        </p>  
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="insert_dept">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Dept Info Modal -->
    <div class="modal fade" id="updateDeptInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateDeptInfoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateDeptInfoModalTitle">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="u_dept_id">Department ID :</label>
                            <label name="u_dept_id" id="u_dept_id">123</label>
                        </p>
                        <p>
                            <label for="u_dept_name">Department Name :</label>
                            <input type="textbox" id="u_dept_name" name="u_dept_name" placeholder="Department Name" maxlength="255">
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="update_dept">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Dept Modal -->
    <div id="deleteDeptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_dept_id" id="del_dept_id">
                    <p>Are you sure you want to delete this Record?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" id="delete_dept" value="Delete" name="Delete">
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1 class="h3 mb-0 text-gray-800">Departments Table</h1>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshDeptTable">Refresh <i class="fas fa-sync-alt"></i></button>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="insertDept" data-toggle="modal" data-target="#insertDeptModal">Add Department <i class="fas fa-plus"></i></button>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Department ID</th>
                            <th style="text-align: center;">Department Name</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12345</td>
                            <td>User</td>
                            <td>
                            <!-- Actions Button -->
                                <div class="dropdown no-arrow container" style="text-align:center">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Actions</div>
                                        <a class="dropdown-item newStyle" href="#"data-toggle="modal" data-target="#updateDeptInfoModal" >Edit</a>
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
    let dept_id, del_dept_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/dept_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
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
                                                <a class="dropdown-item newStyle" id="updateDeptInfo" href="#"data-toggle="modal" data-target="#updateDeptInfoModal">Edit</a>
                                                <a class="dropdown-item newStyle" id="deleteDept" href="#" data-toggle="modal" data-target="#deleteDeptModal">Delete</a>
                                            </div>
                                        </div>`
                }
            ],
            "order": [[ 0, 'asc' ]]
        });

    });

    // Insert/Update single record post function
    const insert_update_dept = (url, opt) => {
        let dept_name, data;
        let is_null = 0;
        if (opt == 0) {
            dept_name = $.trim($('#i_dept_name').val());
            if (dept_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Departments";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the department name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {dept_name:dept_name};
                $("#i_dept_name").val(null);
                $('#insertDeptModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Adding New Department Record. Please wait...";
            }
        } else {
            dept_id = $.trim($('#u_dept_id').text());
            dept_name = $.trim($('#u_dept_name').val());
            if (dept_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Departments";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the department name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {dept_id:dept_id, dept_name:dept_name};
                $("#u_dept_id").val(null);
                $("#u_dept_name").val(null);
                $('#updateDeptInfoModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Saving Department Information. Please wait...";
            }
        }
        if (is_null == 0) {
            $.ajax({
                url: url,
                type: "POST",
                datatype:"json",
                data:  data, 
                beforeSend: function () {
                    document.querySelector('#LoadModalTitle').innerHTML = "Departments";
                    $('#LoadModal').modal('show');
                }, 
                success: function(data) {
                    if (opt == 0) {
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Department Record Added Successfully";
                    } else {
                        document.querySelector('#MsgboxModalBody').innerHTML = "Department Information Saved Successfully";
                    }
                    table.ajax.reload(null, false);
                }
            }).done(function () {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Departments";
                    $('#MsgboxModal').modal('show');
                },500);
            });
        }
    }

    // Insert single record post function
    $("#insert_dept").click(() => {insert_update_dept("../controllers/admin/dept_insert.php", 0)});

    // Update single record post function
    $("#update_dept").click(() => {insert_update_dept("../controllers/admin/dept_update.php", 1)});

    // Delete single record post function
    $(document).on("click", "#delete_dept", () => {
        $.ajax({
            url: "../controllers/admin/dept_delete.php",
            type: "POST",
            datatype:"json",
            data:  {dept_id:dept_id}, 
            beforeSend: function () {
                $('#deleteDeptModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Departments";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Department Record. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                document.querySelector('#MsgboxModalBody').innerHTML = data;
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Departments";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Insert single record modal
    $("#insertDept").click(function() {
        dept_id = null;
        let dept_name = null;
        $("#i_dept_name").val(dept_name);
    });

    // Update single record modal
    $(document).on("click", "#updateDeptInfo", function() {
        row = $(this).closest("tr");
        dept_id = parseInt(row.find('td:eq(0)').text());
        let dept_name = row.find('td:eq(1)').text();
        $("#u_dept_id").text(dept_id);
        $("#u_dept_name").val(dept_name);
    });
    
    // Delete single record
    $(document).on("click", "#deleteDept", function() {
        row = $(this).closest("tr");
        dept_id = parseInt(row.find('td:eq(0)').text());
    });
    
    // Refresh
    $('#refreshDeptTable').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php
}
include('footer.php');
?>
