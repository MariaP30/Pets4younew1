<?php

include_once 'DbConnection.php';

$adoptionMessage = null;
$selectedPetToAdopt = null;

if (isset($_GET['petId'])) {
    $selectedPetToAdopt = $_GET['petId'];
}

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pet'])) {
    $petId = $_POST['pet'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = null;

    if(isset($_POST['phone'])) {
        $phone = $_POST['phone'];
    }

    $stmt = $conn->prepare('INSERT INTO adoptions(pet_id, name, email, phone) VALUES (?, ?, ?, ?)');

    $stmt->bind_param("ssss", $petId, $name, $email, $phone);

    $stmtAdopt = $conn->prepare('UPDATE pets SET is_adopted = 1 WHERE id = ?');

    $stmtAdopt->bind_param("s", $petId);
    
    if($stmt->execute() === true && $stmtAdopt->execute() === true) {
        $adoptionMessage = 'Animal adopted successfully, thank you!';
    } else {
        $adoptionMessage = 'Failed to adopt animal!';
    }
}

$stmt = $conn->query('SELECT * FROM pets WHERE is_adopted = 0');
$pets = $stmt->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pets4you - Adoption</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../HTML/index.php">Home</a></li>
                <li><a href="Adoption.php">Adoption</a></li>
                <li><a href="../PHP/Donation.php">Donation</a></li>
                <li><a href="../HTML/Report.html">Report</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Adopt a Pet</h1>
        <p>Choose your new furry friend from the list of available pets.</p>

        <section>
            <h2 style="text-align: center;">List of Available Pets</h2>
            <ul style="list-style-type: none; padding: 0;">
                <?php if(!empty($pets)) : ?>
                    <?php foreach($pets as $pet) : ?>
                        <li style="margin-bottom: 50px;">
                            <img src="<?= $pet['image_url']; ?>" alt="<?= $pet['name']; ?>" width="500" >
                            <h3 style="text-align: center;"><?= $pet['name']; ?></h3>
                            <p>Breed: <?= !empty($pet['breed']) ? $pet['breed'] : '-'; ?></p>
                            <p>Age: <?= !empty($pet['age']) ? $pet['age'] : '-'; ?></p>
                            <p>Gender: <?= !empty($pet['gender']) ? ($pet['gender'] === 'm' ? 'Male' : 'Female') : '-'; ?></p>
                            <a href="Adoption.php?petId=<?= $pet['id']; ?>#adoption-form" style="text-decoration: none;"><button style="display: block; margin: 0 auto;">Adopt Me</button></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </section>

        <section id="adoption-form" style="width: 100%">
            <h2 style="text-align: center;">Adoption Form</h2>
            <form action="" method="POST">
                <label for="pet">Pet:</label>
                <select id="pet" name="pet" required>
                    <?php if(!empty($pets)) : ?>
                        <?php foreach($pets as $pet) : ?>
                            <option value="<?= $pet['id']; ?>" <?= !empty($selectedPetToAdopt) && $selectedPetToAdopt === $pet['id'] ? 'selected' : '' ?>><?= $pet['name']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select><br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone"><br>

                <button type="submit">Submit</button>
            </form>

            <?php if(!empty($adoptionMessage)) { ?>
                <p class="error"><?php echo $adoptionMessage; ?></p>
            <?php } ?>
        </section>
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
</body>

</html>