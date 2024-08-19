<!DOCTYPE html>

<?php
session_start();

include('db_connection.php'); 

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
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

// Get the slip ID from the URL
$slip_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Prepare SQL query to fetch data
$sql = "
    SELECT 
        e.first_name, e.last_name, e.gender, e.dob, e.position, e.email,
        s.basic_salary, s.travel_all, s.meal_all, s.other_all,
        ss.date_created, ss.ot, ss.other, ss.total
    FROM 
        employees e
    JOIN 
        salaries s ON e.user_id = s.user_id
    JOIN 
        salary_slip ss ON e.user_id = ss.user_id
    WHERE 
        ss.row_id = ? AND e.user_id = ?
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ii", $slip_id, $_SESSION['user_id']);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $slip = $result->fetch_assoc();
} else {
    echo "No salary slip found.";
    exit();
}

$stmt->close();

?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin | User </title>
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
              <h1 class="welcome-text">August <span class="text-black fw-bold"> Salary Slip</span></h1>
              <h3 class="welcome-sub-text">Your salary slip for August Month </h3>
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
              <a class="nav-link" href="User Dashboard.html">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Options</li>
            
            <li class="nav-item">
              <a class="nav-link" href="U_salary_slip.html">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">My Salary Slip</span>
              </a>
            </li>
            
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                
              <div class="card">
                  <div class="card-body">
                      <h4 class="card-title">Employee Details</h4>
                      <p>Name: <?php echo htmlspecialchars($slip['first_name'] . ' ' . $slip['last_name']); ?></p>
                      <p>Position: <?php echo htmlspecialchars($slip['position']); ?></p>
                      <p>Email: <?php echo htmlspecialchars($slip['email']); ?></p>
                      <p>Date of Birth: <?php echo htmlspecialchars($slip['dob']); ?></p>
                      <p>Gender: <?php echo htmlspecialchars($slip['gender']); ?></p>
                  </div>
                  <div class="card-body">
                      <h4 class="card-title">Salary Details</h4>
                      <p>Basic Salary: <?php echo number_format($slip['basic_salary'], 2); ?></p>
                      <p>Travel Allowance: <?php echo number_format($slip['travel_all'], 2); ?></p>
                      <p>Meal Allowance: <?php echo number_format($slip['meal_all'], 2); ?></p>
                      <p>Other Allowance: <?php echo number_format($slip['other_all'], 2); ?></p>
                      <p>Overtime: <?php echo number_format($slip['ot'], 2); ?></p>
                      <p>Other Earnings: <?php echo number_format($slip['other'], 2); ?></p>
                      <p>Total Salary: <?php echo number_format($slip['total'], 2); ?></p>
                  </div>
             
                  <div class="card-body">
                      <h4 class="card-title">Salary Slip Information</h4>
                      <p>Date Created: <?php echo htmlspecialchars($slip['date_created']); ?></p>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Created By <a href="https://github.com/RameshRukshan" target="_blank">YR3COBSCCOMP23.2F-019</a> | Ramesh Rukshan</span>
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