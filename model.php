<?php

/**
 * Return list of users.
 */
function get_users($conn) {
    // it's init func, so it's important get here check connection with database
    if ($conn === null) {
        echo "Connection is not established.";
        return [];
    }

    //get all users
    $stmt = $conn->query("SELECT id, name FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn): array
{
    $stmt = $conn->prepare("
        SELECT 
            t.id AS transaction_id,
            t.amount,
            strftime('%Y-%m', t.trdate) AS month -- Используем правильное имя столбца 'trdate'
        FROM 
            user_accounts ua 
        JOIN 
            transactions t ON ua.id = t.account_from OR ua.id = t.account_to
        WHERE 
            ua.user_id = :user_id
    ");

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    //here I bind user and use join tables, bcs im need mine data
    //if there's no data, im need use massive to get empty data if user have no transactions
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
}


