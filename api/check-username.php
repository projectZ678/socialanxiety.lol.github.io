<?php
// api/check-username.php
header('Content-Type: application/json');
require_once '../config/supabase.php';

$username = $_GET['username'] ?? '';

if (empty($username)) {
    echo json_encode(['available' => false, 'message' => 'Username required']);
    exit;
}

$user = $supabase->getUserByUsername($username);
echo json_encode(['available' => !$user]);
?>
