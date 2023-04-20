<?php

include_once 'DbConnection.php';

if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $hashed_password = null;
    $db_username = null;
    
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->store_result();
   
    if($stmt->num_rows === 1) {
        $stmt->bind_result($id, $db_username, $hashed_password);
        $stmt->fetch();
        
        if(password_verify($password, $hashed_password)) {
            session_start();

            $_SESSION['user'] = array(
                'id'=>$id,
                'username'=>$db_username
            );
            
            header('Location: ../HTML/index.php');
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	
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
        <form action="" method="post">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
        
        <?php if(!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </main>
    
</body>
</html>
