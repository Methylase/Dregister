<?php
if(!function_exists('protectData')){
    function protectData($data){
  return   strip_tags(trim($data));
 }
}

?>

 