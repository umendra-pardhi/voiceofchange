<?php

session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../"); 
    exit();
}

include("../../config/db.php");



// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare SQL query to fetch user data based on the email
    $sql = "SELECT id, name,email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, now verify the password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "<script>window.location.href = '../';</script>"; // Redirect to dashboard
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }

    // Close statement
    $stmt->close();
}

$conn->close();
?>