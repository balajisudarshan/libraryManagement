<?php
session_start();

$error = '';  // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'library_management');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['userType'] = $user['userType'];

            if ($user['userType'] == 'Admin') {
                header("Location: ./components/adminDashboard.php?username=" . $_SESSION['username']);
            } else {
                header("Location: user_dashboard.php");
            }
            
            exit();
        } else {
            // Set error message in session and redirect
            $_SESSION['error'] = "Invalid password. Please try again.";
            header("Location: ./index.php"); // Redirect back to login page
            exit();
        }
    } else {
        // Set error message in session and redirect
        $_SESSION['error'] = "No user found with that username.";
        header("Location: ./index.php"); // Redirect back to login page
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
