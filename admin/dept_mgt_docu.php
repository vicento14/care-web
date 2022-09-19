<?php 
include('header.php'); 
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Documents</title>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Insert Dept Docu Modal -->
<div class="modal fade" id="insertDeptDocuModal" tabindex="-1" role="dialog" aria-labelledby="insertDeptDocuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertDeptDocuModalTitle">Add Department Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_insert" enctype="multipart/form-data">
                    <p>
                        <input type="hidden" id="i_dept_docu_id" name="dept_docu_id" value="">
                        <label for="i_dept_docu_name">Document Name</label>
                        <input type="textbox" id="i_dept_docu_name" name="dept_docu_name" maxlength="255" placeholder="Document Name" style="width: 80%" required>
                    </p>

                    <div class="col-xl-12 col-lg-6">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <input type='file' id='i_dept_docu_data' name='dept_docu_data'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="insert_dept_svc">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Dept Docu Modal -->
<div class="modal fade" id="updateDeptDocuModal" tabindex="-1" role="dialog" aria-labelledby="updateDeptDocuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDeptDocuModalTitle">Edit Department Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_update" enctype="multipart/form-data">
                    <p>
                        <input type="hidden" id="u_dept_docu_id" name="dept_docu_id" value="">
                        <label for="u_dept_docu_name">Document Name</label>
                        <input type="textbox" id="u_dept_docu_name" name="dept_docu_name" maxlength="255" placeholder="Document Name" style="width: 80%" required>
                    </p>

                    <div class="col-xl-12 col-lg-6">
                        <div class="card shadow mb-10">
                            <div class="card-body">
                                <input type='file' id='u_dept_docu_data' name='dept_docu_data'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="update_dept_svc">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Dept Docu Name modal  -->
<div class="modal fade" id="EditDeptDocuNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditDeptDocuNameModalTitle">Edit Department Document Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <input type="hidden" id="e_dept_docu_id" name="dept_docu_id" value="">
                    <label for="e_dept_docu_name">Document Name</label>
                    <input type="textbox" id="e_dept_docu_name" name="dept_docu_name" maxlength="255" placeholder="Rename Document Name" style="width: 80%" required>
                </p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancel">
                <input type="button"  class="btn btn-success" id="edit_dept_svc" value="Save" name="save" >
            </div>
        </div>
    </div>
</div>

<!-- Delete Dept Docu Modal -->
<div id="deleteDeptDocuModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Department Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="del_dept_docu_id" id="del_dept_docu_id">
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
        <h1 class="h3 mb-0 text-gray-800">Department Documents Table</h1>
    </div>
    <div class="p-2">
        <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshDeptDocu">Refresh <i class="fas fa-sync-alt"></i></button>
    </div>
    <div class="p-2">
        <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="insertDeptDocu" data-toggle="modal" data-target="#insertDeptDocuModal">Add Documents<i class="fas fa-plus"></i></button>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center;">Dept Docu ID</th>
                        <th style="text-align: center;">Document Name</th>
                        <th style="text-align: center;">Filename</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>Document Name</td>
                        <td>Filename</td>
                        <td>
                        <!-- Actions Button -->
                            <div class="dropdown no-arrow container" style="text-align:center">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <button class="btn btn-success">Actions <i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                                    <!-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Actions</div>
                                    <a class="dropdown-item newStyle" id="updateDeptDocu" href="./dept_mgt_svc_details.php">Edit</a>
                                    <a class="dropdown-item newStyle" id="deleteDeptDocu" href="#" data-toggle="modal" data-target="#deleteDeptDocuModal">Delete</a>
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

<script>
    let dept_docu_id, del_dept_docu_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/dept_mgt_docu_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "dept_docu_id"},
                {"data": "dept_docu_name"},
                {"data": "dept_docu_filename"},
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
                                                <a class="dropdown-item newStyle" id="EditDeptDocuName" href="#" data-toggle="modal" data-target="#EditDeptDocuNameModal">Edit Document Name</a>
                                                <a class="dropdown-item newStyle" id="updateDeptDocu" href="#"data-toggle="modal" data-target="#updateDeptDocuModal">Edit</a>
                                                <a class="dropdown-item newStyle" id="deleteDeptDocu" href="#" data-toggle="modal" data-target="#deleteDeptDocuModal">Delete</a>
                                            </div>
                                        </div>`
                }
            ],
            "order": [[ 0, 'asc' ]]
        });

    });

    // HttpRequest Data File Upload
    const sendHttpRequest = (method, url, file, dept_docu_id, dept_docu_name, is_insert) => {
        const promise = new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            var formdata;
            if (is_insert == 1) {
                let form_insert = document.querySelector("#form_insert");
                var i_formdata = new FormData(form_insert);
                i_formdata.append("dept_docu_name", dept_docu_name);
                i_formdata.append("is_insert", is_insert);
                formdata = i_formdata;
            } else {
                let form_update = document.querySelector("#form_update");
                var u_formdata = new FormData(form_update);
                u_formdata.append("dept_docu_name", dept_docu_name);
                u_formdata.append("is_insert", is_insert);
                formdata = u_formdata;
            }
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
    const uploadData = (file, dept_docu_id, dept_docu_name, is_insert, url) => {
        document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
        document.querySelector('#LoadModalBody').innerHTML = "Uploading Department Document. Please wait...";
        $('#LoadModal').modal('show');
        sendHttpRequest('POST', url, file, dept_docu_id, dept_docu_name, is_insert).then(responseData => {
            table.ajax.reload(null, false);
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = responseData;
                $('#MsgboxModal').modal('show');
            },500);
        }).catch(err => {
            console.log(err);
        });
    };
    
    // Insert/Update single record post function
    const insert_update_dept_docu = (url, opt) => {
        let dept_docu_id, dept_docu_name, data;
        if (opt == 0) {
            dept_docu_id = $.trim($('#i_dept_docu_id').val());
            dept_docu_name = $.trim($('#i_dept_docu_name').val());
            let dept_docu_data = document.querySelector("#i_dept_docu_data").files[0];
            let is_insert = 1;
            if (dept_docu_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the document name";
                $('#MsgboxModal').modal('show');
            } else if (dept_docu_data) {
                $("#i_dept_docu_name").val(null);
                $('#insertDeptDocuModal').modal('hide');
                uploadData(dept_docu_data, dept_docu_id, dept_docu_name, is_insert, url);
            } else {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please upload a document";
                $('#MsgboxModal').modal('show');
            }
        } else {
            dept_docu_id = $.trim($('#u_dept_docu_id').val());
            dept_docu_name = $.trim($('#u_dept_docu_name').val());
            let dept_docu_data = document.querySelector("#u_dept_docu_data").files[0];
            let is_insert = 0;
            if (dept_docu_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the document name";
                $('#MsgboxModal').modal('show');
            } else if (dept_docu_data) {
                $("#u_dept_docu_id").val(null);
                $("#u_dept_docu_name").val(null);
                $('#updateDeptDocuModal').modal('hide');
                uploadData(dept_docu_data, dept_docu_id, dept_docu_name, is_insert, url);
            } else {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please upload a document";
                $('#MsgboxModal').modal('show');
            }
        }
    }

    // Insert single record post function
    $("#insert_dept_svc").click(() => {insert_update_dept_docu("../controllers/admin/dept_mgt_docu_upload.php", 0)});

    // Update single record post function
    $("#update_dept_svc").click(() => {insert_update_dept_docu("../controllers/admin/dept_mgt_docu_upload.php", 1)});

     // Edit single record post function
     $(document).on("click", "#edit_dept_svc", () => {
        dept_docu_id = $.trim($('#e_dept_docu_id').val());
        dept_docu_name = $.trim($('#e_dept_docu_name').val());
        if (dept_docu_name == "") {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type the document name";
            $('#MsgboxModal').modal('show');
        } else {
            $.ajax({
                url: "../controllers/admin/dept_mgt_docu_update_name.php",
                type: "POST",
                datatype:"json", 
                data:  {dept_docu_id:dept_docu_id, dept_docu_name:dept_docu_name}, 
                beforeSend: function () {
                    $('#EditDeptDocuNameModal').modal('hide');
                    document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
                    document.querySelector('#LoadModalBody').innerHTML = "Changing Department Document Name. Please wait...";
                    $('#LoadModal').modal('show');
                }, 
                success: function(data) {
                    table.ajax.reload(null, false);
                }
            }).done(function () {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                    document.querySelector('#MsgboxModalBody').innerHTML = "Department Document Name Changed Successfully";
                    $('#MsgboxModal').modal('show');
                },500);
            });
        }
    });

    // Delete single record post function
    $(document).on("click", "#delete_dept_svc", () => {
        $.ajax({
            url: "../controllers/admin/dept_mgt_docu_delete.php",
            type: "POST",
            datatype:"json",
            data:  {dept_docu_id:dept_docu_id}, 
            beforeSend: function () {
                $('#deleteDeptDocuModal').modal('hide');
                document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Department Document. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                document.querySelector('#MsgboxModalBody').innerHTML = data;
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                $('#MsgboxModal').modal('show');
            },500);
        });
    });

    // Insert single record modal
    $("#insertDeptDocu").click(function() {
        dept_docu_id = null;
        let dept_docu_name = null;
        $("#i_dept_docu_id").val(dept_docu_id);
        $("#i_dept_docu_name").val(dept_docu_name);
    });

    // Update single record modal
    $(document).on("click", "#updateDeptDocu", function() {
        row = $(this).closest("tr");
        dept_docu_id = parseInt(row.find('td:eq(0)').text());
        let dept_docu_name = row.find('td:eq(1)').text();
        $("#u_dept_docu_id").val(dept_docu_id);
        $("#u_dept_docu_name").val(dept_docu_name);
    });
    
    // Edit single record 
    $(document).on("click", "#EditDeptDocuName", function() {
        row = $(this).closest("tr");
        dept_docu_id = parseInt(row.find('td:eq(0)').text());
        let dept_docu_name = row.find('td:eq(1)').text();
        $("#e_dept_docu_id").val(dept_docu_id);
        $("#e_dept_docu_name").val(dept_docu_name);
    });

    // Delete single record
    $(document).on("click", "#deleteDeptDocu", function() {
        row = $(this).closest("tr");
        dept_docu_id = parseInt(row.find('td:eq(0)').text());
    });
    
    // Refresh
    $('#refreshDeptDocu').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php 
}
include('footer.php'); 
?>
