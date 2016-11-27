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
							<li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?faq">[&#x2605; FAQ &#x2605;]</a></li>
							<li><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?users">[&#x2605; Users &#x2605;]</a></li>
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
	
/* page : admin.php?faq
Affiche la FAQ */
	else if (isset($_GET['faq']))
	{
				$mediaTableDisplay = "0"; // Dirty hack pour ne pas afficher le tableau des medias définie plus bas dans le code
				echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">FAQ (Frequently Asked Questions)</i></h3></font></center></td></tr>";
				echo "<tr><td><center><b>These guidelines are only up to you and should be seen as hints, not as directives.</b></center></td></tr></table><br /><br />";
?>
<table width="776" border="0"><tr><td>
<p><h1>&#128293; Q&A:</h1></p><br />
<ul>
<li><strong>Q: What's the point of this media manager? I can get weeaboo porn somewhere else!</strong><br />
  <strong>A:</strong> Just like every other media manager, the main purpose of this one is providing  organized and consistent access to as much relevant content as possible. Yes, you could probably go to one site to get some hentai, another site for other hentai, yet another site for doujins, another one for JAV, etc etc. If you want to be able to sort through all that in a well organized way though, you come here. If you want to find a particular sort of medias then you come here. If you want to share your collection with a wealth of users who you know have the same passion for asian tits that you do, you come here.
</li>
</ul>
<br /><br />
<p>&nbsp;</p>
<h1><p>&#128293; Definitions:</h1>
There are many terms used in these FAQ that are generally poorly defined. For the sake of clarity, we will define those words as we mean them in this section.</p><br />
<ul>
<li><b>Pornography</b> - Content containing either nudity or sex acts.</li>
<li><b>Sex Act</b> - Any action performed for the sexual pleasure of either the person performing or receiving the action. Intercourse, masturbation, etc..</li>
<li><b>JAV</b> - Japanese Adult Video. Used only to describe published movies, and not things like amateur videos.</li>
<li><b>Anime</b> - A style of Japanese animation. Hentai anime may be referred to as h-anime.</li>
<li><b>Manga</b> - A style of Japanese comic books and graphic novels. Hentai manga may be referred to as h-manga.</li>
<li><b>Doujinshi</b> - Self-published manga. May be shortened to "doujin", which technically describes any self-published work, but is generally understood as referring to manga.</li>
<li><b>Tankoubon</b> - A manga book that is published as complete in and of itself. Used to refer to published stand-alone works and volumes in a larger manga series.</b></li>
<li><b>Anthology</b> - A published manga book containing works from several authors.</li>
<li><b>One-shot</b> - A self-contained manga work. Not part of any series. For our purposes, a work must be officially released by the creator on its own, not as part of an athology, to qualify as a one-shot.</li>
<li><b>Eroge</b> - Short for "erotic game". Basically, pornographic games. Used exclusively to describe games of Japanese origin. Also referred to as h-games.</li>
<li><b>Hentai</b> - A subgenre of anime, manga, and games characterized by being pornographic.</li>
<li><b>Nakadashi</b> - Cumming inside the pussy, in Japanese.</li>
<li><b>Futanary</b> - Someone(Usually in a doujinshi, but occasionally in normal fanfics or hentai), who appears to be female, but for some reason has male genatalia.</li>
<li><b>Netorare</b> - Literally means "cuckold" and shortened as NTR.</li>
<li><b>Shotacon</b> - A pairing, seen mostly as yaoi in fanfiction/art, in which there is a young underaged male engaged in a sexual act.</li>
<li><b>CG</b> - Computer Graphics.</li>
<li><b>Oppai</b> - part of chest for girls (japanese word of boobs).</li>
<li><b>Paizuri</b> - Breast fucking.</li>
<li><b>Rezu</b> - Lesbian in Japanese, usually used in a joking sense.</li>
<li><b>Bakunyuu</b> - literally meaning "explosive breasts". Used in reference for breasts that are the biggest of the big.</li>
<li><b>Chikan</b> - A term used for old guys on subways in Tokyo that sidle up to girls and totally violate them.</li>
<li><b>Xylitol</b> - Nick of the faggot who coded this shit.</li>
</ul><br /><br />
<p>&nbsp;</p>
<p><h1>&#128293; Tagging:</h1></p><br />
<ul>
<li>There is a list of official tags on <a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?mediatags">tags management</a>. Please use these tags instead of "unofficial" tags (e.g. use the official "<strong class="important_text_alt">paizuri</strong>" tag, instead of an unofficial "<strong class="important_text">titfuck</strong>" tag).</li>
<li>Avoid using multiple synonymous tags. Using both "<strong class="important_text">pissing</strong>" and "<strong class="important_text_alt">urination</strong>" is redundant and stupid — just use the official "<strong class="important_text_alt">urination</strong>" tag.</li>
<li>Do not add useless tags.</li>
<li><strong>If one more person tags something "<strong class="important_text">hentai</strong>" I swear to god I'm gonna go nuclear on your worthless ass.</strong></li>
<li><strong>Tags should reflect significant aspects of a media.</strong> Don't tag something with "<strong class="important_text">blowjob</strong>" if there's only 30 seconds of dick-sucking. However, certain tags may be acceptable, such as "<strong class="important_text_alt">stockings</strong>", even if the media in question isn't centered around that fetish. Be smart.</li>
<li><strong>Certain tags are strongly encouraged for appropriate medias:</strong> "<strong class="important_text_alt">3d</strong>", "<strong class="important_text_alt">anthology</strong>", "<strong class="important_text_alt">yuri</strong>", "<strong class="important_text_alt">yaoi</strong>". People search for these kinds of things specifically, so tagging them properly will get you more views.</li>
<li>Tags for game genres such as "<strong class="important_text_alt">rpg</strong>", "<strong class="important_text_alt">visual.novel</strong>", or "<strong class="important_text_alt">nukige</strong>" are encouraged.</li>
<li><strong>You should be able to build up a list of tags using only the official tags on <a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?mediatags">the tag management page</a>. If you are in any doubt about whether or not a tag is acceptable, do not add it.</strong><br />
</li>
</ul><br /><br />
<p>&nbsp;</p>
<p><h1>&#128293; Global common-sense:</h1></p><br />
<ul>
<li><strong>Only movies, anime, manga, and games are allowed on the site.</strong> <?php echo($AppName); ?> is a porn site.</li>
<li><strong>Additions should be pornographic.</strong> Again, this is a porn site. If you're in doubt, ask yourself, "does this make me wanna whack my gack?" If the answer is "no", don't add it, or add non-nude tag.</li>
<li><strong>Additions should be Japanese in origin.</strong> Do not add Western content.</li>
<li><strong>No advertising or personal credits.</strong> Providing artist, studio, publisher, or retailer information is not considered advertising.</li>
<li><strong>Do not advertise sites, groups, or persons in medias descriptions.</strong> Exception: media source information (e.g. ripper, scene group, crack group, or original uploader credit) is allowed in media descriptions.</li>
<li><strong>English and Japanese are the the languages of <?php echo($AppName); ?>.</strong> medias with neither English nor Japanese audio or text are forbidden. medias with dual audio that contain other languages in addition to English and/or Japanese are acceptable, however.</li>
<li><strong>Official English titles win.</strong> Translation can be hard. Some titles may have never been translated into English. We don't expect you to be a translator. If there's no official title, use the best English title you can find. If you find a media with a poor English translation and you think you have a better one, you may replace it, so long as you're not replacing an official title. If you're unsure if your translation is better, ask other administrators for assistance, that way when they say yes and it's a shit translation, we can yell at them instead of you.</li>
<li><strong>DO NOT PUT METADATA IN THE TITLE FIELD.</strong> You know what goes in the title field? The god damn title. Not the artist. Not the langauge. Not whether or not its censored. The fucking title. <strong>Metadata should go in description eventually.</strong> Next person I see putting dumb shit in the title field, especially if that dumb shit is release-specific like language or resolution, I'm banning your dense ass on the spot. For images, accepted title can be character name / series if no title can be found.</li>
<li><strong>medias contents should be clean.</strong> media should contain <strong>only</strong> relevant files. Do <strong>not</strong> include files such as promotional images or videos, screenshots, thumbs, ripper or encoder information, or urls to other sites. The exceptions are WEB releases, which may be added as-released and games, which may contain files such as READMEs.</li>
<li><strong>Multi-part archives in media files.</strong> No no no no no no no no no no no.</li>
<li><strong>Use the insanity check for gore/disgusting/controversial medias.</strong> It will display a warning confirmation to the user who want to browse it.</li>
<li><strong>3DCG content is considered to be Anime.</strong> It should not be added under Anime.</li>
<li><strong>Feel free to browse the site using proxies or Tor.</strong> We reserve the right to scrutinize your activity more than normal in these cases, but no harm, no foul. This includes VPNs with dynamic IP addresses.</li>
<li><strong>Attempting to find a bug in the site code is absolutely fine.</strong> Misusing that knowledge is not, but we actively encourage users to try to find bugs and report them so they can be fixed. The discovery of significant bugs may result in a reward at the discretion of the staff. Do not be an asshole and try to flood the manager or something and then come to us saying "lol I found bug gib reward".</li>
<li><strong>For Christ's sake don't add actual child pornography.</strong> It's ridiculous that I need to make this a rule.</li>
<li><strong>Pictures of Spiderman.</strong> Just don't.</li>
</ul>
</td></tr></table><br />
<?php				
	}
	
/* page : admin.php?users
Gestion des utilisateurs */
	else if (isset($_GET['users']))
	{
				$mediaTableDisplay = "0"; // Dirty hack pour ne pas afficher le tableau des medias définie plus bas dans le code
				echo "<table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">Users management</i></h3></font></center></td></tr>";
				echo "<tr><td><center><b>Here you can add users, if you plan to use " . $AppName . " in a community way.</b></center></td></tr></table>";
						
		if (isset($_POST['usr']) && !empty($_POST['usr']))
		{
			$usr = mysqli_real_escape_string($mysql, $_POST['usr']);
			
			//Dupecheck
			$check = mysqli_query($mysql, "SELECT user_name FROM users WHERE user_name='" . $usr ."' ");
			if (!$check){
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>SQL Error.</font></b></center></td></tr></table><br />");
				die;
			}

			$checkrows = mysqli_num_rows($check);

			if($checkrows>0) {
				$errors .= "\n <table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>User: " . htmlentities($usr) . " </font></b></center></td></tr><tr><td><center><b><font color='red'>Already exist !</font></b></center></td></tr></table><br />";
			}

			if(!empty($errors)){
				
				echo nl2br($errors);
			}

			if(empty($errors))
				{
					mysqli_query($mysql, "INSERT INTO users VALUES(null,'".$usr."')") or die(mysql_error());

					echo "<br /><table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($usr) . "</h3></font></center></td></tr>";
					echo ('<tr><td><center><b><font color="#AD1888">SUCCESS <script type="text/javascript">$(document).ready(function(){$(".redir a").click(function(){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?users";});var interval_redir = setInterval(function(){var remaining = parseInt($(".redir span").text(), 10)-1;if(remaining<=0){window.location.href="' . htmlentities($_SERVER['PHP_SELF']) . '?users";clearInterval("interval_redir");}else{$(".redir span").text(remaining);}}, 1000);});</script><div class="redir">You will be redirected in <span>' . $Redirect . '</span> second(s).<br /><a>Or click here</a></div></font></b></center></td></tr></table><br />');

				}
		}

?>
			<center>
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?users" method="POST">
					<p>
					<label for="usr">Add an user: </label><br />
					<input type="text" name="usr" maxlength="16" >
					<input  class="bouton" type="submit" value="Add" name="tag"><br />
					</p>
		  </form></center>
		  <br /><hr>
<?php
		if (isset($_GET['deluser']) && !empty($_GET['deluser']))
		{
		 
		$id = $_GET['deluser'];

		if (is_numeric($id))
		{
			$req = mysqli_query($mysql, "SELECT * FROM users WHERE user_id='".$id."'");
			
			if (mysqli_num_rows($req))
			{
				$data = mysqli_fetch_array($req);
				
				mysqli_query($mysql, "DELETE FROM users WHERE user_id='".$id."'");
				echo "<br /><center><p style=\"text-align:center;font-weight:bold;\">".$data['user_name']." was removed.</p></center><br />";
			}
			else
				echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Non-existent ID.</font></b></center></td></tr></table><br />");
		}
		else
			echo("<br /><table width=\"776\" border=\"0\"><tr><td><center><b><font color='red'>Invalid ID.</font></b></center></td></tr></table><br />");
	}

					$ret = mysqli_query($mysql, 'SELECT * FROM users ORDER BY user_id ASC');
					/* Récupère un tableau associatif */
					echo "<br /><strong class=\"important_text\">Warning</strong>: This will also delete <strong class=\"important_text\">ALL</strong> medias who was added by the user, use wisely.<br /><br />";
					echo "<strong>List of users</strong>:<ul>";
					while ($datas = mysqli_fetch_assoc($ret)) {
				    echo( '<li>' . htmlentities($datas['user_name']) . '<a href="' . htmlentities($_SERVER['PHP_SELF']) . '?users&deluser=' . htmlentities($datas['user_id']) .'" class="delete user"><font color="red">[X]</font></a></li>');
					}
					echo "</ul><br />";
					/* Libération des résultats */
					mysqli_free_result($ret);
	}


/* page : admin.php?mediatags
display des tags et des medias */
	else if (isset($_GET['mediatags']))
	{
$mediaTableDisplay = "0"; // Dirty hack pour ne pas afficher le tableau des medias définie plus bas dans le code
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
										echo "<br /><table width=\"776\" border=\"0\"><tr><td><center><font color=\"#D878C6\"><h3 style=\"text-align:center;\">" . htmlentities($_POST['selectedtag']) . "</h3></font></center></td></tr>";
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
					
<label class="collapse" for="tagshow">[CLICK HERE TO DISPLAY THE LIST OF TAGS]</label>
<input id="tagshow" type="checkbox">
<div>
		  <table>
                <tr>
                    <td width="776">Click on any tag to remove it from the database.</td>
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
            echo ('</table></div>');
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