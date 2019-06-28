<?php

////////////////////////////////////////////////////////////
/////////////////////Product Add/Edit//////////////////////
//////////////////////////////////////////////////////////
$app->get('/admin/products', function() use ($app, $log) {
    if ($_SESSION['user']['role'] === 'admin') {
        $app->render('products_container.html.twig', array('isAdmin' => TRUE));
    } else {
        $log->debug(sprintf("Atempt to access /admin/products page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
});

$app->get('/admin/product_addedit', function() use ($app, $log) {
    if ($_SESSION['user']['role'] === 'admin') {
        $prodTable = DB::query('SELECT '
                        . 'en.productID, '
                        . 'concat(en.name_en," / ",fr.name_fr) as productname, '
                        . 'en.description_en, '
                        . 'fr.description_fr, '
                        . 'concat(en.pg_name," / ",fr.pg_name) as categoryname, '
                        . 'isVegetarian, '
                        . 'nutritionalValue, '
                        . 'picture, '
                        . 'price '
                        . 'FROM '
                        . '(SELECT '
                        . 'productID, '
                        . 'pi.name as name_en, '
                        . 'description as description_en, '
                        . 'pg.name as pg_name, '
                        . 'p.isVegetarian, '
                        . 'p.nutritionalValue, '
                        . 'p.picture, '
                        . 'p.price '
                        . 'FROM '
                        . 'products_i18n pi, products p, productcategory pg '
                        . 'WHERE '
                        . 'pi.lang = pg.lang AND '
                        . 'pi.lang = "en" AND '
                        . 'pg.ID = p.productCategoryID AND '
                        . 'p.ID = pi.productID AND '
                        . 'pg.lang = pi.lang) as en, '
                        . '(SELECT '
                        . 'pi.name as name_fr, '
                        . 'description as description_fr, '
                        . 'pg.name as pg_name, '
                        . 'pi.productID '
                        . 'FROM '
                        . 'products_i18n pi, products p, productcategory pg '
                        . 'WHERE '
                        . 'pi.lang = "fr" AND '
                        . 'pg.ID = p.productCategoryID AND '
                        . 'p.ID = pi.productID AND '
                        . 'pg.lang = pi.lang) as fr '
                        . 'WHERE '
                        . 'en.productID = fr.productID');

        foreach ($prodTable as &$product) {
// print_r('test');
            $product['picture'] = base64_encode($product['picture']);
        }

        $app->render('product_addedit.html.twig', array('prodTable' => $prodTable, 'isAdmin' => TRUE));
    } else {
        $log->debug(sprintf("Atempt to access /admin/product_addedit page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
});

$app->get('/admin/product_addedit/form(/:ID)', function($ID = "") use ($app, $log) {
    if ($_SESSION['user']['role'] === 'admin') {
        $categoryList = DB::query('SELECT en.ID as categoryID,'
                        . 'concat(en.name," / ",fr.name) as categoryname '
                        . 'FROM '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'lang = "en") as en, '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'lang = "fr") as fr '
                        . 'WHERE '
                        . 'en.ID = fr.ID');
        if (empty($ID)) {
            $app->render('form_addedit.html.twig', array('categoryList' => $categoryList, 'isAdmin' => TRUE));
        } else {
            $prodForm = DB::queryFirstRow('SELECT '
                            . 'en.productID, '
                            . 'en.name_en, '
                            . 'fr.name_fr, '
                            . 'en.description_en, '
                            . 'fr.description_fr, '
                            . 'concat(en.pg_name," / ",fr.pg_name) as categoryname, '
                            . 'isVegetarian, '
                            . 'nutritionalValue, '
                            . 'picture, '
                            . 'price '
                            . 'FROM '
                            . '(SELECT '
                            . 'productID, '
                            . 'pi.name as name_en, '
                            . 'description as description_en, '
                            . 'pg.name as pg_name, '
                            . 'p.isVegetarian, '
                            . 'p.nutritionalValue, '
                            . 'p.picture, '
                            . 'p.price '
                            . 'FROM '
                            . 'products_i18n pi, products p, productcategory pg '
                            . 'WHERE '
                            . 'pi.productID = %d AND '
                            . 'pi.lang = "en" AND '
                            . 'pg.ID = p.productCategoryID AND '
                            . 'p.ID = pi.productID AND '
                            . 'pg.lang = pi.lang) as en, '
                            . '(SELECT '
                            . 'pi.name as name_fr, '
                            . 'description as description_fr, '
                            . 'pg.name as pg_name '
                            . 'FROM '
                            . 'products_i18n pi, products p, productcategory pg '
                            . 'WHERE '
                            . 'pi.productID = %d AND '
                            . 'pi.lang = "fr" AND '
                            . 'pg.ID = p.productCategoryID AND '
                            . 'p.ID = pi.productID AND '
                            . 'pg.lang = pi.lang) as fr', $ID, $ID);

            $prodForm['picture'] = base64_encode($prodForm['picture']);


            $app->render('form_addedit.html.twig', array('p' => $prodForm, 'categoryList' => $categoryList, 'isAdmin' => TRUE));
        }
    } else {
        $log->debug(sprintf("Atempt to admin/product_addedit/form page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
});

function create_slug($string) {
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}

$app->post('/admin/products', function() use ($app, $log) {
    if ($_SESSION['user']['role'] === 'admin') {
        $ID = $app->request->post('productID');
        $name_en = $app->request->post('name_en');
        $slugname_en = create_slug($name_en);

        $name_fr = $app->request->post('name_fr');
        $slugname_fr = create_slug($name_fr);

        $price = $app->request->post('price');
        $nutritionalValue = $app->request->post('nutritionalValue');

        $isVegetarian = $app->request->post('isVegetarian');

        if (isset($isVegetarian)) {
            $isVegetarian = 1;
        } else {
            $isVegetarian = 0;
        }
        $productCategoryID = $app->request->post('categoryID');
        //Find the categoryId 
        $description_en = $app->request->post('description_en');
        $description_fr = $app->request->post('description_fr');
        $picture = $app->request->post('picture');
//////////////////////////////////////////////////////////////////////////////
        $errorList = array();

        $image = '';
        if ($_FILES["imageFile"]["size"] > 10) {
            if (isset($_FILES["imageFile"])) {
                if ($_FILES["imageFile"]["error"] != UPLOAD_ERR_OK) {
                    array_push($errorList, "Error uploading file");
                } else {
                    if (strstr($_FILES["imageFile"]["name"], "..")) {
                        array_push($errorList, "Invalid filename");
                    } else {
                        $imageInfo = getimagesize($_FILES["imageFile"]["tmp_name"]);
                        if (!$imageInfo) {
                            array_push($errorList, "Uploaded file doesn't seem to be an image");
                        }
                    }
                }
            } else {
                $info = pathinfo($_FILES["imageFile"]["name"]);
                $ext = $info['extension'];
                $imagePath = "media/" . ($_FILES["imageFile"]["name"]);
                move_uploaded_file($_FILES['imageFile']['tmp_name'], $imagePath);
            }

            $destPath = "media/" . $_FILES["imageFile"]["name"];
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $destPath)) {
                echo "The file " . basename($_FILES["imageFile"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            $image = file_get_contents($destPath);
            if ($image != '') {
                $picture = $image;
            }
        }


/////////////////////////////////////////////////////////////////////////

        $valueList = array(
            'name_en' => $name_en,
            'name_fr' => $name_fr,
            'price' => $price,
            'nutritionalValue' => $nutritionalValue,
            'isVegetarian' => $isVegetarian,
            'description_en' => $description_en,
            'description_fr' => $description_fr,
            'picture' => $picture
        );

        if (strlen($name_en) < 2 || strlen($name_en) > 100) {
            array_push($errorList, "Product Name_EN must be at least 2 and at most 100 characters long");
            unset($valueList['name_en']);
        }
        if (strlen($name_fr) < 2 || strlen($name_fr) > 100) {
            array_push($errorList, "Product Name_FR must be at least 2 and at most 100 characters long");
            unset($valueList['name_en']);
        }
        if ($price <= 0 || $price > 100000000) {
            array_push($errorList, "Invalid price");
            unset($valueList['price']);
        }
        if (!in_array($isVegetarian, array('0', '1'))) {
            array_push($errorList, "isVegetarian is not true nor false");
            unset($valueList['isVegetarian']);
        }
        if (strlen($description_en) < 20 || strlen($description_en) > 500) {
            array_push($errorList, "Description_EN must have between 20 and 100 characters");
            unset($valueList['description_en']);
        }
        if (strlen($description_fr) < 20 || strlen($description_fr) > 500) {
            array_push($errorList, "Description_FR must have between 20 and 100 characters");
            unset($valueList['description_fr']);
        }
        if ($nutritionalValue <= 0 || $nutritionalValue > 1000) {
            array_push($errorList, "Invalid nutritional value");
            unset($valueList['nutritionalValue']);
        }
        if ($errorList) {
            $app->render('products_container.html.twig', array(
                'errorList' => $errorList, 'p' => $valueList, 'isAdmin' => TRUE
            ));
            return;
        }
        if (!isset($ID) || empty($ID)) { // SUCCESSFUL SUBMISSION
            DB::$error_handler = FALSE;
            DB::$throw_exception_on_error = TRUE;
            //print_r($valueList);
            try {
                DB::startTransaction();

                DB::insert('products', array(
                    'productCategoryID' => $productCategoryID,
                    'price' => $price,
                    'nutritionalValue' => $nutritionalValue,
                    'isVegetarian' => $isVegetarian,
                    'picture' => $picture
                ));
                $productID = DB::insertId();

                DB::insert('products_i18n', array(
                    'name' => $name_en,
                    'slugname' => $slugname_en,
                    'description' => $description_en,
                    'productID' => $productID,
                    'lang' => 'en'
                ));

                DB::insert('products_i18n', array(
                    'name' => $name_fr,
                    'slugname' => $slugname_fr,
                    'description' => $description_fr,
                    'productID' => $productID,
                    'lang' => 'fr'
                ));

                DB::commit();
                $log->debug("Product created with ID=" . $ID);
                $app->render('products_container.html.twig', array('isAdmin' => TRUE));
            } catch (MeekroDBException $e) {
                DB::rollback();
                sql_error_handler(array(
                    'error' => $e->getMessage(),
                    'query' => $e->getQuery()
                ));
            }
        } else {
            DB::$error_handler = FALSE;
            DB::$throw_exception_on_error = TRUE;

            try {
                DB::startTransaction();

                if ($image == '') {
                    DB::update('products', array(
                        'price' => $price,
                        'nutritionalValue' => $nutritionalValue,
                        'isVegetarian' => $isVegetarian), 'ID = %d', $ID);
                } else {
                    DB::update('products', array(
                        'price' => $price,
                        'nutritionalValue' => $nutritionalValue,
                        'isVegetarian' => $isVegetarian,
                        'picture' => $picture), 'ID = %d', $ID);
                }

                DB::update('products_i18n', array(
                    'name' => $name_en,
                    'description' => $description_en), 'productID = %d AND lang = "en"', $ID);

                DB::update('products_i18n', array(
                    'name' => $name_fr,
                    'description' => $description_fr), 'productID = %d AND lang = "fr"', $ID);

                DB::commit();
                $log->debug("Product updated with ID=" . $ID);
                $app->render('products_container.html.twig', array('isAdmin' => TRUE));
            } catch (MeekroDBException $e) {
                DB::rollback();
                sql_error_handler(array(
                    'error' => $e->getMessage(),
                    'query' => $e->getQuery()
                ));
            }
        }
    } else {
        $log->debug(sprintf("Atempt to admin/product_addedit/form page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
});


//
//
////////////////////////////////////////////////////////////
/////////////////////Category//////////////////////////////
//////////////////////////////////////////////////////////
$app->get('/admin/category_addedit', function() use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $categoryList = DB::query('SELECT '
                        . 'concat(en.name," / ",fr.name) as categoryname, '
                        . 'en.ID '
                        . 'FROM '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'lang = "en") as en, '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'lang = "fr") as fr '
                        . 'WHERE '
                        . 'en.ID = fr.ID');

        $app->render('category_addedit.html.twig', array(
            'categoryList' => $categoryList, 'isAdmin' => TRUE));
    } else {
        $log->debug(sprintf("Atempt to see /admin/category_addedit page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
});


$app->get('/admin/category_addedit/:ID', function($ID) use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $record = DB::queryFirstRow('SELECT '
                        . 'en.name as name_en, '
                        . 'fr.name as name_fr '
                        . 'FROM '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'ID = %d AND '
                        . 'lang = "en") as en, '
                        . '(SELECT '
                        . 'ID, '
                        . 'name '
                        . 'FROM productcategory '
                        . 'WHERE '
                        . 'ID = %d AND '
                        . 'lang = "fr") as fr '
                        . 'WHERE '
                        . 'en.ID = fr.ID', $ID, $ID);

        if (!$record) {
            $app->response->setStatus(404);
            echo json_encode("Record not found");
            return;
        }
        echo json_encode($record, JSON_PRETTY_PRINT);
    }
});

$app->post('/admin/category_addedit', function() use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $body = $app->request->getBody();
        $record = json_decode($body, TRUE);

        if (!$record['name_en'] || strlen($record['name_en']) < 2 || strlen($record['name_en']) > 100) {
            $app->response->setStatus(400);
            $log->debug("Invalid data for name_en. Failed post.");
            echo json_encode(FALSE);
            return;
        }
        if (!$record['name_fr'] || strlen($record['name_fr']) < 2 || strlen($record['name_fr']) > 100) {
            $app->response->setStatus(400);
            $log->debug("Invalid data for name_fr. Failed pos.");
            echo json_encode(FALSE);
            return;
        }
        DB::$error_handler = FALSE;
        DB::$throw_exception_on_error = TRUE;

        try {
            $ID = DB::queryFirstField('SELECT ID FROM productcategory order by ID DESC');

            $categoryID = $ID + 1;

            DB::startTransaction();

            DB::insert('productcategory', array(
                'ID' => $categoryID,
                'lang' => 'en',
                'name' => $record['name_en']
            ));

            DB::insert('productcategory', array(
                'ID' => $categoryID,
                'lang' => 'fr',
                'name' => $record['name_fr']
            ));

            DB::commit();
            echo json_encode(TRUE);

        } catch (MeekroDBException $e) {
            DB::rollback();
            sql_error_handler(array(
                'error' => $e->getMessage(),
                'query' => $e->getQuery()
            ));
        }
    }
});

$app->put('/admin/category_addedit/:ID', function($ID) use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $body = $app->request->getBody();
        $record = json_decode($body, TRUE);

        if (!$record['name_en'] || strlen($record['name_en']) < 2 || strlen($record['name_en']) > 100) {
            $app->response->setStatus(400);
            $log->debug("Invalid data for name_en. Failed put.");
            return;
        }
        if (!$record['name_fr'] || strlen($record['name_fr']) < 2 || strlen($record['name_fr']) > 100) {
            $app->response->setStatus(400);
            $log->debug("Invalid data for name_fr. Failed put.");
            echo json_encode(FALSE);
            return;
        }
          
        try {
            DB::startTransaction();

            DB::update('productcategory', array('name' => $record['name_en']), "ID=%d AND lang = 'en'", $ID);

            DB::update('productcategory', array('name' => $record['name_fr']), "ID=%d AND lang = 'fr'", $ID);

            DB::commit();
            echo json_encode(TRUE);
        } catch (MeekroDBException $e) {
            DB::rollback();
            sql_error_handler(array(
                'error' => $e->getMessage(),
                'query' => $e->getQuery()
            ));
        }
    }
});

////////////////////////////////////////////////////////////
/////////////////////View Orders//////////////////////////////
//////////////////////////////////////////////////////////

$app->get('/admin/orders', function() use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $orderList = DB::query('SELECT '
                        . 'orders.ID as orderID, '
                        . 'orderDate, '
                        . 'orderAmount, '
                        . 'deliveryDate,  '
                        . 'deliveryAmount '
                        . 'FROM orders LEFT OUTER JOIN deliveries ON orders.ID = deliveries.orderID WHERE deliveryAmount IS Null');

        // print_r($orderList);

        $app->render('viewOrders.html.twig', array('orderList' => $orderList, 'isAdmin' => TRUE));
    } else {
        $log->debug(sprintf("Atempt to see /admin/orders page from IP %s", $_SERVER['REMOTE_ADDR']));
        $app->render('access_denied.html.twig');
    }
    
    
});

//$app->get('/admin/orders/:ID', function($ID) use ($app, $log) {
//
//    $record = DB::queryFirstRow('SELECT '
//                    . 'orders.ID as orderID, '
//                    . 'orderDate, '
//                    . 'orderAmount, '
//                    . 'deliveryDate,  '
//                    . 'deliveryAmount '
//                    . 'FROM orders, deliveries  '
//                    . 'WHERE  orders.ID = orderID AND '
//                    . 'orders.ID = %d', $ID);
//
//    if (!$record) {
//        $app->response->setStatus(404);
//        echo json_encode("Record not found");
//        return;
//    }
//    echo json_encode($record, JSON_PRETTY_PRINT);
//});

$app->post('/admin/orders/:ID', function($ID) use ($app, $log) {
    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
        $body = $app->request->getBody();
        $record = json_decode($body, TRUE);
        $record['orderID'] = $ID;
        
        $orderDate = DB::queryFirstField('SELECT orderDate FROM orders  WHERE ID=%d', $ID);

        if (!$record['deliveryAmount'] || $record['deliveryAmount'] < 0 || !is_numeric($record['deliveryAmount'])) {
            $app->response->setStatus(400);
            $log->debug("Invalid delivery amount. Failed post.");
            echo json_encode(FALSE);
            return;
        }
        $tempDate = explode('-', $record['deliveryDate']);
        if (count($tempDate) != 3) {
        $app->response->setStatus(400);
            $log->debug("Invalid delivery date. Failed post.");
            echo json_encode("Here");
            echo json_encode(FALSE);
            return;
    } elseif (!checkdate($tempDate[1], $tempDate[2], $tempDate[0]) ||  $record['deliveryDate'] < $orderDate) {
       $app->response->setStatus(400);
            $log->debug("Invalid delivery Date. Failed post.");
            echo json_encode(FALSE);
            return;
    }
        DB::insert('deliveries', $record);
        echo json_encode(TRUE);
    }
});

//$app->get('/admin/orders/details', function() use ($app, $log) {
//    if ($_SESSION['user'] && $_SESSION['user']['role'] === 'admin') {
//        $detailsList = DB::query('');
//        //print_r($orderList);
//
//        $app->render('viewOrders.html.twig', array('orderList' => $orderList, 'isAdmin' => TRUE));
//    } else {
//        $log->debug(sprintf("Atempt to see /admin/order/details page from IP %s", $_SERVER['REMOTE_ADDR']));
//        $app->render('access_denied.html.twig');
//    }
//});
