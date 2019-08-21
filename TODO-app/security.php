<?php
// bescherming tegen XSS aanvallen
function e($value){
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>
