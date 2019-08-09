<?php
function classAutoLoader($class) {
  $class = strtolower($class);
  $path = "includes/{$class}.php";

  if(is_file($path) && !class_exists($class)){
    require_once($path);
  } else {
    die("This file named {$class}.php was not found");
  }
}
spl_autoload_register('classAutoLoader');

function dd($variable){
  return die(var_dump($variable));
}

function redirect($location){
  header("Location: {$location}");
}

?>