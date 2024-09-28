<?php
include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_phone = $_POST['sender_phone'];
    $receiver_phone = $_POST['receiver_phone'];
    $amount = $_POST['amount'];

    // Validate inputs
    if (!empty($sender_phone) && !empty($receiver_phone) && !empty($amount)) {
        // Check if sender has enough balance
        $stmt = $conn->prepare("SELECT balance FROM users WHERE phone = ?");
        $stmt->bind_param("s", $sender_phone);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();
        $stmt->close();

        if ($balance >= $amount) {
            // Deduct amount from sender
            $stmt = $conn->prepare("UPDATE users SET balance = balance - ? WHERE phone = ?");
            $stmt->bind_param("ds", $amount, $sender_phone);
            $stmt->execute();
            $stmt->close();

            // Add transaction record
            $stmt = $conn->prepare("INSERT INTO transactions (sender_phone, receiver_phone, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $sender_phone, $receiver_phone, $amount);
            $stmt->execute();
            $stmt->close();

            // Add amount to receiver
            $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE phone = ?");
            $stmt->bind_param("ds", $amount, $receiver_phone);
            $stmt->execute();
            $stmt->close();

            $message = "<p style='color: green;'>Money sent successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Insufficient balance.</p>";
        }
    } else {
        $message = "<p style='color: red;'>Please fill in all fields.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Money</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->

    <style>
        
/* Page Title */
h1 {
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

/* Form Styles */
form {
  max-width: 400px; /* Limit the width of the form */
  margin: 0 auto; /* Center the form */
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: white; /* Form background color */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin: 15px 0 5px;
  font-weight: bold;
}

    </style>
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
    <h1>Send Money</h1>
    <form method="POST" action="">
        <label for="sender_phone">Sender Phone:</label>
        <input type="text" id="sender_phone" name="sender_phone" required>

        <label for="receiver_phone">Receiver Phone:</label>
        <input type="text" id="receiver_phone" name="receiver_phone" required>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>

        <input type="submit" value="Send Money">

        <?php if (isset($message)) echo $message; ?>

    </form>

     <!-- Include the footer -->
     <?php include 'footer.php'; ?>
</body>
</html>
