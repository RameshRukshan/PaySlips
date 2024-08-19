<!DOCTYPE html>

<?php
session_start();

include('db_connection.php'); 

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to error404 page if not an admin
    header("Location: pages/samples/error-404.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT * FROM employees WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();

if ($user_result->num_rows === 1) {
    $user = $user_result->fetch_assoc();
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
    $name = htmlspecialchars($firstName . ' ' . $lastName);
    $email = $user['email'];
} else {
    $username = "Unknown User";
    $email = "N/A";
}

$user_query->close();

$conn->close();

?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin | Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="index.html">
              <img src="assets/images/logo.svg" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
              <img src="assets/images/logo-mini.svg" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">Salary <span class="text-black fw-bold">Calculate</span></h1>
              <h3 class="welcome-sub-text">Calculate the Monthly Salary and Send the slip to user </h3>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            
           
            <li class="nav-item">
              <form class="search-form" action="#">
                <i class="icon-search"></i>
                <input type="search" class="form-control" placeholder="Search Here" title="Search here">
              </form>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="icon-bell"></i>
                <span class="count"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                <a class="dropdown-item py-3 border-bottom">
                  <p class="mb-0 fw-medium float-start">No new notifications </p>
                  <span class="badge badge-pill badge-primary float-end">View all</span>
                </a>
                
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-mail icon-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
                <a class="dropdown-item py-3">
                  <p class="mb-0 fw-medium float-start">You have 0 unread mails </p>
                  <span class="badge badge-pill badge-primary float-end">View all</span>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image"> 
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold"><?php echo htmlspecialchars($name); ?></p>
                  <p class="fw-light text-muted mb-0"><?php echo htmlspecialchars($email); ?></p>
                </div>
                <a class="dropdown-item" href="profile.php">
                  <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile
                </a>
                <a class="dropdown-item" href="logout.php">
                  <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Sign Out
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="admin_dashboard.php">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Options</li>
            
            <li class="nav-item">
              <a class="nav-link" href="salary_slips.php">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Salary Slips</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users.php">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">Users</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Calculate The Salary</h4>
                  <p class="card-description">For <span id="current-month"></span></p>
                  <!-- Your form elements go here -->
                

                <script>
                  $(document).ready(function() {
                    // Get the current month and year
                    const date = new Date();
                    const monthNames = [
                      "January", "February", "March", "April", "May", "June", 
                      "July", "August", "September", "October", "November", "December"
                    ];
                    const currentMonth = monthNames[date.getMonth()]; // Get the month name
                    const currentYear = date.getFullYear(); // Get the current year

                    // Set the current month and year in the HTML
                    $('#current-month').text(`${currentMonth} ${currentYear}`);
                  });
                </script>

                    <!-- User ID input and Search button -->
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" id="employee_id" class="form-control" placeholder="Employee's ID" aria-label="Employee's ID">
                        <div class="input-group-append">
                          <button class="btn btn-primary" id="searchBtn" type="button">Search</button>
                        </div>
                      </div>
                    </div>

                    <!-- Salary Info -->
                    <div class="form-group">
                      <label>Basic Salary + All Allowances</label>
                      <input type="text" id="salary_info" class="form-control" value="" aria-label="Salary Info" disabled>
                    </div>

                    <!-- OT Hours -->
                    <div class="form-group">
                      <label>OT Hours</label>
                      <div class="input-group">
                        <input type="number" id="ot_hours" class="form-control" placeholder="Enter OT hours">
                      </div>
                    </div>

                    <!-- Other Payments -->
                    <div class="form-group">
                      <label>Other Payments (LKR)</label>
                      <div class="input-group">
                        <input type="number" id="other_payments" class="form-control" placeholder="Enter other payments">
                      </div>
                    </div>

                    <!-- Calculate Button -->
                    <button type="button" id="calculateBtn" class="btn btn-primary me-2">Calculate</button>

                    <!-- Save Button -->
                    <button type="button" id="saveBtn" class="btn btn-success" style="display: none;">Save</button>

                    <!-- Display Total Salary -->
                    <h4 class="card-title mt-3">Total Salary: <span id="total_salary_display">0 LKR</span></h4>
                  </div>
                </div>
              </div>

              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
              <script>
                $(document).ready(function() {
                  let basicSalary = 0;
                  let totalSalary = 0;

                  // Search Button Click Event
                  $('#searchBtn').click(function() {
                    const employeeId = $('#employee_id').val();

                    // Fetch employee data
                    $.ajax({
                      url: 'fetch_employee_data.php',
                      method: 'POST',
                      data: { employee_id: employeeId },
                      success: function(response) {
                        console.log("Response from fetch_employee_data.php:", response);

                        if (response.status === 'success') {
                          // Populate the basic salary + allowances
                          basicSalary = parseFloat(response.data.basic_salary) + parseFloat(response.data.allowances);
                          $('#salary_info').val(`${basicSalary} LKR`);
                          $('#saveBtn').hide(); // Hide save button until Calculate is clicked
                        } else {
                          alert(response.message);
                        }
                      },
                      error: function(xhr, status, error) {
                        console.error("Error fetching employee data:", error);
                      }
                    });
                  });

                  // Calculate Button Click Event
                  $('#calculateBtn').click(function() {
                    const otHours = parseFloat($('#ot_hours').val()) || 0;
                    const otherPayments = parseFloat($('#other_payments').val()) || 0;
                    const otAmount = otHours * 5000;

                    // Calculate total salary
                    totalSalary = basicSalary + otAmount + otherPayments;
                    $('#total_salary_display').text(`${totalSalary} LKR`);
                    $('#saveBtn').show(); // Show save button after calculating
                  });

                  // Save Button Click Event
                  $('#saveBtn').click(function() {
                    const employeeId = $('#employee_id').val();
                    const otHours = parseFloat($('#ot_hours').val()) || 0;
                    const otherPayments = parseFloat($('#other_payments').val()) || 0;

                    // Save data to the database
                    $.ajax({
                      url: 'store_salary_slip.php',
                      method: 'POST',
                      data: {
                        employee_id: employeeId,
                        ot: otHours,
                        other: otherPayments,
                        total: totalSalary
                      },
                      success: function(response) {
                        console.log("Response from store_salary_slip.php:", response);

                        if (response.status === 'success') {
                          alert('Salary slip stored successfully!');
                        } else {
                          alert('Error: ' + response.message);
                        }
                      },
                      error: function(xhr, status, error) {
                        console.error("Error storing salary slip:", error);
                      }
                    });
                  });
                });
              </script>


              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Created By <a href="https://github.com/RameshRukshan" target="_blank">YR3COBSCCOMP23.2F-019</a> | Ramesh.</span>
              <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © 2024. All rights reserved.</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- jQuery and Bootstrap should be included -->
    
    <!-- jQuery and Bootstrap should be included -->
    

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
  </body>
</html>