<div class="ckheading"><?php _e('Colors ans Styles','tooltip-ck') ?></div>
		<div>
			<label for="<?php echo $this->fields->getId( 'bgcolor1' ); ?>"><?php _e( 'Background Color', 'tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/color.png" />
			<?php echo $this->fields->render('color', 'bgcolor1') ?>
			<?php echo $this->fields->render('color', 'bgcolor2') ?>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'bgimage' ); ?>"><?php _e( 'Background Image','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/image.png" />
			<?php echo $this->fields->render('media', 'bgimage') ?>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsetx.png" /></span><span style="width:30px;"><?php echo $this->fields->render('text', 'bgpositionx') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsety.png" /></span><span style="width:30px;">
			<?php echo $this->fields->render('text', 'bgpositiony') ?>
			</span>
			<?php $options_bgrepeat = array(
				'repeat' =>'img:'.CEIKAY_MEDIA_URL.'/images/bg_repeat.png'
				, 'repeat-x'=>'img:'.CEIKAY_MEDIA_URL.'/images/bg_repeat-x.png'
				, 'repeat-y'=>'img:'.CEIKAY_MEDIA_URL.'/images/bg_repeat-y.png'
				, 'no-repeat'=>'img:'.CEIKAY_MEDIA_URL.'/images/bg_no-repeat.png'
				);
			?>
				<span class="hasTooltip" title="<?php _e('Image repeat','tooltip-ck'); ?>"><?php echo $this->fields->render('radio', 'bgimagerepeat', '', $options_bgrepeat) ?></span>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'opacity' ); ?>"><?php _e( 'Opacity','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/layers.png" />
			<?php echo $this->fields->render('text', 'opacity') ?>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'textcolor' ); ?>"><?php _e( 'Text Color','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/color.png" />
			<?php echo $this->fields->render('color', 'textcolor') ?>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'roundedcorners' ); ?>"><?php _e( 'Border radius','tooltip-ck'); ?></label>
			
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/border_radius_tl.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Top left','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'roundedcornerstl') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/border_radius_tr.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Top right','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'roundedcornerstr') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/border_radius_br.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Bottom right','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'roundedcornersbr') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/border_radius_bl.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Bottom left','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'roundedcornersbl') ?></span>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'shadowcolor' ); ?>"><?php _e( 'Shadow','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/shadow_blur.png" />
			<span><?php echo $this->fields->render('color', 'shadowcolor') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/shadow_blur.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Blur','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'shadowblur') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/shadow_spread.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Spread','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'shadowspread') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsetx.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Offset X','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'shadowoffsetx') ?></span>
			<span><img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsety.png" /></span><span style="width:30px;" class="hasTooltip" title="<?php _e('Offset Y','tooltip-ck'); ?>"><?php echo $this->fields->render('text', 'shadowoffsety') ?></span>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'bordercolor' ); ?>"><?php _e( 'Border','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/shape_square.png" />
			<span><?php echo $this->fields->render('color', 'bordercolor') ?></span>
			<span style="width:30px;"><?php echo $this->fields->render('text', 'borderwidth') ?></span> px
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'padding' ); ?>"><?php _e('Padding', 'tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/padding.png" />
			<span style="width:30px;"><?php echo $this->fields->render('text', 'padding') ?></span> px
		</div>
		<div class="ckheading"><?php _e('Dimensions and Position') ?></div>
		<div>
			<label for="<?php echo $this->fields->getId( 'stylewidth' ); ?>"><?php _e( 'Tooltip width','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/width.png" />
			<?php echo $this->fields->render('text', 'stylewidth') ?>px
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'tipoffsetx' ); ?>"><?php _e( 'Tooltip Offset X','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsetx.png" />
			<?php echo $this->fields->render('text', 'tipoffsetx') ?>px
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'tipoffsety' ); ?>"><?php _e( 'Tooltip Offset Y','tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/offsety.png" />
			<?php echo $this->fields->render('text', 'tipoffsety') ?>px
		</div>
		<div class="ckheading"><?php _e('Text to hover styles', 'tooltip-ck') ?></div>
		<div>
			<label for="<?php echo $this->fields->getId( 'shuttercolor' ); ?>"><?php _e('Color', 'tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/color.png" />
			<?php echo $this->fields->render('color', 'shuttercolor') ?>
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'shutterbordercolor' ); ?>"><?php _e('Decoration', 'tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/border-dash.png" />
			<?php $options_textborderstyle = array(
				'solid' => __('solid', 'tooltip-ck')
				, 'dashed'=> __('dashed', 'tooltip-ck')
				, 'dotted'=> __('dotted', 'tooltip-ck')
				);
			?>
			<?php echo $this->fields->render('select', 'shutterborderstyle', null, $options_textborderstyle) ?>
			<?php echo $this->fields->render('text', 'shutterborderwidth') ?>px
		</div>
		<div>
			<label for="<?php echo $this->fields->getId( 'shutteritalic' ); ?>"><?php _e('Italic', 'tooltip-ck'); ?></label>
			<img class="ckicon" src="<?php echo CEIKAY_MEDIA_URL ?>/images/edit-italic.png" />
			<?php echo $this->fields->render('radio', 'shutteritalic') ?>
		</div>
