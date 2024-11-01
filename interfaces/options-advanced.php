<div>
	<label for="<?php echo $this->fields->getId( 'htmlfixer' ); ?>" class="hasTooltip" title="<?php _e('This will automatically parse your html code into the tooltip to try to fix the issues. If you have any problem using html in the tooltip, you can try to disable it.','tooltip-ck'); ?>"><?php _e('Enable html fix','tooltip-ck'); ?></label>
	<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/html_valid.png" />
	<?php echo $this->fields->render('radio', 'htmlfixer') ?>
</div>