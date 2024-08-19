<?php
// Include database connection
include('db_connection.php');

header('Content-Type: application/json');

$response = [];

if (isset($_POST['employee_id'], $_POST['ot'], $_POST['other'], $_POST['total'])) {
    $employee_id = $_POST['employee_id'];
    $ot = $_POST['ot'];
    $other = $_POST['other'];
    $total = $_POST['total'];

    $date_created = date('Y-m-d H:i:s');

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO salary_slip (user_id, date_created, ot, other, total) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("issss", $employee_id, $date_created, $ot, $other, $total);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Salary slip stored successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error executing query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error preparing statement: ' . $conn->error;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Missing required data.';
}

$conn->close();
echo json_encode($response);
?>