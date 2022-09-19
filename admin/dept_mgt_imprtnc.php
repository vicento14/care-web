<?php
include('header.php');
if ($_SESSION['dept_id'] == 0) {
    echo "<script>window.location.href = './dashboard.php';</script>";
} else {
?>

<title>CARE | Importance</title>

<div class="container-fluid">

    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success"><span>Department :</span></h6>
                    <h6><?php echo $dept_name; ?></h6>
                    <h6 class="m-0 font-weight-bold text-success"><span>Last Update:</span></h6>
                    <h6 id="dept_imprtnc_date_updated">01/23/2021</h6>
                </div>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Importance</h6>
                </div>
                <form>
                    <div class="form-group">
                        <textarea class="form-control" id="dept_imprtnc_details" name="dept_imprtnc_details" rows="13" placeholder="Department Content Here"></textarea>
                        <button type="button" class="btn btn-success btn-small" id="edit_dept_imprtnc_details" name="edit_dept_imprtnc_details">Edit</button>
                        <button type="submit" class="btn btn-success btn-small" id="update_dept_imprtnc_details" name="update_dept_imprtnc_details">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
    const edit_dept_imprtnc_details = document.querySelector('#edit_dept_imprtnc_details');
    const update_dept_imprtnc_details = document.querySelector('#update_dept_imprtnc_details');
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
            if(url == "../controllers/admin/dept_mgt_imprtnc_load.php"){
                let dept_imprtnc_array = JSON.parse(responseData);
                document.querySelector(`${html_el_id}`).value = dept_imprtnc_array.dept_imprtnc_details;
                document.getElementById("dept_imprtnc_date_updated").innerHTML = dept_imprtnc_array.date_updated;
            }
        });
    };

    // POST
    const sendData = (data, url, html_el_id) => {
        document.querySelector('#LoadModalTitle').innerHTML = "Department Management";
        document.querySelector('#LoadModalBody').innerHTML = "Changing Department Importance. Please wait...";
        $('#LoadModal').modal('show');
        sendHttpRequest('POST', url, data).then(responseData => {
            getData("../controllers/admin/dept_mgt_imprtnc_load.php", "#dept_imprtnc_details");
            setTimeout(function () {
                $('#LoadModal').modal('hide');
                document.querySelector('#MsgboxModalTitle').innerHTML = "Department Management";
                document.querySelector('#MsgboxModalBody').innerHTML = "Department Importance Changed Successfully";
                $('#MsgboxModal').modal('show');
            },500);
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

    getData("../controllers/admin/dept_mgt_imprtnc_load.php", "#dept_imprtnc_details");
    document.getElementById("update_dept_imprtnc_details").disabled = true;
    document.getElementById("dept_imprtnc_details").readOnly = true;

    edit_dept_imprtnc_details.addEventListener('click', () => {
        document.getElementById("update_dept_imprtnc_details").disabled = false;
        document.getElementById("dept_imprtnc_details").readOnly = false;
        document.getElementById("edit_dept_imprtnc_details").disabled = true;
    })

    update_dept_imprtnc_details.addEventListener('click', () => {
        let dept_imprtnc_details = document.querySelector("#dept_imprtnc_details").value;
        let data = `dept_imprtnc_details=${dept_imprtnc_details}`;
        sendData(data, "../controllers/admin/dept_mgt_imprtnc_update.php", "#dept_imprtnc_details");
        document.getElementById("update_dept_imprtnc_details").disabled = true;
        document.getElementById("dept_imprtnc_details").readOnly = true;
        document.getElementById("edit_dept_imprtnc_details").disabled = false;
    })
</script>

<?php
}
include('footer.php');
?>