<?php
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $no_ofdays = $_POST['days'];

    // Establish database connection
    $con = new mysqli('127.0.0.1', 'root', '', 'car_rent');

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO services (username, address, age, no_of_days) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $username, $address, $age, $no_ofdays);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['address'] = $address;
        $_SESSION['days'] = $no_ofdays;
        
        // Inform the user and redirect
        echo '<script>
            alert("Registered Successfully");
            window.open("details.php", "_self");
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>
