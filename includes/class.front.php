<?php
Namespace Tooltipck;

defined('ABSPATH') or die;

class Front {

	private static $instance;

	static function getInstance() { 
		if (!isset(self::$instance))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {
		add_action('wp_footer', array( $this, 'load_inline_css'));
		add_action('wp_enqueue_scripts', array( $this, 'load_assets_files'));
		$isDivi = isset($_REQUEST['page']) && $_REQUEST['page'] === 'et_theme_builder';
		if (! $isDivi) add_action('wp', array( $this, 'do_my_ob_start') );
		add_filter('the_content', array( $this, 'search_key' ), 0 );
//		add_action('template_redirect',array( $this, 'do_my_ob_start') );
	}

	function do_my_ob_start() {
		if (is_feed()) return;
		ob_start(array($this, 'search_key') );
	}

	function load_assets_files() {
		if (is_feed()) return;
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core ');
		wp_enqueue_style('tooltipck', TOOLTIPCK_MEDIA_URL . '/assets/tooltipck.css');
		wp_enqueue_script('tooltipck', TOOLTIPCK_MEDIA_URL . '/assets/tooltipck.js');
		$js = $this->get_inline_js();
		wp_add_inline_script('tooltipck', $js);
	}

	function get_inline_js() {
		$this->default_settings = Helper::getSettings();
		require_once(TOOLTIPCK_PATH . '/helpers/ckfields.php');
		$this->options = get_option(TOOLTIPCK_SETTINGS_FIELD);
		$this->fields = new CKFields($this->options, TOOLTIPCK_SETTINGS_FIELD, $this->default_settings);

		// mobile detection
		if (!class_exists('TooltipckMobileDetect')) {
			require_once dirname(__FILE__) . '/class.mobile-detect.php';
		}
		$detect = new \TooltipckMobileDetect;
		$fxTransition = 'linear';
		$fxtype = $this->fields->getValue('fxType', 'both');
		$fxDuration = $this->fields->getValue('fxduration', '300');
		$tipPosition = $this->fields->getValue('tipPosition', 'right');
		$delayOut = $this->fields->getValue('dureebulle', '500');
		$opacity = $this->fields->getValue('opacity', '0.9');
		$js = "
		// jQuery(window).load(function(){
		// jQuery(document).ready(function(){
		window.addEventListener('load', function(event) {
			new Tooltipck({ 
				fxTransition: '" . $fxTransition . "', 
				fxType: '" . $fxtype . "', 
				fxDuration: '" . $fxDuration . "', 
				tipPosition: '" . $tipPosition . "', 
				delayOut: '" . $delayOut . "', 
				opacity: '" . $opacity . "',
				isMobile: '" . ($detect->isMobile() ? '1' : '0') . "'
			});
		});
		";

		return $js;
	}

	function load_inline_css() {
		if (is_feed()) return;
	?>
		<style type="text/css">
		<?php echo $this->create_tooltip_css(); ?>
		</style>
	<?php
	}

	function search_key($content){
		$bypass = false;
		// check for the Amp plugin
		if (function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint()) {
			$content = str_replace('{tooltip}', '<span class="tooltipck">', $content);
			$content = str_replace('{end-texte}', '</span> <i class="tooltipck-tip-amp">', $content);
			$content = str_replace('{end-text}', '</span><i>', $content);
			$content = str_replace('{end-tooltip}', '</i>', $content);
			$bypass = true;
		}
		// simple check, if the class is not instanciated, then nothing to do here
		if (! $this->fields) $bypass = true;
		// check for feed
		if (is_feed()) $bypass = true;
		// check for Divi
		$isDivi = isset($_REQUEST['page']) && $_REQUEST['page'] === 'et_theme_builder';
		if ($isDivi) $bypass = true;

		if ($bypass == true) return $content;

		// test if the plugin is needed
		if (!stristr($content, "{tooltip}") && !stristr($content, "[tooltip]"))
			return $content;

		// load the php Class for the html fixer
		require_once dirname(__FILE__) . '/class.htmlfixer.php';

//		$regex = "#[{\[]tooltip[}\]](.*?)[{\[]end-tooltip[}\]]#s"; // search mask
		$regex = "#{tooltip}(.*?){end-tooltip}#s"; // search mask
		$content = preg_replace_callback($regex, array(__CLASS__, 'create_tooltip'), $content);

		return $content;
	}

	function create_tooltip($matches) {
		$isDivi = isset($_REQUEST['et_fb']) && $_REQUEST['et_fb'] === '1';
		if (! $this->fields) return '';
		if ($isDivi) return $matches[0];

		$ID = (int) (microtime(true) * 100000); // unique ID

		$tipWidth = $this->fields->getValue('stylewidth', '150');
		$fxduration = $this->fields->getValue('fxduration');
		$dureebulle = $this->fields->getValue('dureebulle');
		$tipoffsetx = $this->fields->getValue('tipoffsetx');
		$tipoffsety = $this->fields->getValue('tipoffsety');

		// get the text
//		$patterns = "#[{\[]tooltip[}\]](.*)[{\[](.*)[}\]](.*)[{\[]end-tooltip[}\]]#Uis";
		$patterns = "#[{]tooltip[}](.*)[{](.*)[}](.*)[{]end-tooltip[}]#Uis";
		$result = preg_match($patterns, $matches[0], $results);

		$text = $results[1];
		$params = $results[2];
		$tipContent = $results[3];

		// check if there is some custom params
		$relparams = Array();
		$params = explode('|', $params);
		$parmsnumb = count($params);
		for ($i = 1; $i < $parmsnumb; $i++) {
			$fxduration = stristr($params[$i], "time=") ? str_replace('time=', '', $params[$i]) : $fxduration;
			$dureebulle = stristr($params[$i], "delayOut=") ? str_replace('delayOut=', '', $params[$i]) : $dureebulle;
			$tipoffsetx = stristr($params[$i], "offsetx=") ? str_replace('offsetx=', '', $params[$i]) : $tipoffsetx;
			$tipoffsety = stristr($params[$i], "offsety=") ? str_replace('offsety=', '', $params[$i]) : $tipoffsety;
			$tipWidth = stristr($params[$i], "w=") ? str_replace('px', '', str_replace('w=', '', $params[$i])) : $tipWidth;
			$tipWidth = stristr($params[$i], "width=") ? str_replace('px', '', str_replace('width=', '', $params[$i])) : $tipWidth;
			// Legacy
			$fxduration = stristr($params[$i], "mood=") ? str_replace('mood=', '', $params[$i]) : $fxduration;
			$dureebulle = stristr($params[$i], "tipd=") ? str_replace('tipd=', '', $params[$i]) : $dureebulle;
		}

		// compile the rel attribute to inject the specific params
		$relparams['time'] = 'time=' . $fxduration;
		$relparams['delayOut'] = 'delayOut=' . $dureebulle;
		$relparams['offsetx'] = 'offsetx=' . $tipoffsetx;
		$relparams['offsety'] = 'offsety=' . $tipoffsety;

		$tooltiprel = '';
		if (count($relparams)) {
			$tooltiprel = ' rel="' . implode("|", $relparams) . '"';
		}

		// Parse the html code of the tooltip into a fixer to avoid bad rendering issues
		$htmlfixer = new \TooltipckHtmlFixer();
		if ($this->fields->getValue('htmlfixer', '1')) $tipContent = $htmlfixer->getFixedHtml($tipContent);

		// output the code
		$result = '<span class="tooltipck" id="tooltipck' . $ID . '"' . $tooltiprel . '>'
					. $text
					. '<span class="tooltipck-pointer"></span>'
					. '<span class="tooltipck-tip" data-width="' . Helper::testUnit($tipWidth) . '" style="width:' . Helper::testUnit($tipWidth) . ';">'
						. '<span class="tooltipck-inner">'
						. $tipContent
						. '</span>'
					. '</span>'
				. '</span>';

		return $result;
	}

	function create_tooltip_css() {
		if (! $this->fields) return '';

		$padding = $this->fields->getValue('padding') . 'px';
		$tipoffsetx = $this->fields->getValue('tipoffsetx') . 'px';
		$tipoffsety = $this->fields->getValue('tipoffsety') . 'px';
		$bgcolor1 = $this->fields->getValue('bgcolor1');
		$bgcolor2 = $this->fields->getValue('bgcolor2');
		$textcolor = $this->fields->getValue('textcolor');
		$roundedcornerstl = $this->fields->getValue('roundedcornerstl') . 'px';
		$roundedcornerstr = $this->fields->getValue('roundedcornerstr') . 'px';
		$roundedcornersbr = $this->fields->getValue('roundedcornersbr') . 'px';
		$roundedcornersbl = $this->fields->getValue('roundedcornersbl') . 'px';
		$shadowcolor = $this->fields->getValue('shadowcolor');
		$shadowblur = $this->fields->getValue('shadowblur') . 'px';
		$shadowspread = $this->fields->getValue('shadowspread') . 'px';
		$shadowoffsetx = $this->fields->getValue('shadowoffsetx') . 'px';
		$shadowoffsety = $this->fields->getValue('shadowoffsety') . 'px';
		$bordercolor = $this->fields->getValue('bordercolor');
		$borderwidth = $this->fields->getValue('borderwidth') . 'px';
		$shadowinset = $this->fields->getValue('shadowinset');
		$shadowinset = $shadowinset ? 'inset ' : '';
		// for shutter text
		$shuttercolor = $this->fields->getValue('shuttercolor');
		$shutterborderstyle = $this->fields->getValue('shutterborderstyle');
		$shutterborderwidth = $this->fields->getValue('shutterborderwidth');
		$shutteritalic = $this->fields->getValue('shutteritalic', '');

		$background = ( $this->fields->getValue('bgimage') ) ? 'background-image: url("' . get_site_url() . '/' . $this->fields->getValue('bgimage') . '")' . ';' : '';
		$background .= ( $this->fields->getValue('bgimage') AND $this->fields->getValue('bgimagerepeat') ) ? 'background-repeat: ' . $this->fields->getValue('bgimagerepeat') . ';' : '';
		$background .= ( $this->fields->getValue('bgimage') AND ($this->fields->getValue('bgpositionx') || $this->fields->getValue('bgpositiony')) ) ? 'background-position: ' . $this->fields->getValue('bgpositionx') . ' ' . $this->fields->getValue('bgpositiony') . ';' : '';

		$css = '.tooltipck-tip {'
				. 'padding: ' . $padding . ';'
				. 'border: ' . $bordercolor . ' ' . $borderwidth . ' solid;'
				. '-moz-border-radius: ' . $roundedcornerstl . ' ' . $roundedcornerstr . ' ' . $roundedcornersbr . ' ' . $roundedcornersbl . ';'
				. '-webkit-border-radius: ' . $roundedcornerstl . ' ' . $roundedcornerstr . ' ' . $roundedcornersbr . ' ' . $roundedcornersbl . ';'
				. 'border-radius: ' . $roundedcornerstl . ' ' . $roundedcornerstr . ' ' . $roundedcornersbr . ' ' . $roundedcornersbl . ';'
				. 'background-color: ' . $bgcolor1 . ';'
				. 'background-image: -moz-linear-gradient(top, ' . $bgcolor1 . ', ' . $bgcolor2 . ');'
				. 'background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(' . $bgcolor1 . '), to(' . $bgcolor2 . '));'
				. $background
				. 'color: ' . $textcolor . ';'
				. 'margin: ' . $tipoffsety . ' 0 0 ' . $tipoffsetx . ';'
				. '-moz-box-shadow: ' . $shadowinset . $shadowoffsetx . ' ' . $shadowoffsety . ' ' . $shadowblur . ' ' . $shadowspread . ' ' . $shadowcolor . ';'
				. '-webkit-box-shadow: ' . $shadowinset . $shadowoffsetx . ' ' . $shadowoffsety . ' ' . $shadowblur . ' ' . $shadowspread . ' ' . $shadowcolor . ';'
				. 'box-shadow: ' . $shadowinset . $shadowoffsetx . ' ' . $shadowoffsety . ' ' . $shadowblur . ' ' . $shadowspread . ' ' . $shadowcolor . ';'
				. '}';

		$css .= '.tooltipck {'
				. ($shuttercolor != '' ? 'color: ' . $shuttercolor . ';' : '')
				. ($shutterborderwidth ? 'border-bottom: ' . $shutterborderwidth . 'px ' . $shutterborderstyle . ';' : '')
				. ($shutteritalic == '1' ? 'font-style: italic;' : '')
				. '}';

		return $css;
	}
}

