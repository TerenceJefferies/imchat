<?php

    error_reporting(E_ALL ^ E_NOTICE);

    include '../includes/ajax.php';
    
    $name = urldecode($_POST['name']);
    $message = urldecode($_POST['msg']);
    
    $ajax = new ajax();
    
    $msg = $ajax -> postNewMessage(array("name" => $name,"msg" => $message));
    $errors = $ajax -> retrieveErrors();
    
    $returnArr = array(
        
        "msg" => $msg,
        "errors" => $errors
        
    );
    
    echo json_encode($returnArr);

?>
