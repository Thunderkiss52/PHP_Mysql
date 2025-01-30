<?php
include_once('db.php');
include_once('model.php');

$user_id = isset($_GET['user']) ? (int)$_GET['user'] : null;

if ($user_id) {
    //here i've got connect with database to get some user transaction.
    $conn = get_connect();
    $transactions = get_user_transactions_balances($user_id, $conn);
    echo json_encode($transactions);
} else {
    //if not, im throw http error, bcs i've need user id  to get user transaction
    http_response_code(400);
    echo json_encode(['error' => 'User ID is required']);
}
?>