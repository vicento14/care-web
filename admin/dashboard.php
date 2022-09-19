<?php  include('header.php');?>

<title>CARE | Main Form</title>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">General Details</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="refresh_dashboard">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>  

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" id="total_complaints_title">
                                                Total Complaints
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_complaints"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" id="total_concerns_title">
                                                Total Concerns
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_concerns"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Total Departments </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_dept"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-building fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Total Barangays </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_brgy"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Graph -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary">Number of registered residents per barangays</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart1" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary">Number of concerns and complaints per barangays</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart2" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary">Number of concerns and complaints of each local government office</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart3" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary">Total numbers of concerns and complaints in a month</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart4" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary">Total App Sentiment</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart5" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-secondary" id="report_ratings_title"></h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart6" width="400" height="400"></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12" id="logs" <?php if($dept_id != 0) echo " style='display: none';"; ?>></div>

                        <div class="col-lg-12" id="notif" <?php if($dept_id == 0) echo " style='display: none';"; ?>></div>
                        
                    </div>

                </div>

            </div>
            <!-- End of Main Content -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <script>
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
    const getDashboardData = (url) => {
        sendHttpRequest('GET', url).then(responseData => {
            var data;
            var colors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
            var colors2 = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];
            var backgroundColors = [];
            var backgroundColors2 = [];
            var borderColors = [];
            var borderColors2 = [];
            if (url == "../controllers/admin/dashboard_details_mainadmin.php") {
                data = JSON.parse(responseData);
                document.getElementById("total_complaints").innerHTML = data.total_complaints;
                document.getElementById("total_concerns").innerHTML = data.total_concerns;
                document.getElementById("total_dept").innerHTML = data.total_dept;
                document.getElementById("total_brgy").innerHTML = data.total_brgy;
            } else if (url == "../controllers/admin/dashboard_details_deptadmin.php") {
                data = JSON.parse(responseData);
                document.getElementById("total_complaints").innerHTML = data.total_dept_complaints;
                document.getElementById("total_concerns").innerHTML = data.total_dept_concerns;
                document.getElementById("total_dept").innerHTML = data.total_dept;
                document.getElementById("total_brgy").innerHTML = data.total_brgy;
                document.getElementById("total_complaints_title").innerHTML = "Total Department Complaints";
                document.getElementById("total_concerns_title").innerHTML = "Total Department Concerns";
            } else if (url == "../controllers/admin/dashboard_chart1.php") {
                backgroundColors = [];
                borderColors = [];
                data = JSON.parse(responseData);
                for (var i = 0; i < data.barangays_array.length; i++) {
                    backgroundColors.push(colors[i % colors.length]);  
                }
                for (var i = 0; i < data.barangays_array.length; i++) {
                    borderColors.push(colors2[i % colors2.length]);  
                }
                var ctx1 = document.getElementById('myChart1').getContext('2d');
                var myChart1 = new Chart(ctx1, {
                    type: 'horizontalBar',
                    data: {
                        labels: data.barangays_array,
                        datasets: [{
                            label: 'Number of registered residents',
                            data: data.number_of_residents_array,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else if (url == "../controllers/admin/dashboard_chart2.php") {
                backgroundColors = [];
                backgroundColors2 = [];
                borderColors = [];
                borderColors2 = [];
                data = JSON.parse(responseData);
                for (var i = 0; i < data.barangays_array.length; i++) {
                    backgroundColors.push(colors[0 % colors.length]);
                    backgroundColors2.push(colors[1 % colors.length]);
                    borderColors.push(colors2[0 % colors2.length]);
                    borderColors2.push(colors2[1 % colors2.length]);
                }
                var ctx2 = document.getElementById('myChart2').getContext('2d');
                var myChart2 = new Chart(ctx2, {
                    type: 'horizontalBar',
                    data: {
                        labels: data.barangays_array,
                        datasets: [{
                            label: 'Number of Complaints',
                            data: data.number_of_complaints_array,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        },
                        {
                            label: 'Number of Concerns',
                            data: data.number_of_concerns_array,
                            backgroundColor: backgroundColors2,
                            borderColor: borderColors2,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else if (url == "../controllers/admin/dashboard_chart3.php") {
                backgroundColors = [];
                backgroundColors2 = [];
                borderColors = [];
                borderColors2 = [];
                data = JSON.parse(responseData);
                for (var i = 0; i < data.dept_array.length; i++) {
                    backgroundColors.push(colors[0 % colors.length]);
                    backgroundColors2.push(colors[1 % colors.length]);
                    borderColors.push(colors2[0 % colors2.length]);
                    borderColors2.push(colors2[1 % colors2.length]);
                }
                var ctx3 = document.getElementById('myChart3').getContext('2d');
                var myChart3 = new Chart(ctx3, {
                    type: 'horizontalBar',
                    data: {
                        labels: data.dept_array,
                        datasets: [{
                            label: 'Number of Complaints',
                            data: data.number_of_complaints_array,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        },
                        {
                            label: 'Number of Concerns',
                            data: data.number_of_concerns_array,
                            backgroundColor: backgroundColors2,
                            borderColor: borderColors2,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else if (url == "../controllers/admin/dashboard_chart5.php") {
                backgroundColors = [];
                backgroundColors2 = [];
                backgroundColors3 = [];
                borderColors = [];
                borderColors2 = [];
                borderColors3 = [];
                data = JSON.parse(responseData);
                backgroundColors.push(colors[3 % colors.length]);
                backgroundColors2.push(colors[2 % colors.length]);
                backgroundColors3.push(colors[0 % colors.length]);
                borderColors.push(colors2[3 % colors2.length]);
                borderColors2.push(colors2[2 % colors2.length]);
                borderColors3.push(colors2[0 % colors2.length]);
                var ctx5 = document.getElementById('myChart5').getContext('2d');
                var myChart5 = new Chart(ctx5, {
                    type: 'bar',
                    data: {
                        labels: ["Number of App Sentiment"],
                        datasets: [{
                            label: 'Positive',
                            data: [data.app_positive],
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        },
                        {
                            label: 'Neutral',
                            data: [data.app_neutral],
                            backgroundColor: backgroundColors2,
                            borderColor: borderColors2,
                            borderWidth: 1
                        },
                        {
                            label: 'Negative',
                            data: [data.app_negative],
                            backgroundColor: backgroundColors3,
                            borderColor: borderColors3,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else if (url == "../controllers/admin/dashboard_chart6.php") {
                backgroundColors = [];
                backgroundColors2 = [];
                backgroundColors3 = [];
                borderColors = [];
                borderColors2 = [];
                borderColors3 = [];
                data = JSON.parse(responseData);
                backgroundColors.push(colors[3 % colors.length]);
                backgroundColors2.push(colors[2 % colors.length]);
                backgroundColors3.push(colors[0 % colors.length]);
                borderColors.push(colors2[3 % colors2.length]);
                borderColors2.push(colors2[2 % colors2.length]);
                borderColors3.push(colors2[0 % colors2.length]);
                var ctx6 = document.getElementById('myChart6').getContext('2d');
                var myChart6 = new Chart(ctx6, {
                    type: 'bar',
                    data: {
                        labels: ["Number of Report Sentiment"],
                        datasets: [{
                            label: 'Positive',
                            data: [data.report_positive],
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        },
                        {
                            label: 'Neutral',
                            data: [data.report_neutral],
                            backgroundColor: backgroundColors2,
                            borderColor: borderColors2,
                            borderWidth: 1
                        },
                        {
                            label: 'Negative',
                            data: [data.report_negative],
                            backgroundColor: backgroundColors3,
                            borderColor: borderColors3,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    };

    // POST
    const sendData = (data, url) => {
        sendHttpRequest('POST', url, data).then(responseData => {
            var data;
            var colors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
            var colors2 = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];
            var backgroundColors = [];
            var backgroundColors2 = [];
            var borderColors = [];
            var borderColors2 = [];
            if (url == "../controllers/admin/dashboard_chart4.php") {
                backgroundColors = [];
                backgroundColors2 = [];
                borderColors = [];
                borderColors2 = [];
                data = JSON.parse(responseData);
                for (var i = 0; i < data.months_array.length; i++) {
                    borderColors.push(colors2[0 % colors2.length]);
                    borderColors2.push(colors2[1 % colors2.length]);
                }
                var ctx4 = document.getElementById('myChart4').getContext('2d');
                var myChart4 = new Chart(ctx4, {
                    type: 'line',
                    data: {
                        labels: data.months_array,
                        datasets: [{
                            label: 'Number of Complaints',
                            data: data.number_of_complaints_array,
                            fill: false,
                            borderColor: borderColors,
                            borderWidth: 2,
                            tension: 0.2
                        },
                        {
                            label: 'Number of Concerns',
                            data: data.number_of_concerns_array,
                            fill: false,
                            borderColor: borderColors2,
                            borderWidth: 2,
                            tension: 0.2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }).catch(err => {
            console.log(err);
        });
    };

    <?php if ($dept_id == 0) {?>
        getDashboardData("../controllers/admin/dashboard_details_mainadmin.php");
        document.getElementById("report_ratings_title").innerHTML = "Total Report Sentiment";
    <?php } else {?>
        getDashboardData("../controllers/admin/dashboard_details_deptadmin.php");
        document.getElementById("report_ratings_title").innerHTML = "Total Report Sentiment on your department";
    <?php } ?>
    getDashboardData("../controllers/admin/dashboard_chart1.php");
    getDashboardData("../controllers/admin/dashboard_chart2.php");
    getDashboardData("../controllers/admin/dashboard_chart3.php");
    sendData(`year=<?php echo date("Y"); ?>`, "../controllers/admin/dashboard_chart4.php");
    getDashboardData("../controllers/admin/dashboard_chart5.php");
    getDashboardData("../controllers/admin/dashboard_chart6.php");

    const refresh_dashboard = document.querySelector("#refresh_dashboard");
    refresh_dashboard.addEventListener('click', () => {
        <?php if ($dept_id == 0) {?>
            getDashboardData("../controllers/admin/dashboard_details_mainadmin.php");
        <?php } else {?>
            getDashboardData("../controllers/admin/dashboard_details_deptadmin.php");
        <?php } ?>
        getDashboardData("../controllers/admin/dashboard_chart1.php");
        getDashboardData("../controllers/admin/dashboard_chart2.php");
        getDashboardData("../controllers/admin/dashboard_chart3.php");
        sendData(`year=<?php echo date("Y"); ?>`, "../controllers/admin/dashboard_chart4.php");
        getDashboardData("../controllers/admin/dashboard_chart5.php");
        getDashboardData("../controllers/admin/dashboard_chart6.php");
    })
    </script>

<?php include('footer.php');?>
