<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>
            alert('Please fill out all fields.');
            window.location.href = 'login.html';
        </script>";
        exit();
    }

    // Look up the user
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    if (!$stmt) {
        echo "<script>
            alert('DB Error: " . $conn->error . "');
            window.location.href = 'login.html';
        </script>";
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        // Verify hashed password
        if (password_verify($password, $hashedPassword)) {
            // Valid login -> optional session usage
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_email'] = $email;

            echo "<script>
                alert('Login successful!');
                window.location.href = 'index.html';
            </script>";
        } else {
            echo "<script>
                alert('Incorrect password.');
                window.location.href = 'login.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('No account found with that email.');
            window.location.href = 'login.html';
        </script>";
    }
    $stmt->close();
} else {
    // If accessed without POST
    echo "<script>
        alert('Invalid request. Please submit the login form.');
        window.location.href = 'login.html';
    </script>";
}
?>
