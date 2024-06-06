<?php
// Connect to the database (replace with your actual credentials)
$host = 'localhost';
$user = 'your_db_user';
$pass = 'your_db_password';
$dbname = 'your_db_name';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input
$petType = $_POST['petType'];
$breed = $_POST['breed'];
$age = $_POST['age'];

// Construct the SQL query
$sql = "SELECT * FROM pets WHERE type = ? AND breed LIKE ? AND age = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $petType, "%$breed%", $age);
$stmt->execute();

// Fetch results
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>{$row['name']} - {$row['description']}</p>";
    }
} else {
    echo "No matching pets found.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
