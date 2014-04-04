<div class="cont-widget cont-rating" data-datasetid="<?php echo $datasetid; ?>">
	<?php for($i = 1; $i<=10; $i++){ ?>
		<?php $checked = $rating>=$i&&$rating<($i+1); ?>
		<input name="rating-dataset-<?php echo $datasetid; ?>" value="<?php echo $i; ?>" type="radio" class="rating-star {split:2}" <?php echo $checked?'checked="checked"':''; ?> <?php echo $puedeEvaluar?'':'disabled="disabled"'; ?>/>
	<?php } ?>
</div>