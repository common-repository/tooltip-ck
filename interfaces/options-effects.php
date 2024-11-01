<div>
	<label for="<?php echo $this->fields->getId( 'fxduration' ); ?>"><?php _e( 'Opening speed','tooltip-ck'); ?></label>
	<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/hourglass.png" />
	<?php echo $this->fields->render('text', 'fxduration') ?>ms
</div>
<div>
	<label for="<?php echo $this->fields->getId( 'dureebulle' ); ?>"><?php _e( 'Closing delay','tooltip-ck'); ?></label>
	<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/hourglass.png" />
	<?php echo $this->fields->render('text', 'dureebulle') ?>ms
</div>
<div>
	<label for="<?php echo $this->fields->getId( 'fxType' ); ?>"><?php _e('Effect type', 'tooltip-ck'); ?></label>
	<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/chart_curve.png" />
	<?php $options_fxType = array(
		'both' => __('Height and Width', 'tooltip-ck')
		, 'horizontal' => __('Width only', 'tooltip-ck')
		, 'vertical' => __('Height only', 'tooltip-ck')
		, 'fade' => __('Fade', 'tooltip-ck')
		);
	?>
	<?php echo \Tooltipck\Helper::renderProMessage() ?>
</div>
<div>
	<label for="<?php echo $this->fields->getId( 'tipPosition' ); ?>"><?php _e('Tip Position', 'tooltip-ck'); ?></label>
	<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/edit-image-center.png" />
	<?php $options_tipPosition = array(
		'right' => __('Right', 'tooltip-ck')
		, 'top' => __('Top', 'tooltip-ck')
		, 'left' => __('Left', 'tooltip-ck')
		, 'bottom' => __('Bottom', 'tooltip-ck')
		);
	?>
	<?php echo \Tooltipck\Helper::renderProMessage() ?>
</div>