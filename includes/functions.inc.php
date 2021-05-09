<?php
function emptyInputSignup($name, $username, $pwd, $pwdRepeat) {
    if(empty($name) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        return true;
    }
    return false;
}

function invalidUid($username) {
    $result=false;
    if(preg_match('/[^A-Za-z0-9.#\\-$]/', $username)) {
        $result=true;
    }
    else {
        $result = false;
    }
    return $result;
}


function pwdMatch($pwd, $pwdRepeat) {
    if($pwd !== $pwdRepeat) {
        return true;
    }
    return false;
}

function uidExists($conn, $username) {
    $sql = "SELECT * FROM USERS WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row; 
    }
    else {
        return false;
    }

    mysqli_stmt_close($stmt);
    
}
function createUser($conn, $name, $username, $pwd) {
    $balance = 0;
    $sql = "INSERT INTO users (usersName, usersUid, usersPwd, usersBalance) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $username, $hashedPwd, $balance);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function emptyInputLogin($username, $pwd) {
    if(empty($username) || empty($pwd)) {
        return true;
    }
    return false;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username);

    if($uidExists == false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd == false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($checkPwd == true) {
        session_start();
        $_SESSION["useruid"] = $uidExists["usersUid"];
        header("location: ../index.php");
        exit();
    }
}

function getAmtMoney($conn, $username) {
    $userRow = uidExists($conn, $username);
    return $userRow["usersBalance"];
}

function addMoney($conn, $amt, $username) {
    $userRow = uidExists($conn, $username);
    $balance = $userRow["usersBalance"];
    $newBalance = (string) ($balance + ($amt));
    $newBalance = "'" . $newBalance . "'";
    $username = "'" . $username . "'";
    $sql = "UPDATE `users` SET `usersBalance` = " . $newBalance . " WHERE `users`.`usersUid` = " . $username . ";";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profile.php?error=none");
    exit();
}
function removeMoney($conn, $amt, $username) {
    $userRow = uidExists($conn, $username);
    $balance = $userRow["usersBalance"];
    if($amt > $balance) {
        header("location: ../profile.php?error=notenoughmoney");
        exit();
    }
    $newBalance = (string) ($balance - ($amt));
    $newBalance = "'" . $newBalance . "'";
    $username = "'" . $username . "'";
    $sql = "UPDATE `users` SET `usersBalance` = " . $newBalance . " WHERE `users`.`usersUid` = " . $username . ";";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profile.php?error=none");
    exit();
}

function transferMoney($conn, $amt, $username, $depuid) {
    // $sql = "SELECT * FROM USERS WHERE usersUid = '" . $username . "';";
    // $retval = mysqli_query($sql, $conn);
    // $userRow1 = mysqli_fetch_array($retval, MYSQLI_ASSOC);
    // $username2 = "'" . $depuid . "'";
    // $sql = "SELECT * FROM USERS WHERE usersUid = " . $username2 . ";";
    // $retval2 = mysqli_query($sql, $conn);
    // $userRow2 = mysqli_fetch_array($retval2, MYSQLI_ASSOC);
    // if($userRow2 == false) {
    //     header("location: ../transfer.php?error=usernotfound");
    //     exit();
    // }
    // $currUserB = $userRow1["usersBalance"];
    // if($amt > $currUserB) {
    //     header("location: ../transfer.php?error=notenoughmoney");
    //     exit();
    // }
    // $altUserB = $userRow2["usersBalance"];
    // $newB1 = (string) ($currUserB - ($amt));
    // $newBalance = "'" . $newB1 . "'";
    // $username = "'" . $username . "'";
    // $sql = "UPDATE `users` SET `usersBalance` = " . $newBalance . " WHERE `users`.`usersUid` = " . $username . ";";
    // mysqli_query($conn, $sql);
    // $newB2 = (string) ($altUserB + ($amt));
    // $newBalance = "'" . $newB2 . "'";
    // $username = "'" . $depuid . "'";
    // $sql = "UPDATE `users` SET `usersBalance` = " . $newBalance . " WHERE `users`.`usersUid` = " . $username . ";";
    // mysqli_query($conn, $sql);
    // mysqli_close($conn);
    // header("location: ../transfer.php?error=none");
    // exit();
    $query1 = "SELECT * FROM USERS WHERE usersUid = '" . $username . "';";
    $result = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result);
    $balance1 = $row["usersBalance"] + $amt;
    $query2 = "UPDATE `users` SET `usersBalance` = '" . $balance1 . "' WHERE `users`.`usersName` = '" . $username . "';";
    mysqli_query($conn, $query2);
    $query1 = "SELECT * FROM USERS WHERE usersUid = '" . $depuid . "';";
    $result = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result);
    $balance1 = $row["usersBalance"] + $amt;
    $query2 = "UPDATE `users` SET `usersBalance` = '" . $balance1 . "' WHERE `users`.`usersName` = '" . $depuid . "';";
    mysqli_query($conn, $query2);
    mysqli_close($conn);
    header("location: ../transfer.php?error=none");
    exit();
}




