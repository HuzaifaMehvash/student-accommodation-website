<?php
include 'includes/db.php';

$msg = "";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash password for security
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hash')";
    
    if (mysqli_query($conn, $query)) {
        $msg = "Registration successful! Please <a href='login.php'>Login</a>";
    } else {
        $msg = "Error: Email might already exist.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <p class="text-success"><?php echo $msg; ?></p>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
                        <a href="login.php" class="btn btn-link">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>