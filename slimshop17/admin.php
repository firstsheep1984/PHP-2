<?php

if (false) {
    $app = new \Slim\Slim();
}

function RandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

$app->get('/admin/products/list', function() use ($app) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }
    $list = DB::query("SELECT * FROM products");
    $app->render('admin/products_list.html.twig', array('list' => $list));
});

// STATE 1: first show
$app->get('/admin/products/:action(/:id)', function($action, $id = 0) use ($app) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }
    if (($action == 'add' && $id != 0) || ($action == 'edit' && $id == 0)) {
        $app->notFound(); // 404 page
        return;
    }
    if ($action == 'add') {
        $app->render('admin/products_addedit.html.twig');
    } else { // edit
        $product = DB::queryFirstRow("SELECT * FROM products WHERE id=%i", $id);
        if (!$product) {
            $app->notFound();
            return;
        }
        $app->render('admin/products_addedit.html.twig', array('v' => $product));
    }
})->conditions(array('action' => '(add|edit)'));

$app->post('/admin/products/:action(/:id)', function($action, $id = 0) use ($app, $log) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }
    if (($action == 'add' && $id != 0) || ($action == 'edit' && $id == 0)) {
        $app->notFound(); // 404 page
        return;
    }
    //
    $name = $app->request()->post('name');
    $description = $app->request()->post('description');
    $price = $app->request()->post('price');
    //
    $errorList = array();
    // FIXME: sanitize html tags in name and description
    if (strlen($name) < 2 || strlen($name) > 100) {
        array_push($errorList, "Name must be 2-100 characters long");
        $name = "";
    }
    if (strlen($description) < 2 || strlen($description) > 2000) {
        array_push($errorList, "Description must be 2-2000 characters long");
        $description = "";
    }
    if ($price == "" || $price < 0 || $price > 999999.99) {
        array_push($errorList, "Price empty or out of range");
        $price = "";
    }
    $productImage = $_FILES['productImage'];
    // echo "<pre>111\n"; print_r($productImage); //exit;
    if ($productImage['error'] != 0) {
        array_push($errorList, "File submission failed, make sure you've selected an image (1)");
    } else {
        $data = getimagesize($productImage['tmp_name']);
        if ($data == FALSE) {
            array_push($errorList, "File submission failed, make sure you've selected an image (2)");
        } else {
            if (!in_array($data['mime'], array('image/jpeg', 'image/gif', 'image/png'))) {
                array_push($errorList, "File submission failed, make sure you've selected an image (3)");
            } else {
                // FIXME: sanitize file name, otherwise a security hole, maybe
                $productImage['name'] = strtolower($productImage['name']);
                if (!preg_match('/.\.(jpg|jpeg|png|gif)$/', $productImage['name'])) {
                    array_push($errorList, "File submission failed, make sure you've selected an image (4)");
                }
                $info = pathinfo($productImage['name']);
                $productImage['name'] = preg_replace('[^a-zA-Z0-9_\.-]', '_', $productImage['name']);
                if (file_exists('uploads/' . $productImage['name'])) {
                    // array_push($errorList, "File submission failed, refusing to override existing file (5)");
                    $num = 1;
                    
                    while (file_exists('uploads/' . $info['filename'] . "_$num." . $info['extension'])) {
                        $num++;
                    }
                    $productImage['name'] = $info['filename'] . "_$num." . $info['extension'];
                }
                // RANDOM NAME INSTEAD OF SANITIZATION
                // $productImage['name'] = RandomString(25) . "." . $info['extension'];
                // all good, nothing to do for now
            }
        }
    }
    //
    if ($errorList) { // STATE 2: failed submission
        $app->render('admin/products_addedit.html.twig', array(
            'errorList' => $errorList,
            'v' => array('id' => $id,
                'name' => $name, 'description' => $description,
                'price' => $price)));
    } else { // STATE 3: successful submission
        $imagePath = 'uploads/' . $productImage['name'];
        // DANGERS: // uploads/../slimshop17.php
        // 1. what if name begins with .. and escapes to an upper directory?
        // 2. what if the file extension is dangerous, e.g. php
        // 3. file overriding
        // $log->debug("a $imagePath " . $productImage['tmp_name']);
        if (!move_uploaded_file($productImage['tmp_name'], $imagePath)) {
            $log->err("Error moving uploaded file: " . print_r($productImage, true));
            $app->redirect('/internalerror');
            return;
        }
        if ($action == 'add') {
            DB::insert('products', array('name' => $name, 'description' => $description,
                'price' => $price, 'imagePath' => $imagePath));
            $app->render('admin/products_addedit_success.html.twig');
        } else {
            // remove the old file
            $oldImagePath = DB::queryFirstField("SELECT imagePath FROM products WHERE id=%i", $id);
            if ($oldImagePath != "" && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            DB::update('products', array('name' => $name, 'description' => $description,
                'price' => $price, 'imagePath' => $imagePath), 'id=%i', $id);
            $app->render('admin/products_addedit_success.html.twig', array('savedId' => $id));
        }
    }
})->conditions(array('action' => '(add|edit)'));

$app->get('/admin/products/delete/:id', function($id) use ($app, $log) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }//
    $item = DB::queryFirstRow("SELECT * FROM products WHERE id=%i", $id);
    if (!$item) {
        $app->notFound();
        return;
    }
    $app->render('admin/products_delete.html.twig', array('item' => $item));
});
$app->post('/admin/products/delete/:id', function($id) use ($app, $log) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }//
    if ($app->request()->post('confirmed') == 'true') {
        DB::delete("products", "id=%i", $id);
        $app->render('admin/products_delete_success.html.twig');
    } else {
        $app->redirect('/internalerror');
        return;
    }
});

$app->get("/admin/categories/add", function() use ($app, $log) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }//
    $app->render('admin/categories_add.html.twig');
});

$app->post("/admin/categories/add", function() use ($app, $log) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        $app->redirect('/forbidden');
        return;
    }//
    $name = $app->request()->post('name');
    //
    $errorList = array();
    // FIXME: sanitize html tags in name and description
    if (strlen($name) < 2 || strlen($name) > 100) {
        array_push($errorList, "Name must be 2-100 characters long");
        $name = "";
    }
    $image = $_FILES['image'];
    // echo "<pre>111\n"; print_r($productImage); //exit;
    if ($image['error'] != 0) {
        array_push($errorList, "File submission failed, make sure you've selected an image (1)");
    } else {
        $data = getimagesize($image['tmp_name']);
        if ($data == FALSE) {
            array_push($errorList, "File submission failed, make sure you've selected an image (2)");
        } else {
            if (!in_array($data['mime'], array('image/jpeg', 'image/gif', 'image/png'))) {
                array_push($errorList, "File submission failed, make sure you've selected an image (3)");
            } else {
                // all is good
            }
        }
    }
    //
    if ($errorList) { // STATE 2: failed submission
        $app->render('admin/categories_add.html.twig', array(
            'errorList' => $errorList, 'v' => array('name' => $name)));
    } else { // STATE 3: successful submission
            DB::insert('categories', array(
                'name' => $name,
                'imageData' => file_get_contents($image['tmp_name']),
                'imageMimeType' => $data['mime'],
                'imageFileName' => $image['name'] // no sanitazation required
                ));
            $app->render('admin/categories_add_success.html.twig');
    }
    
});

