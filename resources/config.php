<?php
  ob_start();
  session_start();
  //session_destroy();
  defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
  defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS ."templates/front");
  defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS ."templates/back");
  defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS ."../public_html/uploads");
  $connection = mysqli_connect("shareddb-n.hosting.stackcp.net","ecomDB-3130372914","t9yt1o3ufo","ecomDB-3130372914");
  require_once("functions.php");
?>
