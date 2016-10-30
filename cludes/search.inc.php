<?php
 /*
page : index.php?p=search
le code php est permis et la connexion mysql est automatique.*/

	if (!is_string($_GET['s'])) $_GET['s']=null; 
	if (isset($_GET['s'])){
	
	$query = 'CALL medias_by_tag(\'' . mysqli_real_escape_string($mysql, $_GET['s']) . '\');';
	
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
                    <td><div class="icon <?php echo(htmlentities($row['media_type_short_name'])); ?>"></div></td>
                    <td><a href="<?php echo(htmlentities($row['media_url'])); ?>" rel="follow" target="_blank" title="Type: <?php echo(htmlentities($row['media_type_name'])); ?>"><?php echo(htmlentities($row['media_title'])); ?></a></td>
                    <td><?php echo(htmlentities($row['media_comment'])); ?></td>
                </tr>
<?php
	}
echo '</table>';
	mysqli_free_result($result);
	}
	}
	else
		echo "no result";
	mysqli_close($mysql);
?>
