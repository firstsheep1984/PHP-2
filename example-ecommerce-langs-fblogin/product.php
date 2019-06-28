<?php

// Handling the product_view page
// First show of the product with static content
$app->get('/product/:slug', function($slug) use ($app) {
    $productRecord = DB::queryFirstRow("SELECT products.ID, price, picture,"
                    . " nutritionalValue, name, description FROM products, "
                    . "products_i18n WHERE  products_i18n.productID = products.ID AND products_i18n.slugname=%s", $slug);
    $productRecord['picture'] = base64_encode($productRecord['picture']);
     $app->render('product_view.html.twig', array(
        'product' => $productRecord));
});

//handle the ajax -> changing pages in reviews
$app->get('/reviews/product/:ID/page/:pageNum', function($ID, $pageNum) use ($app) {
    $start = ((int) $pageNum - 1) * ROWSPERPAGE;

    $reviewList = DB::query('SELECT ratingsreviews.ID, productID, '
                    . 'DATEDIFF(NOW(), date) AS daysCount, review, rating, customerFirstName FROM ratingsreviews'
                    . '  WHERE productID=%d ORDER BY ratingsreviews.ID DESC '
                    . 'LIMIT %d, %d', $ID, $start, ROWSPERPAGE * MAXPAGES);
    $availableRecords = DB::count();
    $maxPages = round($availableRecords / ROWSPERPAGE);
    $pageReviewList = array();
    if (count($reviewList) < ROWSPERPAGE) {
        $pageReviewList = $reviewList;
        $maxPages = 0;
    } else {
        for ($x = 0; $x < ROWSPERPAGE; $x++) {
            $pageReviewList[$x] = $reviewList[$x];
        }
    }
   
    $pagination = array('min' => max(($pageNum - MAXPAGES - 1), 1), 'max' => $maxPages, 'current' => $pageNum);
    $app->render('reviews.html.twig', array(
        'reviewList' => $pageReviewList,
        'pag' => $pagination
    ));
});


//ajax=> refresh the average rating and number of comments for a products
$app->get('/rating/:ID', function($ID) use ($app) {
    $average = DB::queryFirstField('SELECT avg(rating) as average FROM ratingsreviews WHERE rating >0 AND productID=%d ORDER BY productID', $ID);
    $totalReviews = DB::queryFirstField('SELECT count(review) as totalReviews FROM ratingsreviews WHERE productID=%d ORDER BY productID', $ID);
    $app->render('rating.html.twig', array(
        'reviewCount' => $totalReviews,
        'ratingAverage' => round($average)
    ));
});
// Add a new review
$app->post('/reviews/product/:ID', function($ID) use ($app, $log) {
    $body = $app->request->getBody();
    $record = json_decode($body, TRUE);
    if (!isReviewPostValid($record, $error)) {
        $log->debug("Failed POST . Invalid data. " . $error);
        $app->response->setStatus(400);
        echo json_encode($error);
        return;
    }
    $customerID = "";
    $customerFirstName = "";
    if ($_SESSION['user']) {
        $customerID = $_SESSION['user']['ID'];
        $customerFirstName = $_SESSION['user']['firstName'];
    } elseif ($_SESSION['facebook_access_token']) {
        $customerID = $_SESSION['facebook_access_token']['userID'];
        $customerFirstName = $_SESSION['facebook_access_token']['firstName'];
    } else {
        echo json_encode("Unauthorized user");
        return;
    }
    DB::insert('ratingsreviews', array(
        'productID' => $record['productID'],
        'customerID' => $customerID,
        'date' => DB::sqleval("NOW()"),
        'rating' => $record['rating'],
        'review' => $record['review'],
        'customerFirstName' => $customerFirstName,
    ));

    echo DB::insertId();
    // POST / INSERT is special - returns 201
    $app->response->setStatus(201);
});

function isReviewPostValid($review, &$error) {

    if (count($review) != 4) {
        $error = 'Invalid number of fields in data provided';
        return FALSE;
    }
    if (!isset($review['productID']) || (!is_numeric($review['productID']))) {
        $error = 'Product ID is not provided or it is not numeric';
        return FALSE;
    }
    if (strlen($review['review']) < 1 || strlen($review['review']) > 500) {
        $error = 'Review text is not valid';
        return FALSE;
    }
    if (!in_array($review['rating'], array("1", "2", "3", "4", "5", "0", ""))) {
        $error = 'Rating number of stars is invalid';
        return FALSE;
    }
    return TRUE;
}
