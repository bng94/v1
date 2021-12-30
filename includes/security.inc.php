<?php
    session_start();
    if(isset($_SESSION['lastActivity'])){
       if(time() - $_SESSION['lastActivity'] >= 86400){
            $_SESSION['emailSent'] = 0;
       } else if(time() - $_SESSION['lastActivity'] <= 60){
            $error = true;
            echo "You cannot send multiple messages within a minute!"; 
       } else {
            $_SESSION['emailSent']++;
       }
       $_SESSION['lastActivity'] = time();
       if($_SESSION['emailSent'] >= 3){
            $error = true;
            echo "You are limited to max of 3 messages sent a day!"; 
       }
    } else {
        $_SESSION['lastActivity'] = time();
        $_SESSION['emailSent'] = 0;
    }
    session_abort();

?>