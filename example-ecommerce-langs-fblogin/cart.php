<?php

define("PREPARATIONTIME", 15 * 60);
//Handling of the cart page
//get and port /cart
$app->post('/cart', function() use ($app, $log) {
//Check if there is an attempt to see the  cart if not logged in
    if (!$_SESSION['user'] || !$_SESSION['facebook_access_token']) {
        $log->debug('Attempt to see the cart contents for un unauthorized user from the IP: ' . $_SERVER['REMOTE_ADDR']);
    }
// either add item to cart or change its quantity
    $productID = $app->request()->post('productID');
    $quantity = $app->request()->post('quantity');
    if (!is_numeric($quantity)) {
        $app->render('error_internal.html.twig');
        return;
    }
    $item = DB::queryFirstRow("SELECT * FROM cartitems WHERE sessionID=%s AND productID=%d", session_id(), $productID);
    if ($item) { // add quantity to existing item
        DB::update('cartitems', array('quantity' => $item['quantity'] + $quantity), 'ID=%i', $item['ID']);
    } else { // create new item in the cart
        DB::insert('cartitems', array(
            'sessionID' => session_id(),
            'productID' => $productID,
            'quantity' => $quantity,
            'dateCreated' => date('Y-m-d H:i:s')
        ));
    }
    $app->render('cart_container.html.twig');
});


$app->get('/cartItems', function() use ($app) {

    $app->render('cart_container.html.twig', array());
});
$app->get('/cart', function() use ($app) {
// display cart's content
    $cartItems = DB::query(
                    "SELECT cartitems.ID, products.ID as productID, name, price, quantity, picture, nutritionalValue "
                    . "FROM cartitems, products, products_i18n "
                    . "WHERE products.ID = products_i18n.productID AND products.ID = cartitems.productID AND sessionID=%s AND lang=%s", session_id(), $_COOKIE['lang']);
    $cartTotal = 0;
    foreach ($cartItems as &$item) {
        $item['picture'] = base64_encode($item['picture']);
        $item['total'] = ($item['quantity'] * $item['price']);
        $cartTotal += $item['total'];
    }
    $cartTax = TAX * $cartTotal;
    $cartTotalToPay = $cartTax + $cartTotal;
    $app->render('cart_view.html.twig', array(
        'cartItems' => $cartItems,
        'cartTotal' => number_format($cartTotal, 2),
        'cartTax' => number_format($cartTax, 2),
        'cartTotalToPay' => number_format($cartTotalToPay, 2)
    ));
});

// RESTful update cart when quantity changed
$app->put('/cart/update/:ID', function($ID) use ($app) {
    $json = $app->request()->getBody();
    $data = json_decode($json, true);
// only expect 
    if ((count($data) != 1) || (!isset($data['quantity']))) {
        $app->response()->status(400);
        echo json_encode("400: data in body invalid");
        return;
    }
    $quantity = $data['quantity'];
    if ($quantity < 0) {
        $app->response()->status(400);
        echo json_encode("400: quantity invalid");
        return;
    }
    if ($quantity == 0) {
        DB::delete('cartitems', 'cartitems.ID=%d AND cartitems.sessionID=%s', $ID, session_id());
    } else {
        DB::update('cartitems', array('quantity' => $quantity), "ID=%i AND sessionID=%s", $ID, session_id());
    }

    echo json_encode(DB::affectedRows() == 1);
});


// Delete an item from the cart
$app->delete('/cartItems/:ID', function($ID) use ($app) {
// only expect 
    if (isset($ID)) {
        DB::delete('cartitems', "productID=%i AND sessionID=%s", $ID, session_id());
        echo json_encode(DB::affectedRows() == 1);
    } else {
        echo FALSE;
    }
});
$app->get('/deliveryAddress', function() use ($app, $log) {
// display cart's content

    if ($_SESSION['facebook_access_token']) {
        $shippingAddress = array(
            'firstName' => $_SESSION['facebook_access_token']['firstName'],
            'lastName' => $_SESSION['facebook_access_token']['lastName'],
            'email' => $_SESSION['facebook_access_token']['email'],
                // 'city' => $_SESSION['facebook_access_token']['location'],
        );
        $app->render('shippingaddress.html.twig', array(
            'v' => $shippingAddress,
        ));
    }
    if ($_SESSION['user']) {
        $shippingAddress = array(
            'firstName' => $_SESSION['user']['firstName'],
            'lastName' => $_SESSION['user']['lastName'],
            'email' => $_SESSION['user']['email'],
            'address' => $_SESSION['user']['address'],
            'street' => $_SESSION['user']['street'],
            'city' => $_SESSION['user']['city'],
            'country' => $_SESSION['user']['country'],
            'postalCode' => $_SESSION['user']['postalCode'],
            'phone' => $_SESSION['user']['phone'],
            'city' => $_SESSION['user']['city'],
        );
        $app->render('shippingaddress.html.twig', array(
            'v' => $shippingAddress,
        ));
    }
});


$app->post('/deliveryAddress', function() use ($app, $log) {
    $firstName = $app->request->post('firstName');
    $lastName = $app->request->post('lastName');
    $email = $app->request->post('email');
    $address = $app->request->post('address');
    $street = $app->request->post('street');
    $city = $app->request->post('city');
    $country = $app->request->post('country');
    $postalCode = $app->request->post('postalCode');
    $phone = $app->request->post('phone');

// validate input
// submission received - verify
    $valueList = array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'address' => $address,
        'street' => $street,
        'city' => $city,
        'country' => $country,
        'postalCode' => $postalCode,
        'phone' => $phone,
    );
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
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        array_push($errorList["en"], "Email does not look like a valid email");
        array_push($errorList["fr"], "Le courriel ne ressemble pas à une adresse de courriel valide");

        unset($valueList['email']);
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
//
    if ($errorList['en'] || $errorList['fr']) {
// STATE 3: submission failed    

        $app->render('shippingaddress.html.twig', array(
            'errorList' => $errorList[$_COOKIE['lang']], 'v' => $valueList
        ));
    } else {
// STATE 2: submission successful
//get the customerID
        if ($_SESSION['user']) {
            $customerID = $_SESSION['user']['ID'];
        }
        if ($_SESSION['facebook_access_token']) {
            $customerID = $_SESSION['facebook_access_token']['userID'];
        }
//Get the nearest store
        $customerCoordinates = get_lat_long($postalCode);


        $store = DB::queryFirstRow("SELECT *, ( 3959 * acos( cos( radians(%s) ) "
                        . "* cos( radians( lat ) ) * cos( radians( lng ) - radians(%s) ) "
                        . "+ sin( radians(%s) ) * sin( radians( lat ) ) ) ) "
                        . "AS distance FROM stores HAVING distance < 20 ORDER BY distance LIMIT 0 , 1", $customerCoordinates['lat'], $customerCoordinates['lng'], $customerCoordinates['lat']);
        if (!$store) {
            $app->render('store_not_found.html.twig', array(
                'errorList' => $errorList[$_COOKIE['lang']], 'v' => $valueList
            ));
            return;
        }
        $delivery = getDeliveryTime($store, $customerCoordinates);
        $totalBeforeTax = DB::queryFirstField("SELECT SUM(products.price * cartitems.quantity) "
                        . " FROM cartitems, products "
                        . " WHERE cartitems.sessionID=%s AND cartitems.productID=products.ID", session_id());
        if ($totalBeforeTax > 0) {
            $taxes = $totalBeforeTax * TAX;
            $totalWithTaxes = $totalBeforeTax + $taxes;

//Gathering the rest of the information
            $order = array(
                'orderDate' => DB::sqleval("NOW()"),
                'storeID' => $store['ID'],
                'customerID' => $customerID,
                'contactFirstName' => $firstName,
                'contactLastName' => $lastName,
                'email' => $email,
                'deliveryAddress' => $address,
                'deliveryStreet' => $street,
                'deliveryCity' => $city,
                'deliveryCountry' => $country,
                'deliveryPostalCode' => $postalCode,
                'contactPhone' => $phone,
                'orderAmount' => $totalBeforeTax,
                'tax' => $taxes,
            );
//GET cartItems
            $cartItems = DB::query("SELECT products.ID as productID, name, price, quantity FROM cartitems, products, products_i18n "
                    . "WHERE products.ID = cartitems.productID AND products.ID = products_i18n.productID AND sessionID=%s and lang=%s", session_id(), getLang());
            foreach ($cartItems as &$item) {
                $item['total'] = ($item['quantity'] * $item['price']);
                $item['tax'] = ($item['quantity'] * $item['price']) * TAX;
            }

///Attempt insert order
            DB::$error_handler = FALSE;
            DB::$throw_exception_on_error = TRUE;
// PLACE THE ORDER
            try {
                DB::startTransaction();

                DB::insert('orders', $order);
                $orderID = DB::insertId();

// 2. copy all records from cartitems to 'orderitems' (select & insert)

                foreach ($cartItems as &$item) {
                    DB::insert('orderitems', array(
                        'orderID' => $orderID,
                        'productID' => $item['productID'],
                        'quantity' => $item['quantity'],
                        'orderItemsAmount' => $item['price'] * $item['quantity'],
                        'tax' => ($item['price'] * $item['quantity']) * TAX
                    ));
                }
// 3. delete cartitems for this user's session (delete)

                DB::delete('cartitems', 'sessionID=%s', session_id());
                DB::commit();
// TODO: send a confirmation email
                /*
                  $emailHtml = $app->view()->getEnvironment()->render('email_order.html.twig');
                  $headers = "MIME-Version: 1.0\r\n";
                  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                  mail($email, "Order " .$orderID . " placed ", $emailHtml, $headers);
                 */

                $log->debug("Inserted order no " . $orderID);
                //Send Confirmation email
                $to = $email;
                //Details for sending E-mail
                $from = "FastFood Online";
                $url = "http://fastfood-online.ipd8.info/resetPassword/$token";
                $body = $app->view()->render('email_order.html.twig', array(
                    'cartItems' => $cartItems,
                    'order' => $order,
                    'shippingAddress' => $valueList,
                    'totalBeforeTax' => number_format($totalBeforeTax, 2),
                    'taxes' => number_format($taxes, 2),
                    'totalWithShippingAndTaxes' => number_format(($totalBeforeTax + $taxes), 2),
                ));
                $from = "sales@fastfood-online.ipd8.info";
                $subject = "Fastfood-online Order Details";
                $headers = "From: $from\n";
                $headers .= "Content-type: text/html;charset=utf-8\r\n";
                $headers .= "X-Priority: 1\r\n";
                $headers .= "X-MSMail-Priority: High\r\n";
                $headers .= "X-Mailer: Just My Server\r\n";
                 try {
                $sentmail = mail($to, $subject, $body, $headers);
                $app->render('order_submitted.html.twig', array(
                    'shippingAddress' => $valueList,
                    'totalBeforeTax' => number_format($totalBeforeTax, 2),
                    'taxes' => number_format($taxes, 2),
                    'totalWithShippingAndTaxes' => number_format(($totalBeforeTax + $taxes), 2),
                    'store' => $store,
                    'totalDeliveryTime' => gmdate("H:i", PREPARATIONTIME + $delivery['time']),
                    'deliveryTime' => gmdate("H:i", $delivery['time'])

                ));
                } catch (Exception $ex) {
            $app->render('email_status.html.twig', array('failed' => TRUE));
        }
            } catch (MeekroDBException $e) {
                DB::rollback();
                sql_error_handler(array(
                    'error' => $e->getMessage(),
                    'query' => $e->getQuery()
                ));
            }
        } else {
            $app->render("cart_container.html.twig");
        }
    }
});

$app->get('/locations', function() use ($app) {

    $app->render('locations.html.twig');
});
$app->get('/markers', function() use ($app) {
    $locationList == DB::query('SELECT * FROM locations');
    if (!$locationList) {
        $app->response->setStatus(404);
        echo json_encode("Records not found");
        return;
    }
    echo json_encode($locationList, JSON_PRETTY_PRINT);
});

function getDeliveryTime($store, $destination) {
    $origin = $store['lat'] . ',' . $store['lng'];
    $destination = $destination['lat'] . ',' . $destination['lng'];
    $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins='
            . $origin . '&destinations=' . $destination . '&mode=driving&sensor=false';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    /*
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     * */
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['value'];

    return array('distance' => $dist, 'time' => $time);
}

//

$app->get('/nearestStores/:postalCode', function($postalCode) use ($app, $log) {
    $address = get_lat_long($postalCode);
    $storeList = DB::query("SELECT *, ( 3959 * acos( cos( radians(%s) ) "
                    . "* cos( radians( lat ) ) * cos( radians( lng ) - radians(%s) ) "
                    . "+ sin( radians(%s) ) * sin( radians( lat ) ) ) ) "
                    . "AS distance FROM stores HAVING distance < 5 ORDER BY distance ASC LIMIT 0, 10", $address['lat'], $address['lng'], $address['lat']);
    $log->debug(DB::count());
    if (!$storeList) {
        $app->response->setStatus(404);
        echo json_encode("Records not found");
        return;
    }
    echo json_encode($storeList, JSON_PRETTY_PRINT);
});

// function to get  the address
function get_lat_long($address) {
    $array = array();
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $latitude = $response_a->results[0]->geometry->location->lat;
    $longitude = $response_a->results[0]->geometry->location->lng;
    $array = array('lat' => $latitude, 'lng' => $longitude);

    return $array;
}
