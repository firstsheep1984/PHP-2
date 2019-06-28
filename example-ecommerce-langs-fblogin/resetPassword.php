<?php

$app->get('/forgotPassword', function() use ($app, $log) {
    $app->render('forgot_password.html.twig');
});
$app->post('/forgotPassword', function() use ($app, $log) {
    //When someone claims that password forgotten , make sure there is no active user
    $_SESSION['user'] = array();
    $_SESSION['facebook_access_token'] = array();

    $email = $app->request->post('email');
    $user = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    if (!$user) {
        $log->debug(sprintf("User failed for email %s from IP %s", $email, $_SERVER['REMOTE_ADDR']));
        $app->render('forgot_password.html.twig', array('loginFailed' => TRUE));
    } else {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $to = $user['email'];
        //echo "your email is ::".$email;
        //Details for sending E-mail
        $from = "FastFood Online";
        $url = "http://fastfood-online.ipd8.info/resetPassword/$token";
        $body = $app->view()->render('email_passreset.html.twig', array(
            'name' => $user['name'],
            'url' => $url
        ));
        $from = "sales@fastfood-online.ipd8.info";
        $subject = "Fastfood-online reset password request";
        $headers = "From: $from\n";
        $headers .= "Content-type: text/html;charset=utf-8\r\n";
        $headers .= "X-Priority: 1\r\n";
        $headers .= "X-MSMail-Priority: High\r\n";
        $headers .= "X-Mailer: Just My Server\r\n";
        try {
            $sentmail = mail($to, $subject, $body, $headers);
            if ($sentmail) {
                DB::$error_handler = FALSE;
                DB::$throw_exception_on_error = TRUE;
                try {
                    DB::startTransaction();
                    //FIXME: update or insert
                    //check if an use has already a reset token
                    $result = DB::queryOneField('userID', "SELECT * FROM resettokens WHERE userID=%d", $user['ID']);
                    DB::insertUpdate('resettokens', array(
                        'userID' => $user['ID'],
                        'resetToken' => $token,
                        'expiryDateTime' => date("Y-m-d H:i:s", strtotime("+5 days"))
                    ));

                    DB::update('users', array(
                        'locked' => TRUE,), 'ID = %d', $user['ID']);

                    DB::commit();
                    $log->debug(sprintf("Reset token for user id %s", $userID));
                    $app->render('email_status.html.twig');
                } catch (MeekroDBException $e) {
                    DB::rollback();
                    $log->debug(sprintf("Could not Reset token for user id %s. Error: %s", $user['ID'], $e));
                    $app->render('forgot_password.html.twig', array('failedEmail' => TRUE));
                }
            } else {
                $log->error(sprintf("Could not send email for user id %s.", $user['ID'], $e));
                $app->render('forgot_password.html.twig', array('failedEmail' => TRUE));
            }
        } catch (Exception $ex) {
            $app->render('email_status.html.twig', array('failed' => TRUE));
        }
    }
});
$app->get('/resetPassword/:token', function($token) use ($app, $log) {
    $app->render('reset_password.html.twig', array('resetToken' => $token));
});
$app->post('/resetPassword', function() use ($app, $log) {
    $pass1 = $app->request->post('pass1');
    $pass2 = $app->request->post('pass2');
    $resetToken = $app->request->post('resetToken');

    // submission received - verify
    $errorList = array("en" => array(), "fr" => array());
    if (!preg_match('/[0-9;\'".,<>`~|!@#$%^&*()_+=-]/', $pass1) || (!preg_match('/[a-z]/', $pass1)) || (!preg_match('/[A-Z]/', $pass1)) || (strlen($pass1) < 8)) {
        array_push($errorList["en"], "Password must be at least 8 characters " .
                "long, contain at least one upper case, one lower case, " .
                " one digit or special character");
        array_push($errorList["fr"], "Mot de passe doit être d'au moins 8 caractères, contenir au moins une majuscule, une minuscule,un chiffre ou un caractère spécial");
    } else if ($pass1 != $pass2) {
        array_push($errorList["en"], "Passwords don't match");
        array_push($errorList["fr"], "Les mots de passe ne coincident pas");
    }
    //
    if ($errorList["en"] || $errorList["fr"]) {
        // STATE 3: submission failed        
        $app->render('reset_password.html.twig', array(
            'errorList' => $errorList[$_COOKIE['lang']]
        ));
    } else {
        // STATE 2: submission successful
        DB::$error_handler = FALSE;
        DB::$throw_exception_on_error = TRUE;
        try {
            DB::startTransaction();
            $userID = DB::queryOneField('userID', "SELECT * FROM resettokens WHERE resetToken=%s AND expiryDateTime > NOW()", $resetToken);
            if (empty($userID)) {
                $log->error(sprintf("Attempt to reset password for an invalid token from IP %s", $_SERVER['REMOTE_ADDR']));
                $app->render('reset_status.html.twig', array('failed' => TRUE));
            } else {
                DB::delete('resettokens', 'resetToken =%s', $resetToken);
                DB::update('users', array(
                    'locked' => FALSE, 'password' => password_hash($pass1, CRYPT_BLOWFISH)), 'ID = %d', $userID);
                DB::commit();
                $log->debug(sprintf("Reset token for user id %s", $userID));
                $app->render('reset_status.html.twig');
            }
        } catch (MeekroDBException $e) {
            DB::rollback();
            $log->debug(sprintf("Could not Reset token for user id %s. Error: %s", $user['ID'], $e));
            $app->render('reset_status.html.twig', array('failed' => TRUE));
        }
    };
});
