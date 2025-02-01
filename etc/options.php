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
		'version'    => '0.0',
		'page_title' => esc_html__( 'Cookie Consent', 'simple-consent-mode' ),
		'menu'       => 'options',
		'use_tabs'   => true,
		'options'    => array(
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Main', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'm_main_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show Description', 'simple-consent-mode' ),
				'default'           => 1,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
			),
			array(
				'name'              => 'm_main_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Consents Modal Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'This website uses cookies to ensure you get the best experience on our website.', 'simple-consent-mode' ),
			),
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'Buttons', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'btn_allow',
				'type'              => 'text',
				'th'                => esc_html__( 'Allow All', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Allow All Consents', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'btn_choose',
				'type'              => 'text',
				'th'                => esc_html__( 'Choose Consents', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Choose Consents', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'btn_deny',
				'type'              => 'text',
				'th'                => esc_html__( 'Deny All Consents', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Deny', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'btn_close',
				'type'              => 'text',
				'th'                => esc_html__( 'Close', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Close', 'simple-consent-mode' ),
			),
			/**
			 * Required Consents
			 */
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Required Consents', 'simple-consent-mode' ),
			),
			/**
			 * analytics_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Analytics Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Controls whether data related to website usage and user behavior can be stored for analytics purposes (e.g., Google Analytics).', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'anst_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Analytic Storage', 'simple-consent-mode' ),
				'codename'          => 'analytics_storage',
			),
			array(
				'name'              => 'anst_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Controls whether data related to website usage and user behavior can be stored for analytics purposes (e.g., Google Analytics).', 'simple-consent-mode' ),
			),
			/**
			 * ad_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Manages whether advertising-related data (like targeting and tracking cookies) can be stored and processed for ad services.', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'adst_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad Storage', 'simple-consent-mode' ),
				'codename'          => 'ad_storage',
			),
			array(
				'name'              => 'adst_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => esc_html__( 'Manages whether advertising-related data (like targeting and tracking cookies) can be stored and processed for ad services.', 'simple-consent-mode' ),
			),
			/**
			 * ad_personalization
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad Personalization', 'simple-consent-mode' ),
				'description' => esc_html__( 'Determines if personalized ads can be shown based on user behavior and preferences, using stored data for targeting.', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'adpe_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad Personalization', 'simple-consent-mode' ),
				'codename'          => 'ad_personalization',
			),
			array(
				'name'              => 'adpe_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Determines if personalized ads can be shown based on user behavior and preferences, using stored data for targeting.', 'simple-consent-mode' ),
			),
			/**
			 * ad_user_data
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Ad User Data', 'simple-consent-mode' ),
				'description' => esc_html__( 'Controls the storage of user-specific data for ad tracking, profiling, and measuring ad effectiveness.', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'auda_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Ad User Data', 'simple-consent-mode' ),
				'codename'          => 'ad_user_data',
			),
			array(
				'name'              => 'auda_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Controls the storage of user-specific data for ad tracking, profiling, and measuring ad effectiveness.', 'simple-consent-mode' ),
			),
			/**
			 * Custom Consents
			 */
			array(
				'type'  => 'heading',
				'label' => esc_html__( 'Custom Consents', 'simple-consent-mode' ),
			),
			/**
			 * functional_storage
			 */
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
			 */
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
			),
			array(
				'name'              => 'cookie_version',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Version', 'simple-consent-mode' ),
				'default'           => 1,
				'sanitize_callback' => 'absint',
			),

			/**
			 * About Consent Mode
			 */
			array(
				'type'        => 'heading',
				'label'       => esc_html__( 'About Consent Mode', 'simple-consent-mode' ),
				'description' => esc_html__( 'Consent Mode is a tool provided by Google that allows websites to adjust the behavior of Google tags (such as Google Analytics, Google Ads, and others) depending on the user\'s consent for data processing. It enables more compliant data collection while respecting user privacy preferences.', 'simple-consent-mode' ),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Type', 'simple-consent-mode' ),
				'description' => esc_html__( 'This option defines the type of consent requested from users, determining whether they consent to cookies for specific purposes (e.g., analytics, marketing, etc.). Typically, the options include:', 'simple-consent-mode' ),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Default Consent Behavior', 'simple-consent-mode' ),
				'description' => esc_html__(
					'If the user has not yet provided consent or declined, you can define the default behavior. By default, Google tags will work in a limited mode (for example, without tracking conversions or storing data for ad targeting).
',
					'simple-consent-mode'
				),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Update Mechanism', 'simple-consent-mode' ),
				'description' => esc_html__( 'This feature allows websites to update the user\'s consent status if they change their preferences after the initial consent. It ensures that Google services (such as Analytics and Ads) react accordingly and adjust their behavior based on the new consent status.', 'simple-consent-mode' ),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Consent Mode Events', 'simple-consent-mode' ),
				'description' => esc_html__(
					'Consent Mode events provide a way to trigger certain actions when consent preferences are updated. For instance, if a user consents to analytics storage, the website can trigger a specific event to begin tracking user interactions.
',
					'simple-consent-mode'
				),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Data Retention Options', 'simple-consent-mode' ),
				'description' => esc_html__( 'With Consent Mode, you can set up specific data retention policies to define how long user data should be stored based on their consent. For example, if users withdraw consent, the data collected can be deleted or anonymized.', 'simple-consent-mode' ),
			),
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Tracking Blocking (No Consent)', 'simple-consent-mode' ),
				'description' => esc_html__( 'In cases where the user has not given consent for cookies or data tracking, this option ensures that all data collection and tracking mechanisms are blocked, fully respecting the user\'s privacy preferences.', 'simple-consent-mode' ),
			),
		),
		'metaboxes'  => array(
			'assistance' => array(
				'title'    => esc_html__( 'We are waiting for your message', 'simple-consent-mode' ),
				'callback' => 'iworks_simple_consent_modes_options_need_assistance',
				'context'  => 'side',
				'priority' => 'default',
			),
			'love'       => array(
				'title'    => esc_html__( 'I love what I do!', 'simple-consent-mode' ),
				'callback' => 'iworks_simple_consent_mode_options_loved_this_plugin',
				'context'  => 'side',
				'priority' => 'low',
			),
		),
		'pages'      => array(),
	);
	return $options;
}

function iworks_simple_consent_mode_options_loved_this_plugin( $iworks_simple_consent_mode ) {
	$content = apply_filters( 'iworks_rate_love', '', 'simple-consent-mode' );
	if ( ! empty( $content ) ) {
		echo $content;
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
		echo $content;
		return;
	}

	?>
<p><?php esc_html_e( 'We are waiting for your message', 'simple-consent-mode' ); ?></p>
<ul>
	<li><a href="<?php echo esc_attr_x( 'https://wordpress.org/support/plugin/simple-consent-mode/', 'link to support forum on WordPress.org', 'simple-consent-mode' ); ?>"><?php esc_html_e( 'WordPress Help Forum', 'simple-consent-mode' ); ?></a></li>
</ul>
	<?php
}
