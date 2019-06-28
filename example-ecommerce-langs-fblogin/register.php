<?php
$app->get('/emailexists/:email', function($email) use ($app, $log) {
    $user = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    if ($user) {
        echo TRUE;
    } else {
        echo FALSE;
    }
});

// State 1: first show
$app->get('/register', function() use ($app, $log) {
    //unset currently active users
    $_SESSION['user'] = array();
    $_SESSION['facebook_access_token'] = array();
   
    $app->render('register.html.twig');
});
// State 2: submission
$app->post('/register', function() use ($app, $log) {
    $firstName = $app->request->post('firstName');
    $lastName = $app->request->post('lastName');
    $email = $app->request->post('email');
    $gender = $app->request->post('gender');
    $address = $app->request->post('address');
    $street = $app->request->post('street');
    $city = $app->request->post('city');
    $country = $app->request->post('country');
    $postalCode = $app->request->post('postalCode');
    $phone = $app->request->post('phone');
    $pass1 = $app->request->post('pass1');
    $pass2 = $app->request->post('pass2');

    
    
    $valueList = array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'gender' => $gender,
        'address' => $address,
        'street' => $street,
        'city' => $city,
        'country' => $country,
        'postalCode' => $postalCode,
        'phone' => $phone,
    );
    // submission received - verify
    $errorList = array("en" => array(), "fr" => array());
    if (strlen($firstName) < 2 || strlen($firstName) > 50) {
        array_push($errorList["en"], "FirstName must be at least 2 and at most 50 characters long");
        array_push($errorList["fr"], "Le prénom doit être d'au moins 2 et au plus 50 caractères");
        unset($valueList['firstName']);
    }
    if (strlen($lastName) < 2 || strlen($lastName) > 50) {
        array_push($errorList["en"], "LastName must be at least 2 and at most 50 characters long");
        array_push($errorList["fr"], "Le nom de Famille doit être d'au moins 2 et au plus 50 caractères");

        unset($valueList['lastName']);
    }

    if (empty($gender) || !in_array($gender, array('F', 'M'))) {
        array_push($errorList["en"], "You must choose a gender");
        array_push($errorList["fr"], "Il faut specifier le gendre");

        unset($valueList['gender']);
    }
    if (empty($gender)) {
        array_push($errorList["en"], "You must choose a gender");
        array_push($errorList["fr"], "Il faut specifier le gendre");

        unset($valueList['gender']);
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        array_push($errorList["en"], "Email does not look like a valid email");
        array_push($errorList["fr"], "Le courriel ne ressemble pas à une adresse de courriel valide");

        unset($valueList['email']);
    } else {
        $user = DB::queryFirstRow("SELECT ID FROM users WHERE email=%s", $email);
        if ($user) {
            array_push($errorList["en"], "Email already registered");
            array_push($errorList["fr"], "Le courriel existe déjà");
            unset($valueList['email']);
        }
    }
    if (strlen($address) < 1 || strlen($address) > 50) {
        array_push($errorList["en"], "Address cannot be empty and cannot contain more than 50 characters");
        array_push($errorList["fr"], "Adresse ne peut pas être vide et ne peut pas contenir plus de 50 caractères");

        unset($valueList['address']);
    }
    if (strlen($street) < 1 || strlen($street) > 50) {
        array_push($errorList["en"], "Street cannot be empty and cannot contain more than 50 characters");
        array_push($errorList["fr"], "Rue ne peut être vide et ne peut pas contenir plus de 50 caractères");
        unset($valueList['street']);
    }
    if (strlen($city) < 2 || $city > 100) {
        array_push($errorList["en"], "City between 2 and 100 characters");
        array_push($errorList["fr"], "La ville entre 2 et 100 caractères");
        unset($valueList['city']);
    }
    if (strlen($country) < 2 || $country > 50) {
        array_push($errorList["en"], "Country between 2 and 50 characters");
        array_push($errorList["fr"], "Le pays entre 2 et 50 caractères");
        unset($valueList['country']);
    }
    if (!preg_match('/^([A-Za-z][0-9]){3}$/', $postalCode)) {
        echo "PostalCode " . $postalCode;
        array_push($errorList["en"], "Phone not valid");
        array_push($errorList["fr"], "Le tel est pas valide");
        unset($valueList['postalCode']);
    }
    if (!preg_match('/^(\d{3}\s?){2}\d{4}$/', $phone)) {
        array_push($errorList["en"], "Canadian Postal code not valid");
        array_push($errorList["fr"], "Le code postal est pas valide");
        unset($valueList['phone']);
    }
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
        $app->render('register.html.twig', array(
            'errorList' => $errorList[$_COOKIE['lang']], 'v' => $valueList
        ));
    } else {
        // STATE 2: submission successful
        DB::insert('users', array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'gender' => $gender,
            'address' => $address,
            'street' => $street,
            'city' => $city,
            'country' => $country,
            'postalCode' => $postalCode,
            'phone' => $phone,
            'password' => password_hash($pass1, CRYPT_BLOWFISH),
            'locked' => false,
            'role' => 'customer',
        ));
        $id = DB::insertId();
        $log->debug(sprintf("User %s created", $id));
        $app->render('register.html.twig', array('registerSuccess'=> TRUE));
    }
});

