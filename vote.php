<?php
session_start();
require_once("db.php");
if($db_votableList->contain($_SESSION['screen_name'])){
    foreach($_POST as $key => $value){
        //echo ($value=="true")?"t":"f";
        $db_countList->pushValue($key,($value=="true")?TRUE:FALSE);
    }
    $countListFile = fopen("count.db","w+");
    foreach($db_countList->list as $key => $value){
        fputs($countListFile,$key."%".$value[0]."%".$value[1]."\n");
        //echo $key."%".$value[0]."%".$value[1];
    }
    array_push($db_votedList->list,$_SESSION['screen_name']);
    $votedListFile = fopen("voted.db","w+");
    foreach($db_votedList->list as $value){
        fputs($votedListFile,$value."\n");
    }
}
header('Location: ./index.php');
?>