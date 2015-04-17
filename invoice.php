<!DOCTYPE HTML>
<meta charset="UTF-8">
<head>
  <title>Invoice.</title>
</head>
<body>
<table>
<tr>
  <td>SongName</td>
  <td>PRESERVE</td>
  <td>DELETE</td>
</tr>   
<?php for($i=1;$i<=5;$i++) : ?>
<?php
$id = $i;
require_once('db.php');
$countListFileName = "count.$id.db";
$votedListFileName = "voted.$id.db";
$votableListFile = fopen("votable.db","r");
if(!file_exists($votedListFileName) && file_exists($countListFileName)){
    $votedListFile = fopen($votedListFileName,"w+");
    fclose($votedListFile);//touch votedListFile
}
$votedListFile = fopen($votedListFileName,"r");
$idNotFound = !file_exists($countListFileName) || !file_exists($votedListFileName);
if($idNotFound == FALSE){
    $countListFile = fopen($countListFileName,"r");
}
$db_votableList = new DBLIST;
$db_votedList = new DBLIST;
$db_countList = new DBVALUELIST;
while($buffer=fgets($votableListFile)){
    $db_votableList -> push($buffer);
}
fclose($votableListFile);
while($buffer=fgets($votedListFile)){
    $db_votedList -> push($buffer);
}
fclose($votedListFile);
while($buffer=fgets($countListFile)){
    $db_countList -> pushRaw($buffer);
}
fclose($countListFile);
?>
<?php foreach($db_countList->list as $key => $value) : ?>
<tr>
  <td><?php echo $key;?></td>
  <td><?php echo $value[0];?></td>
  <td><?php echo $value[1];?></td>
</tr>
<?php endforeach?>
<?php endfor; ?>
</table>
</body>
