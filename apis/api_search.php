<?php
if (is_csrf_valid() != true) {
  http_response_code(404);
  exit();
}

// Validate
if (!isset($_POST['search_for'])) {
  http_response_code(400);
  exit();
}
if (strlen($_POST['search_for']) < 2) {
  http_response_code(400);
  exit();
}
if (strlen($_POST['search_for']) > 20) {
  http_response_code(400);
  exit();
}



try {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/db/db.php');
  // full text search
  $q = $db->prepare('SELECT product_id, product_title, product_description, product_price, product_category, product_image
                      FROM products 
                      WHERE product_title LIKE :product_title AND product_status = 1
                      LIMIT 20');
  $q->bindValue(':product_title', '%' . trim($_POST['search_for']) . '%');
  $q->execute();
  $products = $q->fetchAll();

  header("Content-type:application/json");
  echo json_encode($products);
} catch (PDOException $ex) {
  echo $ex;
}
