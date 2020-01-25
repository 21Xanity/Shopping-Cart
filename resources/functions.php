<?php
$upload_directory = "uploads";
function last_id(){
  global $connection;
  return mysqli_insert_id($connection);
}
  function set_message($msg){
    if(!empty($msg)){
      $_SESSION['message'] = $msg;
    }else{
      $msg = "";
    }
  }
  function display_message(){
    if(isset($_SESSION['message'])){
      echo $_SESSION['message'];
      unset($_SESSION['message']);
    }
  }
  function redirect($location){
    header("Location: $location");
  }
  function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
  }
  function confirm($result){
    global $connection;
    if(!$result){
      die("QUERY FAILED " . mysqli_error($connection));
    }
  }
  function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
  }
  function fetch_array($result){
    return mysqli_fetch_array($result);
  }
  function get_product(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)){
      $product_image = display_image($row['product_image']);
      $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="http://omeganub101-com.stackstaging.com/item.php?id={$row['product_id']}"><img src="../{$product_image}" alt="" style="height:260px; width:250px;"></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4>{$row['product_title']}</h4>
                    <p>{$row['product_short_description']}</p>
                    <a class="btn btn-primary" href="http://omeganub101-com.stackstaging.com/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
            </div>
        </div>
DELIMETER;
echo $product;
    }
  }
  function get_categories(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){
      $category_links = <<<DELIMETER
        <a href='http://omeganub101-com.stackstaging.com/category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
echo $category_links;
    }
  }
  function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query);
    while($row = fetch_array($query)){
      $product_image = display_image($row['product_image']);
      $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="http://omeganub101-com.stackstaging.com/item.php?id={$row['product_id']}"><img src="../{$product_image}" alt="" style="height:330px; width:350px;"></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4>{$row['product_title']}</h4>
                    <p>{$row['product_short_description']}</p>
                    <a class="btn btn-primary" href="http://omeganub101-com.stackstaging.com/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
            </div>
        </div>
DELIMETER;
echo $product;
    }
  }
  function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)){
      $product_image = display_image($row['product_image']);
      $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="http://omeganub101-com.stackstaging.com/item.php?id={$row['product_id']}"><img src="../{$product_image}" alt="" style="height:330px; width:350px;"></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4>{$row['product_title']}</h4>
                    <p>{$row['product_short_description']}</p>
                    <a class="btn btn-primary" href="http://omeganub101-com.stackstaging.com/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
            </div>
        </div>
DELIMETER;
echo $product;
    }
  }
  function login_user(){
    if(isset($_POST['submit'])){
      $username = escape_string($_POST['username']);
      $password = escape_string($_POST['password']);
      $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
      confirm($query);
      if(mysqli_num_rows($query) == 0){
        set_message("Your Password or Username is wrong.");
        redirect("http://omeganub101-com.stackstaging.com/login.php");
      }else{
        $_SESSION['username'] = $username;
        redirect("admin");
      }
    }
  }
  function send_message(){
    if(isset($_POST['submit'])){
      $to = "robertzhang2800@gmail.com";
      $from_name = $_POST['name'];
      $subject = $_POST['subject'];
      $email = $_POST['email'];
      $message = $_POST['message'];
      $headers = "From: {$from_name} {$email}";
      $result = mail($to, $subject, $message, $headers);
      if(!result){
        set_message("Sorry we could not send your message.");
        redirect("http://omeganub101-com.stackstaging.com/contact.php");
      }else{
        set_message("Your message has been sent.");
        redirect("http://omeganub101-com.stackstaging.com/contact.php");
      }
    }
  }
  function display_orders(){
    $query = query("SELECT * FROM orders");
    confirm($query);
    while($row = fetch_array($query)){
    $orders = <<<DELIMETER
    <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
        <td>{$row['order_status']}</td>
        <td><a class="btn btn-danger" href="../delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;
echo $orders;
    }
  }
  function get_product_in_admin(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)){
      $category = show_product_category_title($row['product_category_id']);
      $product_image = display_image($row['product_image']);
      $product = <<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
              <img src="../$product_image" style="width:150px; height:150px;" alt="">
            </td>
            <td>{$category}</td>
            <td>&#36;{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <!--<td><a href="index.php?edit_products&id={$row['product_id']}">edit</a></td>-->
            <td><a class="btn btn-danger" href="../delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $product;
    }
  }
  function add_product(){
    if(isset($_POST['publish'])){
    $product_title = escape_string($_POST['product_title']);
    $product_category_id = escape_string($_POST['product_category_id']);
    $product_price = escape_string($_POST['product_price']);
    $product_description = escape_string($_POST['product_description']);
    $product_short_description = escape_string($_POST['product_short_description']);
    $product_quantity = escape_string($_POST['product_quantity']);
    $product_image = escape_string($_FILES['file']['name']);
    $image_temp_location = escape_string($_FILES['file']['tmp_name']);
    move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);
    $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, product_short_description, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$product_short_description}', '{$product_quantity}', '{$product_image}')");
    $last_id = last_id();
    confirm($query);
    set_message("New Product with id {$last_id} was Added");
    redirect("index.php?products");
    }
  }
  function show_categories_add_product_page(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){
      $category_options = <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
echo $category_options;
    }
  }
  function show_product_category_title($product_category_id){
    $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}'");
    confirm($category_query);
    while($category_row = fetch_array($category_query)){
      return $category_row['cat_title'];
    }
  }
  function display_image($picture){
    global $upload_directory;
    return $upload_directory . DS . $picture;
  }
  function show_categories_in_admin(){
    $category_query = query("SELECT * FROM categories");
    confirm($category_query);
    while($row = fetch_array($category_query)){
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      $category = <<<DELIMETER
        <tr>
          <td>{$cat_id}</td>
          <td>{$cat_title}</td>
          <td><a class="btn btn-danger" href="../delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $category;
    }
  }
  function add_category(){
    if(isset($_POST['add_category'])){
      $cat_title = escape_string($_POST['cat_title']);
      if(empty(trim($_POST['cat_title']))){
        set_message("The field is empty.");
      }else{
      $insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
      confirm($insert_cat);
      set_message("Category created");
    }
    }
  }
  function display_users(){
    $category_query = query("SELECT * FROM users");
    confirm($category_query);
    while($row = fetch_array($category_query)){
      $user_id = $row['user_id'];
      $username = $row['username'];
      $email = $row['email'];
      $password = $row['password'];
      $user = <<<DELIMETER
        <tr>
          <td>{$user_id}</td>
          <td>{$username}</td>
          <td>{$email}</td>
          <td><a class="btn btn-danger" href="../delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $user;
    }
  }
  function add_user(){
    if(isset($_POST['add_user'])){
      $username = escape_string($_POST['username']);
      $email = escape_string($_POST['email']);
      $password = escape_string($_POST['password']);
      // $user_photo = escape_string($_FILES['file']['name']);
      // $photo_temp = escape_string($_FILES['file']['tmp_name']);
      // move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);
      $query = query("INSERT INTO users(username, email, password) VALUES('{$username}', '{$email}', '{$password}')");
      confirm($query);
      set_message("User created.");
      redirect("index.php?users");
    }
  }
  function get_reports(){
    $query = query("SELECT * FROM reports");
    confirm($query);
    while($row = fetch_array($query)){
      $report = <<<DELIMETER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $report;
    }
  }
?>
