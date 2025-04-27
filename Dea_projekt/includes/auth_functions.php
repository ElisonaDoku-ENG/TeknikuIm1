<?php
require_once 'config.php';

function registerUser($username, $email, $password, $userType) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $entry = "$username:$email:$hashed:$userType\n";

    if(file_put_contents(USERS_FILE, $entry, FILE_APPEND | LOCK_EX) !== false) {
        return true;
    }
    return false;
}

function authenticate($username, $password) {
    $users = file(USERS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($users as $user) {
        list($u, $email, $hash, $type) = explode(':', $user);
        if($u === $username && password_verify($password, $hash)) {
            $_SESSION['user'] = [
                'username' => $username,
                'email' => $email,
                'type' => $type
            ];
            return $type; // Returns 'client' or 'technician'
        }
    }
    return false;
}

function registerTechnician($username, $data) {
    $entry = implode(':', array_map('sanitize', $data)) . "\n";
    return file_put_contents(TECHNICIANS_FILE, $entry, FILE_APPEND | LOCK_EX);
}

function getTechnicians($service = null) {
    $technicians = file(TECHNICIANS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $result = [];

    foreach($technicians as $tech) {
        $data = explode(':', $tech);
        if(!$service || strtolower($data[2]) === strtolower($service)) {
            $result[] = [
                'username' => $data[0],
                'full_name' => $data[1],
                'service_type' => $data[2],
                'phone' => $data[3],
                'location' => $data[4],
                'description' => $data[5],
                'rating' => $data[6]
            ];
        }
    }
    return $result;
}