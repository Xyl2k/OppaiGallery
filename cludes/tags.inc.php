<?php
 /*
page : index.php?p=tags
le code php est permis et la connexion mysql est automatique.*/

	$query = 'CALL tags_count()';
	
if ($result = mysqli_query($mysql, $query)) {
?>
  <table>
                <tr>
                    <td width="776">-:TAGS</td>
                </tr>
				<tr>
                    <td><div class="tag-container field-name ">
<?php 
/* Récupère un tableau associatif */
    while ($row = mysqli_fetch_assoc($result)) {
?>
                        <span class="tags"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']);?>?p=search&s=<?php echo(htmlentities($row['tag_name'])); ?>" class="tag"><?php echo(htmlentities($row['tag_name'])); ?> <span class="count">(<?php echo(htmlentities($row['tag_count'])); ?>)</span></a></span>
<?php
	}
	        echo ('</div></td>');
			echo ('</tr>');
            echo ('</table>');
	mysqli_free_result($result);
}
mysqli_close($mysql);
?>