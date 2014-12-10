<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('db.php');
$screen_name;
if(empty($_SESSION['screen_name'])){
    if(!empty($_SESSION['access_token']) && !empty($_SESSION['access_token']['oauth_token']) && !empty($_SESSION['access_token']['oauth_token_secret'])) {
        $access_token = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $content = $connection->get('account/verify_credentials');
        $_SESSION['screen_name'] = $content->screen_name;
        $screen_name=$content->screen_name;
    }
}else{
    $screen_name = $_SESSION['screen_name'];
}
?>
<!DOCTYPE html>
<html><head>
<title>NCUACG i-Voting System BETA</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="" />
<meta name="copyright" content="" />
<link rel="stylesheet" type="text/css" href="css/kickstart.css" media="all" />
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/kickstart.js"></script>
</head><body>
    <nav class="navbar">
    <ul style="width:100%">
	<li><a href="./"><span>NCU</span>ACG i-Voting</a><span>BETA</span></li>
<?php if(empty($screen_name)) : ?>
	<li style="float:right;margin:1em;">You have not yet login.</li>
<?php else : ?>
	<li style="float:right;margin:1em;"><span>Logged as: </span><?php echo $screen_name?></li>
<?php endif; ?>
    </ul>
    </nav>
    <div class="grid">
      <div class="col_12 column">
<?php if(empty($screen_name)) : ?>
        <h3>Please Sign in with your Twitter account.</h3>
        <a href="./redirect.php"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>
<?php elseif($db_votableList->contain($screen_name) && !$db_votedList->contain($screen_name)) : ?>
        <h3>只是個測試投票</h3>
	<div class="col_12">
	<form action="vote.php" method="post">
<?php foreach($db_countList->list as $key => $value) : ?>
<?php echo $key;?>: 
	  <input type="radio" name="<?php echo $key;?>" value="true" />
	  <input type="radio" name="<?php echo $key;?>" value="false" />
	  <br />
<?php endforeach; ?>
	  <input type="submit" value="sent"/>
	</form>
	</div>
      </div>
    </div>
<?php elseif(!$db_votableList->contain($screen_name)) : ?>
    <h3>You have no permission to vote.</h3>
<?php elseif($db_votedList->contain($screen_name)) : ?>
    <h3>You have voted.</h3>
<?php else :?>
    <h3>Unkonw ERROR</h3>
<?php endif; ?>
    <div class="clear"></div>
<div id="footer">
    by catLee,leemiyinghao@gmx.com
</div>

</body></html>
