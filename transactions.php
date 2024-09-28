<?php
include 'functions.php';

$phone = '';
$transactions = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $transactions = viewTransactions($phone);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

 <!-- Navbar -->
 <nav class="navbar">
        <div class="container">
            <h2 class="logo">EVC System</h2>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="send_money.php">Send Money</a></li> <!-- New Send Money Link -->
                <li><a href="transactions.php">Transaction History</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
</nav>

        <h1>Transaction History</h1>

        <!-- Check Transaction History Form -->
        <form method="POST" action="">
            <label for="phone">Your Phone Number:</label><br>
            <input type="text" name="phone" value="<?php echo $phone; ?>" required><br><br>
            <input type="submit" value="View Transactions">
        </form>

        <!-- Display Transaction History -->
        <?php if (!empty($transactions)): ?>
            <h2>Transactions for <?php echo $phone; ?></h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo $transaction['sender_phone']; ?></td>
                            <td><?php echo $transaction['receiver_phone']; ?></td>
                            <td><?php echo $transaction['amount']; ?></td>
                            <td><?php echo $transaction['transaction_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($phone): ?>
            <p>No transactions found for <?php echo $phone; ?>.</p>
        <?php endif; ?>
    </div>

     <!-- Include the footer -->
     <?php include 'footer.php'; ?>
</body>
</html>
