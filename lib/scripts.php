<?php

    function getUsersList() {
        $users = [];
        $handler = fopen('data/users.txt', 'r');
        $i = 0;

        while($line = fgets($handler)) {
            $user = explode(',', $line);
            $users[$i]['name'] = trim(explode(': ', $user[0])[1]);
            $users[$i]['pswd'] = trim(explode(': ', $user[1])[1]);
            $i++;
        }

        fclose($handler);
        return $users;
    }

    function existsUser($login) {
        $users = getUsersList();

        foreach($users as $user) {
            if ($user['name'] === $login) return true;
        }

        return false;
    }

    function checkPassword($login, $pswd) {
        $users = getUsersList();
        foreach($users as $user) {
            if ($user['name'] === $login) {
                if ($user['pswd'] === md5($pswd)) return true;
            }            
        }
        
        return false;
    }

    function getCurrentUser() {
        return $_SESSION['login']?? null;
    }

    function getDayToBirthday($date) {
        $currentTimeInSeconds = time();

        $currentDate = date('Y-m-d', $currentTimeInSeconds);
        $birthDateChunk = explode('-', $date);
        $currentDateChunk = explode('-', $currentDate);

        if ($birthDateChunk[1] == $currentDateChunk[1]) {
            if ($birthDateChunk[2] < $currentDateChunk[2]) $birthDateChunk[0] = $currentDateChunk[0] + 1;
            else $birthDateChunk[0] = $currentDateChunk[0];
        } else if ($birthDateChunk[1] > $currentDateChunk[1]) {
            $birthDateChunk[0] = $currentDateChunk[0];
        } else {
            $birthDateChunk[0] = $currentDateChunk[0] + 1;
        }

        $birthDate = $birthDateChunk[0].'-'.$birthDateChunk[1].'-'.$birthDateChunk[2];
        $diff = date_diff(new DateTime($currentDate), new DateTime($birthDate));
        return $diff->days;       
    }

?>