<?php
 /*
page : index.php?p=cats
le code php est permis et la connexion mysql est automatique.

*/
	$query = "SELECT * FROM `medias` where media_type_short_name='dj' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// dj = doujinshi

if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='mg' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// mg = manga
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='im' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// im = image
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='am' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// am = anime
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='gm' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// gm = game
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='rl' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// rl = real life
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}
?>
<br />
<?php
	$query = "SELECT * FROM `medias` where media_type_short_name='rp' ORDER BY media_id DESC LIMIT " .$DisplayLatestMedias;
	// rp = real life photo
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="80">-:Category</td>
                    <td width="500">-:Media</td>
                    <td width="196">-:Comment</td>
                </tr>
<?php

    /* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><div class="icon <?php echo(htmlentities($row["media_type_short_name"])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row["media_url"])); ?>" <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("class=\"insane\"");?> rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row["media_type_name"])); ?> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo ("*INSANE*");?>"><?php echo(htmlentities($row["media_title"])); ?></a> <?php if (isset($row["insane"]) && $row["insane"]=="1") echo (" <b><font color='red'>/!\\</font></b>");?></td>
                    <td><?php echo(htmlentities($row["media_comment"])); ?></td>
                </tr>
<?php
    }
echo ('</table>');
    /* Libération des résultats */
    mysqli_free_result($result);
}

/* Fermeture de la connexion */
mysqli_close($mysql);
?>