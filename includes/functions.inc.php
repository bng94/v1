<?php

    function isEmptyInput($input){
        if(empty($input) != false || ctype_space($input) != false){
            return true;
        } else {
            return false;
        }
    }

    function incorrectStrLength($string, $max,  $min = 5){
        if(strlen($string) < $min || strlen($string) > $max){
            return true;
        } else {
            return false;
        }
    }

    function isValidName($name){
        if(preg_match("/^[a-zA-Z]+\s?[a-zA-Z]*$/", $name)){
            return true;
        } else {
            return false;
        }
    }

    function isValidateEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    function serverEmail($email){
        if(strpos($email, "ngbrandon.com") > 0){
            return true;
        } else {
            return false;
        }
    }

    //Emails are placeholders
    function mailTo(){
        return "me@ngbrandon.com";
    }
    
    function mailSender(){
        return "myWebsiteForm@ngbrandon.com";
    }

    function doNotReply(){
        return "do-not-reply@ngbrandon.com";
    }
?>