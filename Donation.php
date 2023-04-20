<?php

include_once 'DbConnection.php';

$message = null;

if (!empty($_POST['name']) && !empty($_POST['email']) && isset($_POST['amount'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $message = null;

    if (!empty($_POST['message'])) {
        $message = $_POST['message'];
    }

    $stmt = $conn->prepare('INSERT INTO donations(name, email, amount, message) VALUES (?, ?, ?, ?)');

    $stmt->bind_param("ssss", $name, $email, $amount, $message);
    
    if($stmt->execute() === true) {
        $message = 'Donation successfully received!';
    } else {
        $message = 'Donation failed!';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Donation Page</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">

</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../HTML/index.php">Home</a></li>
                <li><a href="../PHP/Adoption.php">Adoption</a></li>
                <li><a href="Donation.php">Donation</a></li>
                <li><a href="../HTML/Report.html">Report</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Donation Page</h1>
        <p>Please fill out the form below to donate:</p>
        <form action="" method="post" onsubmit="showConfirmation()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required><br><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="5" cols="30"></textarea><br><br>

            <button type="submit">Donate Now</button>
        </form>

        <?php if(!empty($message)) { ?>
            <p class="error"><?php echo $message; ?></p>
        <?php } ?>
    </main>

    <footer>
        <h2 style="text-align:center;">Contact us:</h2>
        <ul style="text-align:center; list-style-type: none; padding: 0;">
            <li><a href="Tel:07423411445">Phone:07423411445</a></li>
            <li><a href="Email:info@pets4you.com">Email:info@pets4you.com</a></li>
            <li><a href="83 High Street, Luton, Uk">Address:83 High Steet, Luton, UK</a></li>
        </ul>
    </footer>

    <script src="JS/script.js"></script>
    <script>
        function showConfirmation() {
            alert("Thank you for your donation!");
        }
    </script>
</body>

</html>