<?php
  include("require.php");
  unset($_SESSION['user']);
  session_destroy();
  header("location: customer.php");
?>