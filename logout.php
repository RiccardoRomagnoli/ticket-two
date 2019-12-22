<?php
require_once 'initializer.php';

logout();
header("location: index.php");

require 'template/base.php';
?>