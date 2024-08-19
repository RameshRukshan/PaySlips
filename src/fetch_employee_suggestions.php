<?php
include('db_connection.php');

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $stmt = $conn->prepare("SELECT user_id, first_name, last_name FROM employees WHERE first_name LIKE ? OR last_name LIKE ?");
    $likeQuery = "%".$query."%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<p class="employee_suggestion" data-id="'.$row['user_id'].'">'.$row['first_name'].' '.$row['last_name'].'</p>';
        }
    } else {
        echo '<p>No suggestions found</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
