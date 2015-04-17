<?php
session_start();
$id = empty($_GET['id'])?"none":$_GET['id'];
require_once("db.php");
$votedFile = fopen("voted.$id.db","r");
$hasVoted = false;
while($votedUser=fgets($votedFile)){
    if($_SESSION['screen_name'] == substr($votedUser,0,-1)){
        $hasVoted = true;
        break;
    }
}
fclose($votedFile);
if($db_votableList->contain($_SESSION['screen_name']) && $hasVoted == false){
    foreach($_POST as $key => $value){
        //echo ($value=="true")?"t":"f";
        if($value=="NULL")
            continue;
        $db_countList->pushValue($key,($value=="true")?TRUE:FALSE);
    }
    $countListFile = fopen("count.$id.db","w+");
    foreach($db_countList->list as $key => $value){
        fputs($countListFile,$key."%".$value[0]."%".$value[1]."%".$value[2]."\n");
        //echo $key."%".$value[0]."%".$value[1]."%".$value[2];
    }
    array_push($db_votedList->list,$_SESSION['screen_name']);
    $votedListFile = fopen("voted.$id.db","w+");
    foreach($db_votedList->list as $value){
        fputs($votedListFile,$value."\n");
    }
}
header('Location: ./index.php');
?>