<?php
require_once('db.php');
?>
<!DOCTYPE HTML>
<meta charset="UTF-8">
<head>
  <title>Invoice.</title>
</head>
<body>
<table>
<?php foreach($db_countList->list as $key => $value) : ?>
<tr>
  <td><?php echo $key;?></td>
  <td><?php echo $value[0];?></td>
  <td><?php echo $value[1];?></td>
</tr>
<?php endforeach?>
</table>
</body>
