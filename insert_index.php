<?php
    session_start();
    require 'connect.php';
    if (!isset($_SESSION['keywords'])) {
        //header("Location:./index.html");
    }
    $keywords=$_SESSION['keywords'];
    $docnum=$_SESSION['docnum'];
    $position=0;
    //var_dump($_SESSION['keywords']);
    $cmdcou=0;
    foreach ($keywords as $item) {
        //$cmdlst['$cmdcou']="update(".array("term" => $item ,'$addToSet' => array("document_number" => $docnum)).");";
        $result=$db->invindex->findAndModify(array("term" => $item),
          array('$set' => array("document_number" => $docnum)),null, array("upsert" => true));
    }
    if ($result) {
        echo "done";
    }
    else echo "error";
?>
