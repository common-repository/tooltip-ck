<?php
/**
 * Plugin Name: Tooltip CK
 * Plugin URI: https://www.ceikay.com/plugins/tooltip-ck
 * Description: Tooltip CK allows you to put some nice tooltip effects into your content. Example : {tooltip}Text to hover{end-text}a friendly little boy{end-tooltip}
 * Version: 2.2.15
 * Author: Cédric KEIFLIN
 * Author URI: https://www.ceikay.com
 * License: GPL2
 * Text Domain: tooltip-ck
 * Domain Path: /language
 */
Namespace Tooltipck;

defined('ABSPATH') or die;

if (! defined('CK_LOADED')) define('CK_LOADED', 1);
if (! defined('TOOLTIPCK_VERSION')) define('TOOLTIPCK_VERSION', '2.2.15');
if (! defined('TOOLTIPCK_PLATFORM')) define('TOOLTIPCK_PLATFORM', 'wordpress');
if (! defined('TOOLTIPCK_PATH')) define('TOOLTIPCK_PATH', dirname(__FILE__));
if (! defined('TOOLTIPCK_MEDIA_PATH')) define('TOOLTIPCK_MEDIA_PATH', TOOLTIPCK_PATH);
if (! defined('TOOLTIPCK_ADMIN_GENERAL_URL')) define('TOOLTIPCK_ADMIN_GENERAL_URL', admin_url('', 'relative') . 'options-general.php?page=tooltip-ck');
if (! defined('TOOLTIPCK_MEDIA_URL')) define('TOOLTIPCK_MEDIA_URL', plugins_url('', __FILE__));
if (! defined('TOOLTIPCK_SITE_ROOT')) define('TOOLTIPCK_SITE_ROOT', ABSPATH);
if (! defined('TOOLTIPCK_URI_ROOT')) define('TOOLTIPCK_URI_ROOT', site_url());
if (! defined('TOOLTIPCK_URI_BASE')) define('TOOLTIPCK_URI_BASE', admin_url('', 'relative'));
if (! defined('TOOLTIPCK_PLUGIN_NAME')) define('TOOLTIPCK_PLUGIN_NAME', 'tooltip-ck');
if (! defined('TOOLTIPCK_SETTINGS_FIELD')) define('TOOLTIPCK_SETTINGS_FIELD', 'tooltip-ck_options');
if (! defined('TOOLTIPCK_WEBSITE')) define('TOOLTIPCK_WEBSITE', 'https://www.ceikay.com/plugins/tooltip-ck/');
// global vars
if (! defined('CEIKAY_MEDIA_URL')) define('CEIKAY_MEDIA_URL', 'https://media.ceikay.com');

class Tooltipck {

	public $pluginname, $options;

	private static $instance;

	static function getInstance() { 
		if (!isset(self::$instance))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	function init() {
		// load the translation
		add_action('plugins_loaded', array($this, 'load_textdomain'));

		require_once(dirname(__FILE__) . '/helpers/helper.php');
		$this->default_settings = Helper::getSettings();
		if (is_admin()) {

		} else {
			// fix for gutenberg editor, because is_admin is not defined during ajax save method
			if (isset($_SERVER['REDIRECT_URL']) && stristr($_SERVER['REDIRECT_URL'], 'wp-json')) {
				// do nothing because we are in a json request
			} else {
				// load frontend tooltip class
				require_once(TOOLTIPCK_PATH . '/includes/class.front.php');
				new Front();
			}
		}
	}

	function load_textdomain() {
		load_plugin_textdomain( 'tooltip-ck', false, dirname( plugin_basename( __FILE__ ) ) . '/language/'  );
	}

	public function admin_init() {
		register_setting( TOOLTIPCK_SETTINGS_FIELD, TOOLTIPCK_SETTINGS_FIELD);
	}

	public function admin_menu() {
		// add a new submenu to the standard Settings panel
		$this->pagehook = add_options_page(
		__('Tooltip CK'), __('Tooltip CK'), 
		'administrator', TOOLTIPCK_PLUGIN_NAME, array($this,'render_options') );

		// load the assets for the admin plugin page only
		add_action( 'admin_head-' . $this->pagehook, array($this, 'load_admin_assets'));
	}

	public function load_admin_assets() {
		wp_enqueue_style( 'ckframework', TOOLTIPCK_MEDIA_URL . '/assets/ckframework.css' );
		wp_enqueue_style( 'cookiesck-admin', TOOLTIPCK_MEDIA_URL . '/assets/admin.css' );
	
		wp_enqueue_media();
		wp_enqueue_script('postbox');
		wp_enqueue_script(array('jquery', 'jquery-ui-tooltip'));
		wp_enqueue_style( 'ckframework', TOOLTIPCK_MEDIA_URL . '/assets/ckframework.css' );
		wp_enqueue_style( 'tooltip-ck-admin', TOOLTIPCK_MEDIA_URL . '/assets/admin.css' );
		wp_enqueue_script('tooltip-ck-media', TOOLTIPCK_MEDIA_URL . '/assets/media.js', array('jquery'));
	}

	public function render_options() {
		require_once(TOOLTIPCK_PATH . '/helpers/ckfields.php');

		$this->options = get_option(TOOLTIPCK_SETTINGS_FIELD);
		$this->fields = new CKFields($this->options, TOOLTIPCK_SETTINGS_FIELD, $this->default_settings);
		require_once(TOOLTIPCK_PATH . '/interfaces/options.php');
	}

	public function copyright() {
		$html = array();
		$html[] = '<hr style="margin:10px 0;clear:both;" />';
		$html[] = '<div class="ckpoweredby"><a href="https://www.ceikay.com" target="_blank">https://www.ceikay.com</a></div>';
		$html[] = '<div class="ckproversioninfo"><div class="ckproversioninfo-title"><a href="' . TOOLTIPCK_WEBSITE . '" target="_blank">' . __('Get the Pro version', 'tooltip-ck') . '</a></div>
		<div class="ckproversioninfo-content">
<p>Position of the tooltip</p>
<p>Editor button for fast tooltip creation</p>
<p>Options for the tooltip effect (width, height, both, fade)</p>
<div class="ckproversioninfo-button"><a href="' . TOOLTIPCK_WEBSITE . '" target="_blank">' . __('Get the Pro version', 'tooltip-ck') . '</a></div>
		</div>';

		return implode($html);
	}

	public function show_plugin_links($links, $file) {
		if ($file == 'tooltip-ck/tooltip-ck.php') {
			array_push($links, '<a href="options-general.php?page=' . TOOLTIPCK_PLUGIN_NAME . '">'. __('Settings'). '</a>');
		}

		return $links;
	}
}

// load the process
$Tooltipck = Tooltipck::getInstance();
$Tooltipck->init();

// load the translation
add_action('plugins_loaded', array($Tooltipck, 'load_textdomain'));

add_action('admin_init', array($Tooltipck, 'admin_init'));

add_action('admin_menu', array($Tooltipck, 'admin_menu' ), 20);

// add the link in the plugins list
add_filter( 'plugin_action_links', array( $Tooltipck, 'show_plugin_links'), 10, 2 );