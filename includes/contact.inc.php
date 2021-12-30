<?php

    if(isset($_POST['contactSubmit']) && $_POST['contactSubmit'] == 'Send Message'){
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $email = htmlspecialchars($_POST['email']);
        $msg = htmlspecialchars($_POST['msg']);
        $error = false;
        $contactFormArray = array(
            "firstName" => array("error" => false, "msg"=> ""),
            "lastName" => array("error" => false, "msg"=> ""),
            "email" => array("error" => false, "msg"=> ""),
            "msg" => array("error" => false, "msg"=> ""),
            "status" => "Success",
            "complete" => false
        );
        //ensure only functions used for validation are hidden from visible named php files
        require $_SERVER['DOCUMENT_ROOT'].'./includes/functions.inc.php';
    
        if(isEmptyInput($firstName) != false){
            $contactFormArray['firstName']['error'] = true;
            $contactFormArray['firstName']['msg'] = "Enter your First Name!";
            $error = true;
        } else if(isValidName($firstName) != true){
            $contactFormArray['firstName']['error'] = true;
            $contactFormArray['firstName']['msg'] = "Invalid First Name!";
            $error = true;
        } else if(incorrectStrLength($firstName, 50, 3) != false){
            $contactFormArray['firstName']['error'] = true;
            $contactFormArray['firstName']['msg'] = "Enter your First Name!";
            $error = true;
        }

        if(isEmptyInput($lastName) != false){
            $contactFormArray['lastName']['error'] = true;
            $contactFormArray['lastName']['msg'] = "Enter your Last Name!";
            $error = true;
        } else if(isValidName($lastName) != true){
            $contactFormArray['lastName']['error'] = true;
            $contactFormArray['lastName']['msg'] = "Invalid Last Name!";
            $error = true;
        } else if(incorrectStrLength($lastName, 50, 1) != false){
            $contactFormArray['lastName']['error'] = true;
            $contactFormArray['lastName']['msg'] = "Enter your Last Name!";
            $error = true;
        }
    
        if(isEmptyInput($email) != false){
            $contactFormArray['email']['error'] = true;
            $contactFormArray['email']['msg'] = "Please enter your email address for me to contact you!";
            $error = true;
        } else if(isValidateEmail($email) != true){
            $contactFormArray['email']['error'] = true;
            $contactFormArray['email']['msg'] = "Invalid Email Address!";
            $error = true;
        } else if(serverEmail($email) != false){
            $contactFormArray['email']['error'] = true;
            $contactFormArray['email']['msg'] = "Can\'t use that email address!";
            $error = true;
        } 
    
        if(isEmptyInput($msg) != false){
            $contactFormArray['msg']['error'] = true;
            $contactFormArray['msg']['msg'] = "Message cannot be empty!";
            $error = true;
        }else if(incorrectStrLength($msg, 4000, 100) != false){
            $contactFormArray['msg']['error'] = true;
            $contactFormArray['msg']['msg'] = "Message must be between 100 and 4000 characters!";
            $error = true;
        }   
    
        if($error != true){

            //Prep myself an email.
            $name =  $firstName.' '.$lastName;
            $to = mailTo();
            $subject = 'Contact Form Submission From ngbrandon.com';
            $message = '<p> Website: ngbrandon.com <br><br><br>Name:</br>'.$name.'<br><b>Email:</b>'.$email.'<br><b>Message:<br></b>'.nl2br($msg).'<br><br> </p>';
            
            $headers = "From: Brandon Bing Ng <".doNotReply().">\r\n";
            $headers .= "Reply-To: ".doNotReply()."\r\n";
            $headers .= "Content-type: text/html\r\n";
            

            //Send the contact form user email confirmation
            $respondSubj = 'Contact Form Submission Received!';
            $response = 'Hello <br><br> Thank you for contacting me, please wait up to 72 hours for a response! <br><br>Sincerely, <br> Brandon Bing Ng';
    
            //this is response to user
            $myResponse = mail($email, $respondSubj, $response, $headers, "-f ".mailSender());

            if($myResponse != true){
                $contactFormArray['email']['error'] = true;
                $contactFormArray['email']['msg'] = "Email Address is unavailable to receive emails!";
                $error = true;
            } else {
                $headers = "From: ngbrandon.com <".mailSender().">\r\n";
                $headers .= "Reply-To: ".mailSender()."\r\n";
                $headers .= "Content-type: text/html\r\n";
                //email sent to me
                $success = mail($to, $subject, $message, $headers, "-f ".mailSender());
                            
                echo "<script  type='text/javascript'>";
                echo "$('#firstName, #lastName, #email, #msg').removeClass('is-invalid');";
                echo "$('.formResults').removeClass('success, warning');";
                echo "$('.firstNameFeedback, .lastNameFeedback, .emailFeedback, .msgFeedback').html('');";
                if($success == true){
                    echo "$('.formResults').addClass('success');";
                    echo "$('.formResults').html('Email was sent!');";
                } else {
                    echo "$('.formResults').addClass('warning');";
                    echo "$('.formResults').html('Email failed server error, please try again later!');";
                }
                echo "</script>";
            }
        } 
        
        if($error == true) {
            echo "<script  type='text/javascript'>";
            echo "$('#firstName, #lastName, #email, #msg').removeClass('is-invalid');";
            echo "$('.firstNameFeedback, .lastNameFeedback, .emailFeedback, .msgFeedback').html('');";
            if($contactFormArray['firstName']['error'] == true){
                echo "$('#firstName').addClass('is-invalid');";
                echo "$('.firstNameFeedback').html('".$contactFormArray['firstName']['msg']."');";
            }
            if($contactFormArray['lastName']['error'] == true){
                echo "$('#lastName').addClass('is-invalid');";
                echo "$('.lastNameFeedback').html('".$contactFormArray['lastName']['msg']."');";
            }
            if($contactFormArray['email']['error'] == true){
                echo "$('#email').addClass('is-invalid');";
                echo "$('.emailFeedback').html('".$contactFormArray['email']['msg']."');";
            }
            if($contactFormArray['msg']['error'] == true){
                echo "$('#msg').addClass('is-invalid');";
                echo "$('.msgFeedback').html('".$contactFormArray['msg']['msg']."');";
            }
            echo "$('.formResults').html('')";
            echo "</script>";
        }
    } else {
        http_response_code(401);
        include($_SERVER['DOCUMENT_ROOT'].'/error/401.php');
        exit();
    }
  
?>