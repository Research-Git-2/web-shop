<?php
session_start();
header('Content-Type: application/json');

$response = ['avatar' => 'uploads/avauser.png', 'login' => 'Guest'];

$userId = $_SESSION['user_id'] ?? null;

if ($userId) {
    require_once 'db.php';
    $query = "SELECT avatar, login FROM users WHERE id = $1";
    $result = pg_query_params($conn, $query, [$userId]);

    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        $response['avatar'] = $user['avatar'] && file_exists($user['avatar']) ? $user['avatar'] : 'uploads/default.jpg';
        $response['login'] = $user['login'];
    }
}

echo json_encode($response);
?>
