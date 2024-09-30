<?php
include 'functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'send') {
        $fromPhone = $_POST['from_phone'];
        $toPhone = $_POST['to_phone'];
        $amount = $_POST['amount'];
        $message = sendMoney($fromPhone, $toPhone, $amount);
    } elseif ($_POST['action'] == 'balance') {
        $phone = $_POST['phone'];
        $message = checkBalance($phone);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple EVC System</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
     <!-- Navbar -->
     <nav class="navbar">
        <div class="container">
            <h2 class="logo">EVC System</h2>
            <ul class="nav-links">
                <li><a href="index.php">Check Balance</a></li>
                <li><a href="send_money.php">Send Money</a></li> <!-- New Send Money Link -->
                <li><a href="transactions.php">Transaction History</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <h1>Check Balance (Itus Hadhaaga)</h1>

       <br />

        <!-- Check Balance Form -->
        <form method="POST" action="">
            <input type="hidden" name="action" value="balance">
            <!-- <br> -->
            <label for="phone">Your Phone Number:</label>
            <input type="text" name="phone" required>
            <br>
            <br>
            <input type="submit" value="Check Balance">
        </form>
 <!-- Display message -->
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

     <!-- Include the footer -->
     <?php include 'footer.php'; ?>
</body>
</html>
