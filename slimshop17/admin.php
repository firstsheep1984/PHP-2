<?php

if (false) {
    $app = new \Slim\Slim();
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

$app->post('/admin/products/:action(/:id)', function($action, $id = 0) use ($app) {
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
    if ($errorList) { // STATE 2: failed submission
        $app->render('admin/products_addedit.html.twig', array(
            'errorList' => $errorList,
            'v' => array('id' => $id,
                'name' => $name, 'description' => $description,
                'price' => $price)));
    } else { // STATE 3: successful submission
        if ($action == 'add') {
            DB::insert('products', array('name' => $name, 'description' => $description,
                'price' => $price, 'imagePath' => ''));
            $app->render('admin/products_addedit_success.html.twig');
        } else {
            DB::update('products', array('name' => $name, 'description' => $description,
                'price' => $price, 'imagePath' => ''), 'id=%i', $id);
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
