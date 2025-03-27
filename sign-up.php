<?php
session_start();
include 'db.php'; // Make sure this points to your DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        // Show alert, redirect back to signup page
        echo "<script>
            alert('Please fill out all fields.');
            window.location.href = 'signup.html';
        </script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        // Show DB error
        echo "<script>
            alert('DB Error: " . $conn->error . "');
            window.location.href = 'signup.html';
        </script>";
        exit();
    }

    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Success -> Alert & redirect to home
        echo "<script>
            alert('Signed up successfully!');
            window.location.href = 'index.html';
        </script>";
    } else {
        // Error (duplicate email, etc.)
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'signup.html';
        </script>";
    }
    $stmt->close();
} else {
    // If accessed without POST
    echo "<script>
        alert('Invalid request. Please submit the signup form.');
        window.location.href = 'signup.html';
    </script>";
}
?>
