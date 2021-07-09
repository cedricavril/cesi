<?php
include 'inc/header.php';
function removeSpaces($string) {
	return str_replace(' ', '', $string);
}
?>

<div class="well">
	<?php echo removeSpaces('un test'); ?>
</div>

<?php
include 'inc/footer.php';
?>