<?php
include('header.php');
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
    $dept_svc_opt = $_SESSION['dept_svc_opt'];
?>

<title>CARE | Service Details</title>

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Department Services</h1>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="dept_svc_back"><i class="fas fa-arrow-left"></i> Back to Services</button>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <h6 class="m-0 font-weight-bold text-success" id="dept_svc_title">Add Service</h6>
                        </div>
                        <div class="p-2"></div>
                        <div class="p-2"></div>
                    </div>
                </div>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Information :</h1>
                <input type="hidden" name="dept_svc_id" id="dept_svc_id" value="">
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2 card-header">
                <h1 class="h5 mb-0 text-gray-800">Government Service Category</h1>
                <h5 class="h6 mb-0 text-gray-1000">
                    <input type="text" name="dept_svc_category_name" id="dept_svc_category_name" maxlength="255">
                </h5>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2 card-header">
                <h1 class="h5 mb-0 text-gray-800">Government Service Sub Category</h1>
                <h5 class="h6 mb-0 text-gray-1000">
                    <input type="text" name="dept_svc_subcategory_name" id="dept_svc_subcategory_name" maxlength="255">
                </h5>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-2 card-header">
                <h1 class="h5 mb-0 text-gray-800">Government Agency</h1>
                <h5 class="h6 mb-0 text-gray-1000"><?php echo $_SESSION['dept_name']; ?></h5>
            </div>
            <div class="d-sm-flex align-items-center justify-content-between mb-4 card-header">
                <h1 class="h5 mb-0 text-gray-800">Department Admin Involed:</h1>
                <h5 class="h6 mb-0 text-gray-1000"><?php echo $_SESSION['account_name']; ?></h5>
            </div>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Document Needed :</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_docu_need" name="dept_svc_docu_need" rows="4" cols="50"></textarea>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Step by Step Procedure :</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_sbs_procedure" name="dept_svc_sbs_procedure" rows="4" cols="50"></textarea>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Person's Responsible:</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_rfsp" name="dept_svc_rfsp" rows="4" cols="50"></textarea>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Maximum Time of Transaction</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_estimate_time_transact" name="dept_svc_estimate_time_transact" rows="4" cols="50"></textarea>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Fees</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_fees" name="dept_svc_fees" rows="4" cols="50"></textarea>
        </div>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Procedure for Filling</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <textarea class="form-control" id="dept_svc_procedure_filing_complaints" name="dept_svc_procedure_filing_complaints" rows="4" cols="50"></textarea>
        </div>
    </div>

    <hr class="sidebar-divider">

    <div class="d-sm-flex align-items-left p3 mb-4">
        <button class="btn btn-success" type="button" id="insert_dept_svc" style="margin: 10px">Add</button>
        <button class="btn btn-success" type="button" id="insert_dept_svc_back" style="margin: 10px">Back</button>
        <button class="btn btn-success" type="button" id="update_dept_svc_edit" style="margin: 10px">Edit</button>
        <button class="btn btn-success" type="button" id="update_dept_svc" style="margin: 10px">Save</button>
        <button class="btn btn-success" type="button" id="update_dept_svc_cancel" style="margin: 10px">Cancel</button>
        <button class="btn btn-success" type="button" id="update_dept_svc_back" style="margin: 10px">Back</button>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
    const dept_svc_back = document.querySelector('#dept_svc_back');
    const insert_dept_svc = document.querySelector('#insert_dept_svc');
    const insert_dept_svc_back = document.querySelector('#insert_dept_svc_back');
    const update_dept_svc_edit = document.querySelector('#update_dept_svc_edit');
    const update_dept_svc = document.querySelector('#update_dept_svc');
    const update_dept_svc_cancel = document.querySelector('#update_dept_svc_cancel');
    const update_dept_svc_back = document.querySelector('#update_dept_svc_back');

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
        if (url == "../controllers/admin/dept_mgt_svc_update.php") {
            document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
            document.querySelector('#LoadModalBody').innerHTML = "Saving Department Service Information. Please wait...";
            $('#LoadModal').modal('show');
        } else if (url == "../controllers/admin/dept_mgt_svc_insert.php") {
            document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
            document.querySelector('#LoadModalBody').innerHTML = "Addding New Department Service. Please wait...";
            $('#LoadModal').modal('show');
        }
        sendHttpRequest('POST', url, data).then(responseData => {
            if (url == "../controllers/admin/dept_mgt_svc_view.php") {
                let dept_svc_array = JSON.parse(responseData);
                document.getElementById("dept_svc_category_name").value = dept_svc_array.dept_svc_category_name;
                document.getElementById("dept_svc_subcategory_name").value = dept_svc_array.dept_svc_subcategory_name;
                document.getElementById("dept_svc_docu_need").value = dept_svc_array.dept_svc_docu_need;
                document.getElementById("dept_svc_sbs_procedure").value = dept_svc_array.dept_svc_sbs_procedure;
                document.getElementById("dept_svc_rfsp").value = dept_svc_array.dept_svc_rfsp;
                document.getElementById("dept_svc_estimate_time_transact").value = dept_svc_array.dept_svc_estimate_time_transact;
                document.getElementById("dept_svc_fees").value = dept_svc_array.dept_svc_fees;
                document.getElementById("dept_svc_procedure_filing_complaints").value = dept_svc_array.dept_svc_procedure_filing_complaints;
            } else if (url == "../controllers/admin/dept_mgt_svc_update.php") {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                    document.querySelector('#MsgboxModalBody').innerHTML = "Department Service Information Saved Successfully";
                    $('#MsgboxModal').modal('show');
                },500);
            } else if (url == "../controllers/admin/dept_mgt_svc_insert.php") {
                setTimeout(function () {
                    $('#LoadModal').modal('hide');
                    document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                    document.querySelector('#MsgboxModalBody').innerHTML = "New Department Service Information Added Successfully";
                    $('#MsgboxModal').modal('show');
                },500);
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

    let deptSvcOpt = <?php echo $dept_svc_opt; ?>;
    if (deptSvcOpt == false) {
        document.querySelector("#dept_svc_title").innerHTML = "Add Service";
        document.getElementById("update_dept_svc_edit").style.display = "none";
        document.getElementById("update_dept_svc").style.display = "none";
        document.getElementById("update_dept_svc_cancel").style.display = "none";
        document.getElementById("update_dept_svc_back").style.display = "none";
    } else {
        let v_dept_svc_id = window.localStorage.getItem("dept_svc_id");
        document.querySelector("#dept_svc_title").innerHTML = "View Service";
        document.getElementById("insert_dept_svc").style.display = "none";
        document.getElementById("insert_dept_svc_back").style.display = "none";
        document.getElementById("update_dept_svc").style.display = "none";
        document.getElementById("update_dept_svc_cancel").style.display = "none";
        let data = `dept_svc_id=${v_dept_svc_id}`;
        if (dept_svc_id != ''){
            document.querySelector("#dept_svc_id").value = v_dept_svc_id;
            sendData(data, "../controllers/admin/dept_mgt_svc_view.php");
        } else {
            alert("Internal Error! the dept svc id not fetched");
        }

        document.getElementById("dept_svc_category_name").readOnly = true;
        document.getElementById("dept_svc_subcategory_name").readOnly = true;
        document.getElementById("dept_svc_docu_need").readOnly = true;
        document.getElementById("dept_svc_sbs_procedure").readOnly = true;
        document.getElementById("dept_svc_rfsp").readOnly = true;
        document.getElementById("dept_svc_estimate_time_transact").readOnly = true;
        document.getElementById("dept_svc_fees").readOnly = true;
        document.getElementById("dept_svc_procedure_filing_complaints").readOnly = true;
    }

    dept_svc_back.addEventListener('click', () => {
        document.getElementById("dept_svc_id").value = '';
        document.getElementById("dept_svc_category_name").value = '';
        document.getElementById("dept_svc_subcategory_name").value = '';
        document.getElementById("dept_svc_docu_need").value = '';
        document.getElementById("dept_svc_sbs_procedure").value = '';
        document.getElementById("dept_svc_rfsp").value = '';
        document.getElementById("dept_svc_estimate_time_transact").value = '';
        document.getElementById("dept_svc_fees").value = '';
        document.getElementById("dept_svc_procedure_filing_complaints").value = '';
        window.location.href = "../admin/dept_mgt_svc.php";
    })
    insert_dept_svc.addEventListener('click', () => {
        let dept_svc_category_name = document.querySelector("#dept_svc_category_name").value;
        let dept_svc_subcategory_name = document.querySelector("#dept_svc_subcategory_name").value;
        let dept_svc_docu_need = document.querySelector("#dept_svc_docu_need").value;
        let dept_svc_sbs_procedure = document.querySelector("#dept_svc_sbs_procedure").value;
        let dept_svc_rfsp = document.querySelector("#dept_svc_rfsp").value;
        let dept_svc_estimate_time_transact = document.querySelector("#dept_svc_estimate_time_transact").value;
        let dept_svc_fees = document.querySelector("#dept_svc_fees").value;
        let dept_svc_procedure_filing_complaints = document.querySelector("#dept_svc_procedure_filing_complaints").value;
        if (dept_svc_category_name == "") {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type the service category name";
            $('#MsgboxModal').modal('show');
        } else if (dept_svc_subcategory_name == "") {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your service subcategory name";
            $('#MsgboxModal').modal('show');
        } else {
            let data = `dept_svc_category_name=${dept_svc_category_name}&dept_svc_subcategory_name=${dept_svc_subcategory_name}&dept_svc_docu_need=${dept_svc_docu_need}&dept_svc_sbs_procedure=${dept_svc_sbs_procedure}&dept_svc_rfsp=${dept_svc_rfsp}&dept_svc_estimate_time_transact=${dept_svc_estimate_time_transact}&dept_svc_fees=${dept_svc_fees}&dept_svc_procedure_filing_complaints=${dept_svc_procedure_filing_complaints}`;
            sendData(data, "../controllers/admin/dept_mgt_svc_insert.php");
            document.getElementById("dept_svc_id").value = '';
            document.getElementById("dept_svc_category_name").value = '';
            document.getElementById("dept_svc_subcategory_name").value = '';
            document.getElementById("dept_svc_docu_need").value = '';
            document.getElementById("dept_svc_sbs_procedure").value = '';
            document.getElementById("dept_svc_rfsp").value = '';
            document.getElementById("dept_svc_estimate_time_transact").value = '';
            document.getElementById("dept_svc_fees").value = '';
            document.getElementById("dept_svc_procedure_filing_complaints").value = '';
            setTimeout(function () {
                window.location.href = "../admin/dept_mgt_svc.php";
            },1500);
        }
    })
    insert_dept_svc_back.addEventListener('click', () => {
        document.getElementById("dept_svc_id").value = '';
        document.getElementById("dept_svc_category_name").value = '';
        document.getElementById("dept_svc_subcategory_name").value = '';
        document.getElementById("dept_svc_docu_need").value = '';
        document.getElementById("dept_svc_sbs_procedure").value = '';
        document.getElementById("dept_svc_rfsp").value = '';
        document.getElementById("dept_svc_estimate_time_transact").value = '';
        document.getElementById("dept_svc_fees").value = '';
        document.getElementById("dept_svc_procedure_filing_complaints").value = '';
        window.location.href = "../admin/dept_mgt_svc.php";
    })
    update_dept_svc_edit.addEventListener('click', () => {
        document.querySelector("#dept_svc_title").innerHTML = "Edit Service";
        document.getElementById("update_dept_svc").style.display = "block";
        document.getElementById("update_dept_svc_cancel").style.display = "block";
        document.getElementById("update_dept_svc_edit").style.display = "none";
        document.getElementById("update_dept_svc_back").style.display = "none";

        document.getElementById("dept_svc_category_name").readOnly = false;
        document.getElementById("dept_svc_subcategory_name").readOnly = false;
        document.getElementById("dept_svc_docu_need").readOnly = false;
        document.getElementById("dept_svc_sbs_procedure").readOnly = false;
        document.getElementById("dept_svc_rfsp").readOnly = false;
        document.getElementById("dept_svc_estimate_time_transact").readOnly = false;
        document.getElementById("dept_svc_fees").readOnly = false;
        document.getElementById("dept_svc_procedure_filing_complaints").readOnly = false;
    })
    update_dept_svc.addEventListener('click', () => {
        let dept_svc_id = document.querySelector("#dept_svc_id").value;
        let dept_svc_category_name = document.querySelector("#dept_svc_category_name").value;
        let dept_svc_subcategory_name = document.querySelector("#dept_svc_subcategory_name").value;
        let dept_svc_docu_need = document.querySelector("#dept_svc_docu_need").value;
        let dept_svc_sbs_procedure = document.querySelector("#dept_svc_sbs_procedure").value;
        let dept_svc_rfsp = document.querySelector("#dept_svc_rfsp").value;
        let dept_svc_estimate_time_transact = document.querySelector("#dept_svc_estimate_time_transact").value;
        let dept_svc_fees = document.querySelector("#dept_svc_fees").value;
        let dept_svc_procedure_filing_complaints = document.querySelector("#dept_svc_procedure_filing_complaints").value;
        if (dept_svc_category_name == "") {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type the service category name";
            $('#MsgboxModal').modal('show');
        } else if (dept_svc_subcategory_name == "") {
            document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
            document.querySelector('#MsgboxModalBody').innerHTML = "Please type your service subcategory name";
            $('#MsgboxModal').modal('show');
        } else {
            let data = `dept_svc_id=${dept_svc_id}&dept_svc_category_name=${dept_svc_category_name}&dept_svc_subcategory_name=${dept_svc_subcategory_name}&dept_svc_docu_need=${dept_svc_docu_need}&dept_svc_sbs_procedure=${dept_svc_sbs_procedure}&dept_svc_rfsp=${dept_svc_rfsp}&dept_svc_estimate_time_transact=${dept_svc_estimate_time_transact}&dept_svc_fees=${dept_svc_fees}&dept_svc_procedure_filing_complaints=${dept_svc_procedure_filing_complaints}`;
            if (dept_svc_id != ''){
                sendData(data, "../controllers/admin/dept_mgt_svc_update.php");
                document.querySelector("#dept_svc_title").innerHTML = "View Service";
                document.getElementById("update_dept_svc_edit").style.display = "block";
                document.getElementById("update_dept_svc_back").style.display = "block";
                document.getElementById("update_dept_svc").style.display = "none";
                document.getElementById("update_dept_svc_cancel").style.display = "none";

                document.getElementById("dept_svc_category_name").readOnly = true;
                document.getElementById("dept_svc_subcategory_name").readOnly = true;
                document.getElementById("dept_svc_docu_need").readOnly = true;
                document.getElementById("dept_svc_sbs_procedure").readOnly = true;
                document.getElementById("dept_svc_rfsp").readOnly = true;
                document.getElementById("dept_svc_estimate_time_transact").readOnly = true;
                document.getElementById("dept_svc_fees").readOnly = true;
                document.getElementById("dept_svc_procedure_filing_complaints").readOnly = true;
            } else {
                alert("Internal Error! the dept svc id was not fetched");
            }
        }
    })
    update_dept_svc_cancel.addEventListener('click', () => {
        let v_dept_svc_id = document.querySelector("#dept_svc_id").value;
        let data = `dept_svc_id=${v_dept_svc_id}`;
        sendData(data, "../controllers/admin/dept_mgt_svc_view.php");
        document.querySelector("#dept_svc_title").innerHTML = "View Service";
        document.getElementById("update_dept_svc_edit").style.display = "block";
        document.getElementById("update_dept_svc_back").style.display = "block";
        document.getElementById("update_dept_svc").style.display = "none";
        document.getElementById("update_dept_svc_cancel").style.display = "none";

        document.getElementById("dept_svc_category_name").readOnly = true;
        document.getElementById("dept_svc_subcategory_name").readOnly = true;
        document.getElementById("dept_svc_docu_need").readOnly = true;
        document.getElementById("dept_svc_sbs_procedure").readOnly = true;
        document.getElementById("dept_svc_rfsp").readOnly = true;
        document.getElementById("dept_svc_estimate_time_transact").readOnly = true;
        document.getElementById("dept_svc_fees").readOnly = true;
        document.getElementById("dept_svc_procedure_filing_complaints").readOnly = true;
    })
    update_dept_svc_back.addEventListener('click', () => {
        document.getElementById("dept_svc_id").value = '';
        document.getElementById("dept_svc_category_name").value = '';
        document.getElementById("dept_svc_subcategory_name").value = '';
        document.getElementById("dept_svc_docu_need").value = '';
        document.getElementById("dept_svc_sbs_procedure").value = '';
        document.getElementById("dept_svc_rfsp").value = '';
        document.getElementById("dept_svc_estimate_time_transact").value = '';
        document.getElementById("dept_svc_fees").value = '';
        document.getElementById("dept_svc_procedure_filing_complaints").value = '';
        window.localStorage.removeItem("dept_svc_id");
        window.location.href = "../admin/dept_mgt_svc.php";
    })

</script>

<?php
}
include('footer.php');
?>