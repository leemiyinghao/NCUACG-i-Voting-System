<?php
ini_set('display_errors',"0");
session_start();
if(empty($_SESSION['screen_name'])){
    header("Location: ./index.php");
}else{
    $screen_name = $_SESSION['screen_name'];
}
$id = empty($_GET['id'])?"none":$_GET['id'];
require_once('db.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>NCUACG i-Voting System BETA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="" />
    <meta name="copyright" content="" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
  </head>
  <body>
    <div class="page-container">
      <div class="navbar navbar-inverse">
	<div class="container">
	  <a href="./" class="navbar-brand">NCUACG i-Voting<span style="color: cyan"> BETA</span></a>
<?php if(empty($screen_name)) : ?>
	  <p class="navbar-right navbar-text">You have not yet login.</p>
<?php else : ?>
          <span class="navbar-right navbar-text">Logged as: <a href="https://twitter.com/<?php echo $screen_name?>" target="_blank" class="navbar-link"><?php echo $screen_name?></a></span>
	<?php endif; ?>
	</div>
      </div>
    </div>
    <div class="container">
<?php if(empty($_GET['id']) || $idNotFound == true) : ?>
    <h1>ERROR: VOTE ID NOT FOUND</h1><p>Please return to the top page.</p></div>
<?php elseif($db_votableList->contain($screen_name)) : ?>
      <div class="row">
	<form action="vote.php?id=<?php echo $_GET['id']?>" method="post">
<?php foreach($db_countList->list as $key => $value) : ?>
          <div class="voteblock col-lg-6">
	     <div class="h5outer">
	       <h5><?php echo $key;?></h5>
	     </div>
	     <br />
<?php if($value[2]!=NULL) : ?>
             <iframe width="450" height="253" src="https://www.youtube.com/embed/<?php echo $value[2]?>" frameborder="0" allowfullscreen></iframe>
	     <br>
<?php endif; ?>
<?php if($db_votedList->contain($screen_name)) : ?>
          <div class="disableradio">You have already voted.</div>
<?php else:?>
          <div class="input-outer">
	    <input id="<?php echo $key;?>.[0]" type="radio" name="<?php echo $key;?>" value="true" />
	    <label for="<?php echo $key;?>.[0]"><div class="radioPositive">PRESERVE</div></label>
	    <input id="<?php echo $key;?>.[3]" type="radio" name="<?php echo $key;?>" value="NULL" checked="checked" />
	    <label for="<?php echo $key;?>.[3]"><div class="radioNonjudge">NON-JUDGE</div></label>
	    <input id="<?php echo $key;?>.[1]" type="radio" name="<?php echo $key;?>" value="false" />
	    <label for="<?php echo $key;?>.[1]"><div class="radioNegative">DELETE</div></label>
	  </div>
<?php endif;?>
          <br>
        </div>
<?php endforeach; ?>
<?php if(!$db_votedList->contain($screen_name)) : ?>
    <br />
    <div class="container center submit-area">
    <div style="text-align:center;" class="btn-submit"><input type="submit" value="SUBMIT" class="btn btn-lg btn-primary btn-block"/></div>
    <i>Remind you, there is NO way to modify your vote after submit!</i>
    </div>
    <?php endif;?>
    </div>
  </form>
      </div>
    </div>
</div>
<?php elseif(!$db_votableList->contain($screen_name)) : ?>
    <h3>You have no permission to vote.</h3>
<?php else :?>
    <h3>Unkonw ERROR</h3>
<?php endif; ?>
    <div class="clear"></div>
<div id="footer">
      <i>NCUACG, All Right Reserve.</i>
      <br>
      <i>by catLee,leemiyinghao@gmx.com</i>
   </div>
</div>
</body></html>
