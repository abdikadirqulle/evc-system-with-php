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
                <li><a href="index.php">Home</a></li>
                <li><a href="transactions.php">Transaction History</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <h1>Simple EVC System</h1>

        <!-- Display message -->
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Check Balance Form -->
        <h2>Check Balance</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="balance">
            <label for="phone">Your Phone Number:</label><br>
            <input type="text" name="phone" required><br><br>
            <input type="submit" value="Check Balance">
        </form>

        <!-- Send Money Form -->
        <h2>Send Money</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="send">
            <label for="from_phone">Your Phone Number:</label><br>
            <input type="text" name="from_phone" required><br>
            
            <label for="to_phone">Recipient's Phone Number:</label><br>
            <input type="text" name="to_phone" required><br>

            <label for="amount">Amount:</label><br>
            <input type="number" name="amount" required><br><br>
            
            <input type="submit" value="Send Money">
        </form>
    </div>
</body>
</html>
