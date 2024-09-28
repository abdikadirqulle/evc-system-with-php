<?php
include 'db.php';

// Send Money
function sendMoney($fromPhone, $toPhone, $amount) {
    global $conn;
    
    $fromUser = getUserByPhone($fromPhone);
    $toUser = getUserByPhone($toPhone);
    
    if (!$fromUser || !$toUser) {
        return "User not found.";
    }

    if ($fromUser['balance'] < $amount) {
        return "Insufficient balance.";
    }

    // Perform the transaction
    $conn->query("UPDATE users SET balance = balance - $amount WHERE phone = '$fromPhone'");
    $conn->query("UPDATE users SET balance = balance + $amount WHERE phone = '$toPhone'");
    
    // Log the transaction
    $conn->query("INSERT INTO transactions (sender_phone, receiver_phone, amount) VALUES ('$fromPhone', '$toPhone', $amount)");
    
    return "Transfer successful. You have sent $amount to " . $toUser['name'];
}


// Get User by Phone Number
function getUserByPhone($phone) {
    global $conn;
    $result = $conn->query("SELECT * FROM users WHERE phone = '$phone'");
    return $result->fetch_assoc();
}

// Check User Balance
function checkBalance($phone) {
    $user = getUserByPhone($phone);
    if (!$user) {
        return "User not found.";
    }
    return "Your balance is: " . $user['balance'];
}

function viewTransactions($phone) {
    global $conn;
    $result = $conn->query("SELECT * FROM transactions WHERE sender_phone = '$phone' OR receiver_phone = '$phone' ORDER BY transaction_date DESC");
    
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    
    return $transactions;
}

?>

