<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
   // var_dump($conn);
    $stmt = $conn->pdo->query("
            SELECT u.id, u.name 
            FROM users u 
        ");

    var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{     
    $stmt = $this->pdo->query("
            SELECT DISTINCT u.id, u.name 
            FROM users u 
            JOIN user_accounts ua ON u.id = ua.user_id 
            JOIN transactions t ON ua.id = t.from_account_id OR ua.id = t.to_account_id
        ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
}