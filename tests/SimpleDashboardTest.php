<?php
use PHPUnit\Framework\TestCase;

require_once 'includes/SimpleDashboard.php';

class SimpleDashboardTest extends TestCase {
    public function testGetUsers() {
        global $link;
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $result = mysqli_query($link, $sql);
        $expected = mysqli_num_rows($result);
        $users = getUsers();
        $actual = count($users);
        $this->assertEquals($expected, $actual);
    }

    public function testAddUser() {
        global $link;
        $data = array(
            'firstname' => 'Timothy TEST',
            'lastname' => 'Malando TEST',
            'age' => 29,
            'email' => 'anthony.timothy90@gmail.com',
            'password' => '123456',
            'avatar' => 'johndoe.jpg',
            'city' => 'Kibaha',
            'region' => 'Pwani',
            'country' => 'Tanzania'
        );
        $expected = true;
        $actual = addUser($data);
        $this->assertEquals($expected, $actual);
        $sql = "DELETE FROM `users` WHERE `users`.`firstname` = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $data['firstname']);
        mysqli_stmt_execute($stmt);
    }

    public function testAddUserFewData() {
        global $link;
        $data = array(
            'firstname' => 'Timothy TEST',
            'lastname' => 'Malando TEST'
        );
        $expected = true;
        $actual = addUser($data);
        $this->assertNotEquals($expected, $actual);
    }

    public function testGetUser() {
        global $link;
        $id = 1;
        $sql  = 'SELECT * FROM `users` where id = ?';
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $expected_user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $actual_user = getUser(1);
        $this->assertEquals($expected_user, $actual_user);
    }

    public function testGetUserWrongId() {
        $expected = array();
        $actual = getUser('s');
        $this->assertEquals($expected, $actual);
    }

    public function testUpdateUserPassword() {
        $user = getUser(1);
        $expected = $user['password'];
        $new_password =  password_hash('newpass1234', PASSWORD_DEFAULT);
        updateUserPassword(1, $new_password);
        $user = getUser(1);
        $actual = $user['password'];
        $this->assertNotEquals($expected, $actual);
        updateUserPassword(1, $expected);
    }
}