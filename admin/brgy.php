<?php
include("header.php");
if ($_SESSION['dept_id'] != 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Barangays</title>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Brgy Modal -->
    <div class="modal fade" id="insertBrgyModal" tabindex="-1" role="dialog" aria-labelledby="insertBrgyModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertBrgyModalTitle">Add Barangay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="i_barangay_name">Barangay Name :</label>
                            <input type="textbox" id="i_barangay_name" name="i_barangay_name" placeholder="Barangay Name" maxlength="255">
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="insert_barangay">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Brgy Info Modal -->
    <div class="modal fade" id="updateBrgyInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateBrgyInfoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBrgyInfoModalTitle">Edit Barangay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>
                            <label for="u_barangay_id">Barangay ID :</label>
                            <label name="u_barangay_id" id="u_barangay_id">123</label>
                        </p>
                        <p>
                            <label for="u_barangay_name">Barangay Name :</label>
                            <input type="textbox" id="u_barangay_name" name="u_barangay_name" placeholder="Barangay Name" maxlength="255">
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="update_barangay">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Brgy Modal -->
    <div id="deleteBrgyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Barangay</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_barangay_id" id="del_barangay_id">
                    <p>Are you sure you want to delete this Record?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" id="delete_barangay" value="Delete" name="Delete">
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1 class="h3 mb-0 text-gray-800">Barangays Table</h1>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="refreshBrgyTable">Refresh <i class="fas fa-sync-alt"></i></button>
        </div>
        <div class="p-2">
            <button type="button" class="h6 mb-0 text-white-800 btn btn-success" id="insertBrgy" data-toggle="modal" data-target="#insertBrgyModal">Add Barangay <i class="fas fa-plus"></i></button>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Barangay ID</th>
                            <th style="text-align: center;">Barangay Name</th>
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
                                        <a class="dropdown-item newStyle" href="#"data-toggle="modal" data-target="#updateBrgyInfoModal" >Edit</a>
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
    let barangay_id, del_barangay_id, table, row;
    $(document).ready(() => {

        // Load datatable records
        $("#dataTable").dataTable().fnDestroy();
        table = $('#dataTable').DataTable({
            "ajax":{
                "url": "../controllers/admin/brgy_load.php", 
                "method": 'POST', 
                "dataSrc": ""
            },
            "columns":[
                {"data": "barangay_id"},
                {"data": "barangay_name"},
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
                                                <a class="dropdown-item newStyle" id="updateBrgyInfo" href="#"data-toggle="modal" data-target="#updateBrgyInfoModal">Edit</a>
                                                <a class="dropdown-item newStyle" id="deleteBrgy" href="#" data-toggle="modal" data-target="#deleteBrgyModal">Delete</a>
                                            </div>
                                        </div>`
                }
            ],
            "order": [[ 0, 'asc' ]]
        });

    });

    // Insert/Update single record post function
    const insert_update_brgy = (url, opt) => {
        let barangay_name, data;
        let is_null = 0;
        if (opt == 0) {
            barangay_name = $.trim($('#i_barangay_name').val());
            if (barangay_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Barangays";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the barangay name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {barangay_name:barangay_name};
                $("#i_barangay_name").val(null);
                $('#insertBrgyModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Adding New Barangay Record. Please wait...";
            }
        } else {
            barangay_id = $.trim($('#u_barangay_id').text());
            barangay_name = $.trim($('#u_barangay_name').val());
            if (barangay_name == "") {
                document.querySelector('#MsgboxModalTitle').innerHTML = "Barangays";
                document.querySelector('#MsgboxModalBody').innerHTML = "Please type the barangay name";
                $('#MsgboxModal').modal('show');
                is_null = 1;
            } else {
                data = {barangay_id:barangay_id, barangay_name:barangay_name};
                $("#u_barangay_id").val(null);
                $("#u_barangay_name").val(null);
                $('#updateBrgyInfoModal').modal('hide');
                document.querySelector('#LoadModalBody').innerHTML = "Saving Barangay Information. Please wait...";
            }
        }
        if (is_null == 0) {
            $.ajax({
                url: url,
                type: "POST",
                datatype:"json",
                data:  data, 
                beforeSend: function () {
                    document.querySelector('#LoadModalTitle').innerHTML = "Barangays";
                    $('#LoadModal').modal('show');
                }, 
                success: function(data) {
                    if (opt == 0) {
                        document.querySelector('#MsgboxModalBody').innerHTML = "New Barangay Record Added Successfully";
                    } else {
                        document.querySelector('#MsgboxModalBody').innerHTML = "Barangay Information Saved Successfully";
                    }
                    table.ajax.reload(null, false);
                }
            }).done(function () {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Barangays";
                    $('#MsgboxModal').modal('show');
                },500);
            });
        }
    }

    // Insert single record post function
    $("#insert_barangay").click(() => {insert_update_brgy("../controllers/admin/brgy_insert.php", 0)});

    // Update single record post function
    $("#update_barangay").click(() => {insert_update_brgy("../controllers/admin/brgy_update.php", 1)});

    // Delete single record post function
    $(document).on("click", "#delete_barangay", () => {
        $.ajax({
            url: "../controllers/admin/brgy_delete.php",
            type: "POST",
            datatype:"json",
            data:  {barangay_id:barangay_id}, 
            beforeSend: function () {
                document.querySelector('#LoadModalTitle').innerHTML = "Barangays";
                document.querySelector('#LoadModalBody').innerHTML = "Deleting Barangay Record. Please wait...";
                $('#LoadModal').modal('show');
            }, 
            success: function(data) {
                document.querySelector('#MsgboxModalBody').innerHTML = data;
                table.ajax.reload(null, false);
            }
        }).done(function () {
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Barangays";
                $('#MsgboxModal').modal('show');
            },500);
        });
        $('#deleteBrgyModal').modal('hide');
    });

    // Insert single record modal
    $("#insertBrgy").click(function() {
        barangay_id = null;
        let barangay_name = null;
        $("#i_barangay_name").val(barangay_name);
    });

    // Update single record modal
    $(document).on("click", "#updateBrgyInfo", function() {
        row = $(this).closest("tr");
        barangay_id = parseInt(row.find('td:eq(0)').text());
        let barangay_name = row.find('td:eq(1)').text();
        $("#u_barangay_id").text(barangay_id);
        $("#u_barangay_name").val(barangay_name);
    });
    
    // Delete single record
    $(document).on("click", "#deleteBrgy", function() {
        row = $(this).closest("tr");
        barangay_id = parseInt(row.find('td:eq(0)').text());
    });
    
    // Refresh
    $('#refreshBrgyTable').click(() => {
        table.ajax.reload(null, false);
    });
</script>

<?php
}
include('footer.php');
?>
