<?php

    error_reporting(E_ALL ^ E_NOTICE);

    include '../includes/ajax.php';
    
    $latest = $_POST['latest'];
    
    $ajax = new ajax();
    $msgs = $ajax -> retrieveMessages($latest);
    $errors = $ajax -> retrieveErrors();
    
    $returnArr = array(
        
        "errors" => $errors,
        "msgs" => $msgs
        
    );

    echo json_encode($returnArr);
    
?>
