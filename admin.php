<?php
require_once('config.php');
$mediaTableDisplay = "1"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
    <title><?php echo($AppName); ?> - Mini admin</title>
    <link type='text/css' rel='stylesheet' href='misc/css/style.css' />
	<script src="misc/js/jquery-1.7.2.min.js"></script>
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
    $("a.delete").click(function(e){
        if(!confirm('Are you sure?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});

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
        <BR>
        <div id="container">
            <table>
                <caption>
                    <div id="logo">
                        <ul>
                            <li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?add">[&#x2605; Add a link &#x2605;]</a></li>
							<li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?mediatags">[&#x2605; Tag a link &#x2605;]</a></li>
                        </ul>
                    </div>
                </caption>
            </table>
<?php
/* page : admin.php?add
Ajout de media */
$errors = '';
	if (isset($_GET['add']))
	{	
		if (isset($_POST['add']) && isset($_POST['mediatitle']) && isset($_POST['mediacomment']) && isset($_POST['mediaurl']) && isset($_POST['mediatypeshortname'])  && isset($_POST['userid']) && is_numeric($_POST['insane']))
		{
			$mediatitle = mysqli_real_escape_string($mysql, $_POST['mediatitle']);
			$mediacomment = mysqli_real_escape_string($mysql, $_POST['mediacomment']);
			$mediaurl = mysqli_real_escape_string($mysql, $_POST['mediaurl']);
			$mediatypeshortname = mysqli_real_escape_string($mysql, $_POST['mediatypeshortname']);
			$userid  = mysqli_real_escape_string($mysql, $_POST['userid']);
			$insanity  = mysqli_real_escape_string($mysql, $_POST['insane']);
			
			//Dupecheck
			$check = mysqli_query($mysql, "SELECT media_url FROM medias WHERE media_url='" . $mediaurl ."' ");
			if (!$check){
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>SQL Error.</font></b></center></td></tr></table><br />");
				die;
			}

			$checkrows = mysqli_num_rows($check);

			if($checkrows>0) {
				$errors .= "\n <br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Dupecheck: " . htmlentities($mediaurl) . " </font></b></center></td></tr><tr><td><center><b><font color='red'>Already on DB !</font></b></center></td></tr></table>";
			}

			if(!empty($errors)){
				
				echo nl2br($errors);
			}

			if(empty($errors))
				{
					mysqli_query($mysql, "INSERT INTO medias VALUES(null,'".$mediatitle."','".$mediacomment."','".$mediaurl."','".$mediatypeshortname."','".$userid."','".$insanity."')") or die(mysql_error());

					echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($mediatitle) . "</h3></font></center></td></tr>";
					echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?add";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?add";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');

					}
		}
		else
		{
		?>
        <br />
		<center>
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?add" method="POST">
					<p>
					<label for="TITLE">TITLE: </label><br />
					<input type="text" name="mediatitle" maxlength="64" ><br /><br />
					<label for="COMMENT">COMMENT: </label><br />
					<input type="text" name="mediacomment" placeholder="Optional" maxlength="128" style="width:253;"><br /><br />
					<label for="LINK">LINK: </label><br />
					<input type="text" name="mediaurl" maxlength="2048" style="width:252;"><br /><br />
					<label for="MEDIA SHORT NAME">CATEGORY: </label>
					<select name="mediatypeshortname" size="1">
					<option selected value="am">(am) Anime</option>
					<option value="dj">(dj) Doujinshi</option>
					<option value="gm">(gm) Games</option>
					<option value="im">(im) Image</option>
					<option value="mg">(mg) Manga</option>
					<option value="rl">(rl) Real Life</option>
					<option value="rp">(rp) Real Life Photo</option>
					</select><br /><br />
					<label for="USER">USER: </label>
					<select name="userid" size="1">
					<option selected value="1">UID: 1</option>
					<?php
						$ret = mysqli_query($mysql, 'SELECT * FROM users ORDER BY user_id DESC');
							    /* Récupère un tableau associatif */
								while ($datas = mysqli_fetch_assoc($ret)) {
					?>
<option value="<?php echo(htmlentities($datas['user_id'])); ?>"><?php echo(htmlentities($datas['user_name'])); ?></option>
					<?php
					}
    /* Libération des résultats */
    mysqli_free_result($ret);
					?>
					</select><br /><br />
					<label for="INSANE">INSANITY CHECK: </label>
					<input type="radio" name="insane" checked value="0">No
					<input type="radio" name="insane" value="1">Yes<br /><br />
					<input class="bouton" type="submit" value="Add" name="add"><br/>
					</p>
		  </form></center><br /><hr>
  
		<?php
/* page : admin.php?del
Supression de media */
		}
	}

	else if (isset($_GET['del']) && !empty($_GET['del']))
	{
		$id = $_GET['del'];

		if (is_numeric($id))
		{
			$req = mysqli_query($mysql, "SELECT * FROM medias WHERE media_id='".$id."'");
			
			if (mysqli_num_rows($req))
			{
				$data = mysqli_fetch_array($req);
				
				mysqli_query($mysql, "DELETE FROM medias WHERE media_id='".$id."'");
				echo "<br /><center><p style=\"text-align:center;font-weight:bold;\">".$data['media_url']." was removed.</p></center><br />";
			}
			else
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Non-existent ID.</font></b></center></td></tr></table><br />");
		}
		else
			echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Invalid ID.</font></b></center></td></tr></table><br />");
	}

/* page : admin.php?mediatags
display des tags et des medias */
	else if (isset($_GET['mediatags']))
	{
$mediaTableDisplay = "0";
		if (isset($_POST['selectedtitle']) && isset($_POST['selectedtag']))
		{
			$id = $_POST['selectedtitle'];
			$insane = $_POST['insane'];
		
				if (is_numeric($id) && is_numeric($id))
				{
								//Dupecheck
								$check = mysqli_query($mysql, "SELECT media_id, tag_name FROM medias_tags WHERE media_id='" . mysqli_real_escape_string($mysql, $id) ."' and tag_name='" . mysqli_real_escape_string($mysql, $_POST['selectedtag']) ."'");
								if (!$check){
								echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>SQL Error.</font></b></center></td></tr></table><br />");
								die;
								}

								$checkrows = mysqli_num_rows($check);

								if($checkrows>0) {
								$errors .= "\n <br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Dupecheck: " . htmlentities($_POST['selectedtag']) . " </font></b></center></td></tr><tr><td><center><b><font color='red'>Already on DB !</font></b></center></td></tr></table>";

								}
								
								if(!empty($errors)){
									echo nl2br($errors);
										}
			
								if(empty($errors))
									{
										$ret = mysqli_query($mysql, "INSERT INTO medias_tags VALUES('". mysqli_real_escape_string($mysql, $id) ."', '". mysqli_real_escape_string($mysql, $_POST['selectedtag']) ."')") or die(mysql_error());
										echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($_POST['selectedtag']) . "</h3></font></center></td></tr>";
                                        echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');
									}
				}
				else 
				{
					echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Invalid ID.</font></b></center></td></tr></table><br />");
				}
		}
		
		else if (isset($_POST['keyword'])) 
		{
		$tag = $_POST['keyword'];
			//Dupecheck
			$check = mysqli_query($mysql, "SELECT * FROM tags WHERE tag_name='" . mysqli_real_escape_string($mysql, $tag) . "' ");
			
			if (!$check){
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>SQL Error.</font></b></center></td></tr></table><br />");
				die;
			}
			$checkrows = mysqli_num_rows($check);

			if($checkrows>0) {
				$errors .= "\n <br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Dupecheck: " . htmlentities($tag) . " </font></b></center></td></tr><tr><td><center><b><font color='red'>Already on DB !</font></b></center></td></tr></table>";

			}

			if(!empty($errors)){
				echo nl2br($errors);
			}
			
			if(empty($errors))
				{
					if (!empty($tag)) {
							mysqli_query($mysql, "INSERT INTO tags VALUES('".$tag."')") or die(mysql_error());
							echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($tag) . "</h3></font></center></td></tr>";
							echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');
						}
						else {
							echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Tag is empty...</font></b></center></td></tr></table><br />");
						}
				}
		}

else if (isset($_GET['word']) && !empty($_GET['word']))
	{
				$ret = mysqli_query($mysql, "SELECT * FROM tags WHERE tag_name='" .mysqli_real_escape_string($mysql, $_GET['word']) ."' LIMIT 1");
				$checkrows = mysqli_num_rows($ret);

				if ($checkrows > 0) {
					$ret =  mysqli_query($mysql, "DELETE FROM tags WHERE tag_name='".mysqli_real_escape_string($mysql, $_GET['word']) . "'");
					echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">The tag: <i>" . htmlentities($_GET['word']) . " was removed.</i></h3></font></center></td></tr>";
					echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');
				}
				else {
					echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>tag not found</font></b></center></td></tr></table><br />");
				}
			}

			else
		{
		?>
        <br />
			<center>
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?mediatags" method="POST">
					<p>
					<label for="TAG">Create a new tag: </label><br />
					<input type="text" name="keyword" maxlength="16" >
					<input  class="bouton" type="submit" value="Add" name="tag"><br/>
					</p>
		  </form></center><br />
		  <center>or...</center><br />

				<center><form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?mediatags" method="POST">
				<label for="TAG">Tag a media:</label><br />
				<select name="selectedtitle" size="1"><br />
					<?php
					$ret = mysqli_query($mysql, 'SELECT media_id, media_title FROM medias ORDER BY media_id DESC ');
/* Récupère un tableau associatif */
    while ($datas = mysqli_fetch_assoc($ret)) {
?>
                <option value="<?php echo(htmlentities($datas['media_id'])); ?>"><?php echo(htmlentities($datas['media_title'])); ?></option>
<?php
	}
	/* Libération des résultats */
    mysqli_free_result($ret);
?>
					</select>
				<select name="selectedtag" size="1"><br />
					<?php
					$ret = mysqli_query($mysql, 'SELECT * FROM tags where 1');
/* Récupère un tableau associatif */
    while ($datas = mysqli_fetch_assoc($ret)) {
?>
                <option value="<?php echo(htmlentities($datas['tag_name'])); ?>"><?php echo(htmlentities($datas['tag_name'])); ?></option>
<?php
	}
	/* Libération des résultats */
    mysqli_free_result($ret);
?>
					</select>
					<input  class="bouton" type="submit" value="Add"><br/>
					</p>
					</form></center><br />
		  <table>
                <tr>
                    <td width="776">Tag remove:</td>
                </tr>
				<tr>
                    <td><div class="tag-container field-name ">
<?php 
/* Récupère un tableau associatif */
$ret = mysqli_query($mysql, 'SELECT * FROM tags');	
    while ($row = mysqli_fetch_assoc($ret)) {
?>
                        <span class="tags"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?mediatags&word=<?php echo(htmlentities($row['tag_name'])); ?>" class="delete tag"><?php echo(htmlentities($row['tag_name'])); ?> <span class="count">[X]</span></a></span>
<?php
	}
	        echo ('</div></td>');
			echo ('</tr>');
            echo ('</table>');
			?>
<br /><hr>

            <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Tag</td>
                    <td>-:Untag</td>
                </tr>
					<?php
						$ret = mysqli_query($mysql, 'SELECT media_type_short_name, media_url, medias_tags.media_id, media_title, tag_name, insane FROM medias_tags, medias WHERE medias_tags.media_id = medias.media_id ORDER BY media_id DESC LIMIT ' . $AdminDisplay);
							
							/* Récupère un tableau associatif */
							while ($datas = mysqli_fetch_assoc($ret)) {
					?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($datas['media_type_short_name'])); ?>"></div></td>
					 <td><a href="<?php echo(htmlentities($datas['media_url'])); ?>" <?php if (isset($datas["insane"]) && $datas["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank"><?php echo(htmlentities($datas['media_title'])); ?></a> <?php if (isset($datas["insane"]) && $datas["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><p class="tag"><?php echo(htmlentities($datas['tag_name'])); ?></p></td>
                    <td><center><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?tagid=<?php echo(htmlentities($datas['media_id'])); ?>&tagname=<?php echo(htmlentities($datas['tag_name'])); ?>" class="delete"><img style="border: none;" src="misc/img/Erase.png" title="Untag <?php echo(htmlentities($datas['tag_name'])); ?>"></a></center></td>
                </tr>

					<?php
					}
					?>	
					</table>
					
		<?php
		}
	}

/* page : admin.php?tagid
Supression de tag */
		else if (isset($_GET['tagid']) && !empty($_GET['tagid']) && isset($_GET['tagname']))
	{
		$id = $_GET['tagid'];

		if (is_numeric($id))
		{
			$req = mysqli_query($mysql, "SELECT * FROM medias_tags WHERE media_id='".$id."' and tag_name='" . mysqli_real_escape_string($mysql, $_GET['tagname']) . "'");
		
			if (mysqli_num_rows($req))
			{
				$data = mysqli_fetch_array($req);
				
				mysqli_query($mysql, "DELETE FROM medias_tags WHERE media_id='".$id."' and tag_name='" . mysqli_real_escape_string($mysql, $_GET['tagname']) . "'");
				echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">The tag: <i>" . htmlentities($_GET['tagname']) . " was removed.</i></h3></font></center></td></tr>";
				echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?mediatags";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');

			}
			else
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Non-existent ID.</font></b></center></td></tr></table><br />");
		}
		else
			echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Invalid ID.</font></b></center></td></tr></table><br />");
	}

/* page : admin.php?edit
Edition de media */
	else if (isset($_GET['edit']) && !empty($_GET['edit']))
	{
		$id = $_GET['edit'];
		
		if (is_numeric($id))
		{
			$req = mysqli_query($mysql, "SELECT * FROM medias WHERE media_id='".$id."'");
			
			if (mysqli_num_rows($req))
			{
				if (isset($_POST['mediatitle']) && isset($_POST['mediacomment']) && isset($_POST['mediaurl']) && isset($_POST['mediatypeshortname']) && is_numeric($_POST['insane']))
				{
					$mediatitle = mysqli_real_escape_string($mysql, $_POST['mediatitle']);
					$mediacomment =  mysqli_real_escape_string($mysql, $_POST['mediacomment']);
					$mediaurl = mysqli_real_escape_string($mysql, $_POST['mediaurl']);
					$mediatypeshortname = mysqli_real_escape_string($mysql, $_POST['mediatypeshortname']);
					$insanitycheck = mysqli_real_escape_string($mysql, $_POST['insane']);
					mysqli_query($mysql, "UPDATE medias SET media_title='".$mediatitle."', media_comment='".$mediacomment."', media_url='".$mediaurl."', media_type_short_name='".$mediatypeshortname."', insane='".$insanitycheck."'  WHERE media_id='".$id."'") or die(mysql_error());
					echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($mediatitle) . "</h3></font></center></td></tr>";
					echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');
					
				}
				else
				{
					$data = mysqli_fetch_array($req);
					
					?>
					<center><form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?edit=<?php echo $data['media_id'];?>" method="POST">
					<p>
                    <br />
					<label for="TITLE">TITLE: </label><br />
					<input type="text" name="mediatitle" value="<?php echo htmlentities($data['media_title']);?>"><br /><br />
					<label for="COMMENT">COMMENT: </label><br />
					<input type="text" name="mediacomment" value="<?php echo htmlentities($data['media_comment']);?>" style="width:253;"><br /><br />
		
					<label for="URL">URL: </label><br />
					<input type="text" name="mediaurl" value="<?php echo htmlentities($data['media_url']);?>" style="width:252;"><br /><br />
					
					<label for="INSANE">INSANITY CHECK: </label>
					<input type="radio" name="insane"
					<?php if (isset($data['insane']) && $data['insane']=="0") echo "checked";?>
					value="0">No
					<input type="radio" name="insane"
					<?php if (isset($data['insane']) && $data['insane']=="1") echo "checked"; ?>
					value="1">Yes<br /><br />
					<label for="MEDIA SHORT NAME">CATEGORY:</label><br />
					<select name="mediatypeshortname" size="1"><br />
					<option value="<?php echo htmlentities($data['media_type_short_name']);?>" selected><?php echo htmlentities($data['media_type_short_name']);?></option>
					<option value="am">(am) Anime</option>
					<option value="dj">(dj) Doujinshi</option>
					<option value="gm">(gm) Games</option>
					<option value="im">(im) Image</option>
					<option value="mg">(mg) Manga</option>
					<option value="rl">(rl) Real Life</option>
					<option value="rp">(rp) Real Life Photo</option>
					</select>
					<input  class="bouton" type="submit" value="Update"><br/>
					</p>
					</form></center><br /><hr>
					<?php
				}
			}
			else
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Non-existent ID.</font></b></center></td></tr></table><br />");
		}
		else
			echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Invalid ID.</font></b></center></td></tr></table><br />");
	}

	if ($mediaTableDisplay == "0") {
	/* On ne shouaite pas afficher le tableau des last links car admin.php?mediatags a été demander */
	}
	else {
	?>
   <br /><center><br />
   <center><form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
   Search (LINK or TITLE): <input name="search" type="text">
   <input type="submit" value="Search"><br /></form><br />
   </center><br />
            <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                    <th>Edit</th>
                    <th>Del</th>
                </tr>

<?php
/* page : admin.php?search
Recherche de media */
	if (isset($_POST['search']))
		$ret = mysqli_query($mysql, 'SELECT * FROM medias WHERE media_url LIKE "%'.mysqli_real_escape_string($mysql, $_POST['search']).'%" OR media_title LIKE "%'.mysqli_real_escape_string($mysql, $_POST['search']).'%" ORDER BY media_id DESC LIMIT 20');
	else
/* Si pas de recherche on affiche le tableau des derniers liens */
		$ret = mysqli_query($mysql, 'SELECT * FROM medias ORDER BY media_id DESC LIMIT ' . $AdminDisplay);

			$mediatitle = mysqli_real_escape_string($mysql, $_POST['mediatitle']);
			$mediacomment = mysqli_real_escape_string($mysql, $_POST['mediacomment']);
			$mediaurl = mysqli_real_escape_string($mysql, $_POST['mediaurl']);
			$mediatypeshortname = mysqli_real_escape_string($mysql, $_POST['mediatypeshortname']);
			
/* Récupère un tableau associatif */
    while ($datas = mysqli_fetch_assoc($ret)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($datas['media_type_short_name'])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($datas['media_url'])); ?>" <?php if (isset($datas["insane"]) && $datas["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank"><?php echo(htmlentities($datas['media_title'])); ?></a> <?php if (isset($datas["insane"]) && $datas["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($datas['media_comment'])); ?></td>
                    <td><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?edit=<?php echo(htmlentities($datas['media_id'])); ?>"><img style="border: none;" src="misc/img/Modify.png" title="Edit this media"></a></td>
                    <td><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?del=<?php echo(htmlentities($datas['media_id'])); ?>" class="delete"><img style="border: none;" src="misc/img/Erase.png" title="Delete this media" ></a></td>
                </tr>
<?php
	}
	echo "</table>";
	mysqli_free_result($ret);
	}
?>	
			<br />
			<br />
        </div>
    </div>
    <div id="foot">
		  <?php
				$ret= mysqli_query($mysql, 'SELECT COUNT(media_url) FROM medias'); 
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