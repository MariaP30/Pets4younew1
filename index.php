<?php

session_start();

include_once '../PHP/DbConnection.php';

$donationMessage = null;

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
        $donationMessage = 'Donation successfully received!';
    } else {
        $donationMessage = 'Donation failed!';
    }
}

$stmt = $conn->query('SELECT * FROM pets WHERE is_adopted = 0');
$pets = $stmt->fetch_all(MYSQLI_ASSOC);

?>

<html>

<head>
    <meta charset="utf-8">
    <title>Pets4you</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body style="background-color: #afcae7;">
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="../PHP/Adoption.php">Adoption</a></li>
                <li><a href="../PHP/Donation.php">Donation</a></li>
                <li><a href="Report.html">Report</a></li>
            </ul>
        </nav>
        <div>
            <a href="../PHP/Register.php"><button>Register</button></a>
            <?php if(empty($_SESSION['user']['id'])) : ?>
                <a href="../PHP/Login.php"><button>Login</button></a>
            <?php else : ?>
                <a href="../PHP/Logout.php"><button>Hello, <?= $_SESSION['user']['username']; ?> Logout</button></a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Home Page Section -->
    <section id="home">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="margin-top: 40px;">Welcome to Pets4you!</h1>
                    <p>Find your perfect pet today! Adopt now! Save a life!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 style="text-align: center; margin-bottom: 20px;">Featured Pets for Adoption</h2>
                    <div class="row">
                        <?php if(!empty($pets)) : ?>
                            <?php $featuredPets = array_filter($pets, function($element) { return intval($element['is_featured']) === 1; }); ?>
                            <?php if (!empty($featuredPets)) : ?>
                                <?php foreach($featuredPets as $featuredPet) : ?>
                                    <div class="col-md-4" style="margin-bottom: 20px;">
                                        <img src="<?= $featuredPet['image_url']; ?>" alt="<?= $featuredPet['name']; ?>" width="200" height="300" style="display: block; margin: 0 auto;" />
                                        <p>Name: <?= $featuredPet['name']; ?></p>
                                        <p>Age: <?= $featuredPet['age']; ?></p>
                                        <p><?= $featuredPet['type']; ?></p>
                                        <a href="../PHP/Adoption.php?petId=<?= $featuredPet['id']; ?>#adoption-form" style="text-decoration: none;"><button class="button" id="adopt-now-btn" style="display: block; margin: 0 auto;">Adopt Now</button></a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Page Section -->
    <section id="donation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Donate to Help Shelters</h1>
                    <p>Please fill out the form below to make a donation:</p>
                    <form action="" method="POST" onsubmit="showConfirmation()">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                        <br>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <br>
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" min="1" required>
                        <br>
                        <button id="donate-btn" class="button" type="submit">Donate</button>
                    </form>

                    <?php if(!empty($donationMessage)) { ?>
                        <p class="error"><?php echo $donationMessage; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Adoption Page Section -->
    <section id="adoption">
        <div class="container" style="padding-top: 40px;">
            <div class="row">
                <h1 style="text-align: center; margin-bottom: 20px;">Pets Available for Adoption</h1>
                <?php if(!empty($pets)) : ?>
                    <?php foreach($pets as $pet) : ?>
                        <div class="col-md-4" style="margin-bottom: 20px;">
                            <img src="<?= $pet['image_url']; ?>" alt="<?= $pet['name']; ?>" width="200" height="300" style="display: block; margin: 0 auto;" />
                            <p>Name: <?= $pet['name']; ?></p>
                            <p>Age: <?= $pet['age']; ?></p>
                            <p><?= $pet['type']; ?></p>
                            <a href="../PHP/Adoption.php?petId=<?= $pet['id']; ?>#adoption-form"><button class="button" id="adopt-now-btn" style="display: block; margin: 0 auto;">Adopt Now</button></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="col-md-12">
                    <h2 style="text-align: center;">Contact Us</h2>
                    <ul style="text-align:center; list-style-type: none; padding: 0;">
                        <li>Phone: 07423411445</li>
                        <li>Email: info@pets4you.com</li>
                        <li>Address: 83 High Street, Luton, UK</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showConfirmation() {
            alert("Thank you for your donation!");
        }
    </script>

</body>

</html>