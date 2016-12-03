<?php
require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
    <title><?php echo($AppName); ?></title>
    <meta name="description" content="pr0n">
    <meta name="keywords" content="pr0n">
    <link type='text/css' rel='stylesheet' href='misc/css/style.css' />
	<script src="misc/js/jquery.js"></script>
    <style>
        #content {
<?php
  function RandImg($dir)
	{
		$images = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
		$randomImage = $images[array_rand($images)];
		return $randomImage;
	}

		$the_image = RandImg('misc/img/bg/');
		echo '            background-image: url(\'' . $the_image . '\');';
?>

        }
    </style>
	
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
    $("a.insane").click(function(e){
        if(!confirm('CONTENT WARNING:\nThis gallery has been flagged as Offensive For Everyone. Due to its content, it should not be viewed by anyone.\n \n (And if you choose to ignore this warning, you lose all rights to complain about it in the future.)')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    <div id="head">
    </div>
    <div id="content">
        <p>&nbsp;</p>
        <br />
        <div id="container">
            <table>
                <caption>
                    <div id="logo">
                        <ul>
                            <li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?p=list" title="Last <?php echo $DisplayLatestMedias; ?> links">[&#x2605; Home &#x2605;]</a></li>
                            <li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?p=random" title="Get <?php echo $DisplayLatestMedias; ?> random">[&#x2605; Random &#x2605;]</a></li>
                            <li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?p=tags" title="Tags list">[&#x2605; Tags &#x2605;]</a></li>
					<?php /*<li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?p=cats" title="Last <?php echo $DisplayLatestMedias; ?> Categories">[&#x2605; Cats &#x2605;]</a></li> */ ?>
                        </ul>
                    </div>
                </caption>
            </table>
	<?php
		if (!is_string($_GET['p'])) $_GET['p']=null;
		$page = htmlentities($_GET['p']);
		
		if (file_exists('cludes/' . $page . '.inc.php'))
			{
				require('cludes/' . $page . '.inc.php');
			}
		else
			{	
				require('cludes/list.inc.php');
			}
	?>

        </div>
    </div>
    <div id="foot">
	
		  <?php
		  $mysql = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	
	if (!$mysql)
		die('Cannot connect to MySQL host...');
	
				$ret = mysqli_query($mysql, 'SELECT COUNT(media_url) FROM medias'); 
				if (!$ret){
					echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>SQL Error.</font></b></center></td></tr></table><br />");
					die;
				}
				while($datas = mysqli_fetch_assoc($ret))
				$homany = $datas['COUNT(media_url)'];
			mysqli_close($mysql);
		?>
        <span><?php echo($AppName . ' v' . $AppVersion . ' | DB: ' . $homany); ?> | <a href="https://github.com/Xyl2k?tab=repositories">Github</a></span>
    </div>
</body>
</html>