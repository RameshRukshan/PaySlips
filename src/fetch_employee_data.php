<?php
// Include database connection
include('db_connection.php');

header('Content-Type: application/json');

$response = [];

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Fetch employee salary data
    $query = "SELECT salaries.basic_salary, (salaries.travel_all + salaries.meal_all + salaries.other_all) as allowances 
              FROM employees 
              JOIN salaries ON employees.user_id = salaries.user_id 
              WHERE employees.user_id = ?";
              
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['data'] = $data;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Employee not found.';
        }
        
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error preparing statement: ' . $conn->error;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'No employee ID provided.';
}

$conn->close();
echo json_encode($response);
?>