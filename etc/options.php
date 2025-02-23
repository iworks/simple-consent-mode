<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function iworks_simple_consent_mode_options() {
	$options = array();
	//$parent = SET SOME PAGE;
	/**
	 * main settings
	 */
	$options['index'] = array(
		'version'         => '0.0',
		'use_tabs'        => true,
		'page_title'      => esc_html__( 'Cookie Consent', 'simple-consent-mode' ),
		'menu'            => 'options',
		'enqueue_scripts' => array(
			'iw_scm_admin',
		),
		'options'         => array(
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Main', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'm_main_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show Description', 'simple-consent-mode' ),
				'default'           => 1,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'm_main_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Consents Modal Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'wp_kses_post',
				'classes'           => array( 'large-text' ),
				'default'           => esc_html__( 'This website uses cookies to ensure you get the best experience on our website.', 'simple-consent-mode' ),
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 10,
				'since'             => '1.0.0',
			),
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'Buttons', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'btn_allow',
				'type'              => 'text',
				'th'                => esc_html__( 'Allow All', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Allow All Consents', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'btn_choose',
				'type'              => 'text',
				'th'                => esc_html__( 'Choose Consents', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Choose Consents', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'btn_deny',
				'type'              => 'text',
				'th'                => esc_html__( 'Deny All Consents', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Deny', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'btn_close',
				'type'              => 'text',
				'th'                => esc_html__( 'Close', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Close', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			/**
			 * Design
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Colors', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'type'  => 'subheading',
				'label' => __( 'Box', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'c_primary',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Primary', 'simple-consent-mode' ),
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'c_accent',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Accent', 'simple-consent-mode' ),
				'default'           => '#97f',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'c_checkbox',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Checkbox', 'simple-consent-mode' ),
				'default'           => '#ae9',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			array(
				'type'  => 'subheading',
				'label' => __( 'Icon', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'i_primary',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Icon Primary', 'simple-consent-mode' ),
				'default'           => '#db8',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'i_accent',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Icon Accent', 'simple-consent-mode' ),
				'default'           => '#964',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			/**
			 * Required Consents
			 */
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Required Consents', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			/**
			 * analytics_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Analytics Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Controls whether data related to website usage and user behavior can be stored for analytics purposes (e.g., Google Analytics).', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'name'              => 'anst_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Analytic Storage', 'simple-consent-mode' ),
				'codename'          => 'analytics_storage',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'anst_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Controls whether data related to website usage and user behavior can be stored for analytics purposes (e.g., Google Analytics).', 'simple-consent-mode' ),
				'since'             => '1.0.0',
				'sanitize_callback' => 'wp_kses_post',
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 5,
			),
			/**
			 * ad_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Manages whether advertising-related data (like targeting and tracking cookies) can be stored and processed for ad services.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'name'              => 'adst_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad Storage', 'simple-consent-mode' ),
				'codename'          => 'ad_storage',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'adst_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'classes'           => array( 'large-text' ),
				'default'           => esc_html__( 'Manages whether advertising-related data (like targeting and tracking cookies) can be stored and processed for ad services.', 'simple-consent-mode' ),
				'since'             => '1.0.0',
				'sanitize_callback' => 'wp_kses_post',
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 5,
			),
			/**
			 * ad_personalization
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad Personalization', 'simple-consent-mode' ),
				'description' => esc_html__( 'Determines if personalized ads can be shown based on user behavior and preferences, using stored data for targeting.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'name'              => 'adpe_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad Personalization', 'simple-consent-mode' ),
				'codename'          => 'ad_personalization',
				'since'             => '1.0.0',
				'sanitize_callback' => 'wp_kses_post',
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 5,
			),
			array(
				'name'              => 'adpe_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Determines if personalized ads can be shown based on user behavior and preferences, using stored data for targeting.', 'simple-consent-mode' ),
				'since'             => '1.0.0',
				'sanitize_callback' => 'wp_kses_post',
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 5,
			),
			/**
			 * ad_user_data
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad User Data', 'simple-consent-mode' ),
				'description' => esc_html__( 'Controls the storage of user-specific data for ad tracking, profiling, and measuring ad effectiveness.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'name'              => 'auda_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad User Data', 'simple-consent-mode' ),
				'codename'          => 'ad_user_data',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'auda_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Controls the storage of user-specific data for ad tracking, profiling, and measuring ad effectiveness.', 'simple-consent-mode' ),
				'since'             => '1.0.0',
				'sanitize_callback' => 'wp_kses_post',
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 5,
			),
			/**
			 * Custom Consents
			 * /
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Custom Consents', 'simple-consent-mode' ),
			),
			/**
			 * functional_storage
			 * /
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Functional Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Manages the storage of cookies for non-essential functions like site preferences, login status, and custom settings.', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'fust_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show', 'simple-consent-mode' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
			),
			array(
				'name'              => 'fust_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Functionality', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'fust_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Manages the storage of cookies for non-essential functions like site preferences, login status, and custom settings.', 'simple-consent-mode' ),
			),
			/**
			 * personalization_storage
			 * /
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Personalization Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Regulates whether data used to provide personalized user experiences (like content recommendations) can be stored.', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'pest_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show', 'simple-consent-mode' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
			),
			array(
				'name'              => 'pest_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Personalizations', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'pest_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Regulates whether data used to provide personalized user experiences (like content recommendations) can be stored.', 'simple-consent-mode' ),
			),
			/**
			 * cookie
			 */
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Cookie', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'Cookie', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'cookie_version',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Version', 'simple-consent-mode' ),
				'default'           => 1,
				'sanitize_callback' => 'absint',
				'description'       => esc_html__( 'Changing the cookie version requires you to obtain new consent. This should be done in the event of changes to the scope of required consents.', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			/**
			 * Consent Log
			 */
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Log', 'simple-consent-mode' ),
				'since' => '1.1.0',
			),
			array(
				'name'              => 'log_status',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Enable', 'simple-consent-mode' ),
				'default'           => 1,
				'description'       => esc_html__( ' Enable or disable consent logging as needed.', 'simple-consent-mode' ),
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.1.0',
			),
			array(
				'name'              => 'log_duration',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Duration', 'simple-consent-mode' ),
				'default'           => 12,
				'sanitize_callback' => 'absint',
				'description'       => esc_html__( 'The "Log Duration" setting specifies the length of time, in months, that log entries will be retained. Once the selected duration has passed, the system will automatically delete any log entries older than the chosen period. This helps manage storage and ensures logs are only kept for a predefined, manageable timeframe.', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			array(
				'th'          => __( 'Export', 'simple-consent-mode' ),
				'name'        => 'log_export',
				'value'       => __( 'Export CSV File', 'simple-consent-mode' ),
				'type'        => 'button',
				'since'       => '1.1.0',
				'description' => esc_html__( 'The "Export CSV File" feature allows you to download the consents log in a CSV format. This provides an easy way to view, analyze, and share consent data in a structured, spreadsheet-compatible file.', 'simple-consent-mode' ),
			),

			/**
			 * About Consent Mode
			 */
			array(
				'type'        => 'heading',
				'label'       => esc_html__( 'About Consent Mode', 'simple-consent-mode' ),
				'description' => esc_html__( 'Consent Mode is a tool provided by Google that allows websites to adjust the behavior of Google tags (such as Google Analytics, Google Ads, and others) depending on the user\'s consent for data processing. It enables more compliant data collection while respecting user privacy preferences.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Type', 'simple-consent-mode' ),
				'description' => esc_html__( 'This option defines the type of consent requested from users, determining whether they consent to cookies for specific purposes (e.g., analytics, marketing, etc.). Typically, the options include:', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Default Consent Behavior', 'simple-consent-mode' ),
				'description' => esc_html__( 'If the user has not yet provided consent or declined, you can define the default behavior. By default, Google tags will work in a limited mode (for example, without tracking conversions or storing data for ad targeting).', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Update Mechanism', 'simple-consent-mode' ),
				'description' => esc_html__( 'This feature allows websites to update the user\'s consent status if they change their preferences after the initial consent. It ensures that Google services (such as Analytics and Ads) react accordingly and adjust their behavior based on the new consent status.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Mode Events', 'simple-consent-mode' ),
				'description' => esc_html__( 'Consent Mode events provide a way to trigger certain actions when consent preferences are updated. For instance, if a user consents to analytics storage, the website can trigger a specific event to begin tracking user interactions.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Data Retention Options', 'simple-consent-mode' ),
				'description' => esc_html__( 'With Consent Mode, you can set up specific data retention policies to define how long user data should be stored based on their consent. For example, if users withdraw consent, the data collected can be deleted or anonymized.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Tracking Blocking (No Consent)', 'simple-consent-mode' ),
				'description' => esc_html__( 'In cases where the user has not given consent for cookies or data tracking, this option ensures that all data collection and tracking mechanisms are blocked, fully respecting the user\'s privacy preferences.', 'simple-consent-mode' ),
				'since'       => '1.0.0',
			),
		),
		'metaboxes'       => array(
			'assistance' => array(
				'title'    => esc_html__( 'We are waiting for your message', 'simple-consent-mode' ),
				'callback' => 'iworks_simple_consent_modes_options_need_assistance',
				'context'  => 'side',
				'priority' => 'default',
				'since'    => '1.0.0',
			),
			'love'       => array(
				'title'    => esc_html__( 'I love what I do!', 'simple-consent-mode' ),
				'callback' => 'iworks_simple_consent_mode_options_loved_this_plugin',
				'context'  => 'side',
				'priority' => 'low',
				'since'    => '1.0.0',
			),
		),
		'pages'           => array(),
	);
	return $options;
}

function iworks_simple_consent_mode_options_loved_this_plugin( $iworks_simple_consent_mode ) {
	$content = apply_filters( 'iworks_rate_love', '', 'simple-consent-mode' );
	if ( ! empty( $content ) ) {
		echo wp_kses_post( $content );
		return;
	}
	?>
<p><?php esc_html_e( 'Below are some links to help spread this plugin to other users', 'simple-consent-mode' ); ?></p>
<ul>
	<li><a href="https://wordpress.org/support/plugin/simple-consent-mode/reviews/#new-post"><?php esc_html_e( 'Give it a five stars on WordPress.org', 'simple-consent-mode' ); ?></a></li>
	<li><a href="<?php echo esc_attr_x( 'https://wordpress.org/plugins/simple-consent-mode/', 'plugin home page on WordPress.org', 'simple-consent-mode' ); ?>"><?php esc_html_e( 'Link to it so others can easily find it', 'simple-consent-mode' ); ?></a></li>
</ul>
	<?php
}

function iworks_simple_consent_modes_options_need_assistance( $iworks_simple_consent_modes ) {
	$content = apply_filters( 'iworks_rate_assistance', '', 'simple-consent-mode' );
	if ( ! empty( $content ) ) {
		echo wp_kses_post( $content );
		return;
	}
	?>
<p><?php esc_html_e( 'We are waiting for your message', 'simple-consent-mode' ); ?></p>
<ul>
	<li><a href="<?php echo esc_attr_x( 'https://wordpress.org/support/plugin/simple-consent-mode/', 'link to support forum on WordPress.org', 'simple-consent-mode' ); ?>"><?php esc_html_e( 'WordPress Help Forum', 'simple-consent-mode' ); ?></a></li>
</ul>
	<?php
}
