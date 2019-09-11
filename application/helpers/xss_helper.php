<?php

// echo clean_print($object->value)
function clean_print($str)
{
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}

?>