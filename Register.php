<?php

include_once 'DbConnection.php';

$message = null;

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Username or email already taken!";
    } else if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $conn->prepare('INSERT INTO users(username, email, password) VALUES (?, ?, ?)');

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute() === true) {
            $message = "Registration successful.";
        } else {
            $message = "Registration failed.";
        }

        $stmt->close();
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/style.css" />
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../HTML/index.php">Home</a></li>
                <li><a href="../PHP/Adoption.php">Adoption</a></li>
                <li><a href="../PHP/Donation.php">Donation</a></li>
                <li><a href="../HTML/Report.html">Report</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Register</h2>
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" required><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br>

            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br>

            <input type="submit" value="Register">
        </form>

        <?php if(!empty($message)) { ?>
            <p class="error"><?php echo $message; ?></p>
        <?php } ?>
    </main>
</body>

</html>