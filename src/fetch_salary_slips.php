<?php
// Include database connection
include('db_connection.php');

// Query to fetch data from the salary_slip table, join with employees and salaries tables
$query = "
    SELECT 
        ss.user_id, 
        e.first_name, 
        e.last_name, 
        e.position, 
        ss.date_created, 
        s.basic_salary, 
        s.travel_all, 
        s.meal_all, 
        s.other_all,
        ss.other, 
        ss.total
    FROM 
        salary_slip ss
    JOIN 
        employees e ON ss.user_id = e.user_id
    JOIN 
        salaries s ON e.user_id = s.user_id
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Loop through the result and display the data in the table
    while ($row = $result->fetch_assoc()) {
        // Calculate month and year from created_date
        $created_date = new DateTime($row['date_created']);
        $month = $created_date->format('F');  // Full month name
        $year = $created_date->format('Y');   // Year

        // Calculate gross salary
        $gross_salary = $row['total'];

        echo '<tr>';
        echo '  <td>';
        echo '      <div class="form-check form-check-flat mt-0">';
        echo '          <label class="form-check-label">';
        echo '              <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i>';
        echo '          </label>';
        echo '      </div>';
        echo '  </td>';
        echo '  <td>';
        echo '      <div class="d-flex">';
        echo '          <div>';
        echo '              <h6>' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . '</h6>';
        echo '              <p>' . htmlspecialchars($row['position']) . '</p>';
        echo '          </div>';
        echo '      </div>';
        echo '  </td>';
        echo '  <td>';
        echo '      <h6>' . $month . '</h6>';
        echo '      <p>' . $year . ' | ' . $row['date_created'] . '</p>';
        echo '  </td>';
        echo '  <td><h6>' . htmlspecialchars($row['position']) . '</h6></td>';
        echo '  <td>';
        echo '      <h6>' . number_format($row['basic_salary'], 2) . '</h6>';
        echo '      <p>LKR</p>';
        echo '  </td>';
        echo '  <td>';
        echo '      <h6>' . number_format($row['travel_all'] + $row['meal_all'] + $row['other_all'], 2) . '</h6>';
        echo '      <p>LKR</p>';
        echo '  </td>';
        echo '  <td>';
        echo '      <h6>' . number_format($row['other'], 2) . '</h6>';
        echo '      <p>LKR</p>';
        echo '  </td>';
        echo '  <td>';
        echo '      <h6>' . number_format($gross_salary, 2) . '</h6>';
        echo '      <p>LKR</p>';
        echo '  </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8">No salary slips found</td></tr>';
}

$conn->close();

?>