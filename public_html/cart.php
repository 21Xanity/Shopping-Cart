<?php require_once("../resources/config.php"); ?>
<?php
if(isset($_GET['add'])){
  $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add'] . " "));
  confirm($query);
  while($row = fetch_array($query)){
    if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
      $_SESSION['product_' . $_GET['add']]+=1;
      redirect("http://omeganub101-com.stackstaging.com/checkout.php");
    }else{
      set_message("We only have " . $row['product_quantity'] . " {$row[product_title]}s" . " available.");
      redirect("http://omeganub101-com.stackstaging.com/checkout.php");
    }
  }
  //$_SESSION['product_' . $_GET['add']] +=1;

}
if(isset($_GET['remove'])){
  $_SESSION['product_' . $_GET['remove']]--;
  if($_SESSION['product_' . $_GET['remove']] < 1){
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("http://omeganub101-com.stackstaging.com/checkout.php");
  }else{
    redirect("http://omeganub101-com.stackstaging.com/checkout.php");
  }
}
if(isset($_GET['delete'])){
  $_SESSION['product_' . $_GET['delete']] = '0';
  unset($_SESSION['item_total']);
  unset($_SESSION['item_quantity']);
  redirect("http://omeganub101-com.stackstaging.com/checkout.php");
}
function cart(){
  $total = 0;
  $item_quantity = 0;
  $item_name = 1;
  $item_number = 1;
  $amount = 1;
  $quantity = 1;
  foreach($_SESSION as $name => $value){
    if($value > 0){
      if(substr($name, 0, 8) == "product_"){
        $length = strlen($name - 8);
        $id = substr($name, 8, $length);
        $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . "");
        confirm($query);
        while($row = fetch_array($query)){
          $sub = $row['product_price']*$value;
          $item_quantity += $value;
          $product_image = display_image($row['product_image']);
          $product = <<<DELIMETER
          <tr>
              <td>{$row['product_title']}<br>
              <img width='100' src="../$product_image">
              </td>
              <td>&#36;{$row['product_price']}</td>
              <td>{$value}</td>
              <td>&#36;{$sub}</td>
              <td><a class='btn btn-warning' href="http://omeganub101-com.stackstaging.com/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a></td>
              <td><a class='btn btn-success' href="http://omeganub101-com.stackstaging.com/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a></td>
              <td><a class='btn btn-danger' href="http://omeganub101-com.stackstaging.com/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a></td>
          </tr>
          <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
          <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
          <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
          <input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMETER;
      echo $product;
      $item_name++;
      $item_number++;
      $amount++;
      $quantity++;
      $_SESSION['item_total'] = $total += $sub;
      $_SESSION['item_quantity'] = $item_quantity;
        }
      }
    }
  }
}
function show_paypal(){
  if(isset($_SESSION["item_quantity"]) AND $_SESSION["item_quantity"] != 0) {
  $paypal_button = <<<DELIMETER
    <input type="image" name-"upload" border="0"
    src="https:/www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
DELIMETER;
return $paypal_button;
}
}
function process_transaction(){
  if(isset($_GET['tx'])){
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];
  $total = 0;
  $item_quantity = 0;
  foreach($_SESSION as $name => $value){
    if($value > 0){
      if(substr($name, 0, 8) == "product_"){
        $length = strlen($name) - 8;
        $id = substr($name, 8, $length);
        $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . "");
        confirm($query);
        while($row = fetch_array($query)){
          $product_price = $row['product_price'];
          $product_title = $row['product_title'];
          $sub = $row['product_price']*$value;
          $item_quantity += $value;
          $insert_report = query("INSERT INTO reports (product_id, order_id, product_price, product_title, product_quantity) VALUES('{$id}', '{$last_id}', '{$product_price}', '{$product_title}', '{$value}')");
          confirm($insert_report);
        }
        $total += $sub;
        $item_quantity;
      }
    }
  }
  $send_order = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) VALUES('{$amount}', '{$transaction}', '{$status}', '{$currency}')");
  $last_id = last_id();
  confirm($send_order);
  session_destroy();
}else{
  redirect("index.php");
}
}
?>
