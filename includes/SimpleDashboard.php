<?php
    require_once 'config/database.php';

    function getUsers() {
        global $link;
        $users = array();
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $users[] = $row;
                }
            }
        }
        return $users;
    }

    function addUser($data) {
        global $link;
        $success = false;

        try {
            $sql = "INSERT INTO users (`firstname`, `lastname`, `age`, `email`, `password`, `avatar`, `city`, `region`, `country`) 
            VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ssissssss", $data['firstname'], $data['lastname'], $data['age'], $data['email'], $data['password'], $data['avatar'], $data['city'], $data['region'], $data['country']);
            if (mysqli_stmt_execute($stmt)) {
                $success = true;
            }
        } Catch (Exception $ex) {
            return $success;
        }
        return $success;
    }

    function getUser($id) {
        global $link;

        $user = array();
        $sql = "SELECT * FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            $param_id = trim($id);
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                }
            }
        }
        return $user;
    }

    function updateUserPassword($id, $password) {
        global $link;
        $success = false;
        $sql = "UPDATE `users` SET `password` = ? WHERE `users`.`id` = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "si", $password, $id);
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        }
        return $success;
    }
?>