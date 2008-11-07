<?php
function pr($var) {

    ob_start();
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    echo ob_get_clean();

}

function pre($var) {

    pr($var);
    exit;

}