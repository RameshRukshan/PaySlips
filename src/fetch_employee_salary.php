<?php
include('db_connection.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Fetch the employee based on username
    $stmt = $conn->prepare("SELECT e.user_id AS employee_id, e.position, s.basic_salary, s.travel_all, s.meal_all, s.other_all 
                            FROM employees e
                            JOIN users u ON e.user_id = u.user_id
                            JOIN salaries s ON e.user_id = s.user_id
                            WHERE u.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $basic_salary = $row['basic_salary'];
        $allowances = $row['travel_all'] + $row['meal_all'] + $row['other_all'];

        echo json_encode([
            'status' => 'success',
            'employee_id' => $row['employee_id'],
            'basic_salary' => $basic_salary,
            'allowances' => $allowances,
            'position' => $row['position']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Employee not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
