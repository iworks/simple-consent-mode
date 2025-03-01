<?php
defined( 'ABSPATH' ) || exit;

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
			/**
			 * Consent
			 */
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'Consent', 'simple-consent-mode' ),
				'since' => '1.2.0',
			),
			array(
				'name'              => 'm_main_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Consent', 'simple-consent-mode' ),
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'm_main_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'wp_kses_post',
				'classes'           => array( 'large-text' ),
				'default'           => wpautop(
					implode(
						PHP_EOL . PHP_EOL,
						array(
							esc_html__( 'We use cookies to personalize content and ads, to provide social media features and to analyze traffic to our site.', 'simple-consent-mode' ),
							esc_html__( 'We share information about your use of our site with social media, advertising and analytics partners. These partners may combine this information with other data they have provided to you or obtained through your use of their services.', 'simple-consent-mode' ),
							sprintf(
								/* translators: %s link to explains */
								esc_html__( 'Information on how Google processes data can be found %s.', 'simple-consent-mode' ),
								sprintf(
									'<a href="#" target="_blank">%s</a>',
									esc_html__( 'here', 'simple-consent-mode' )
								)
							),
						)
					)
				),
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 10,
				'since'             => '1.0.0',
			),
			/**
			 * Details
			 */
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'Details', 'simple-consent-mode' ),
				'since' => '1.2.0',
			),
			array(
				'name'              => 'm_details_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Details', 'simple-consent-mode' ),
				'since'             => '1.2.0',
			),
			/**
			 * Consent
			 */
			array(
				'type'  => 'subheading',
				'label' => esc_html__( 'About Cookies', 'simple-consent-mode' ),
				'since' => '1.2.0',
			),
			array(
				'name'              => 'm_about_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'About Cookies', 'simple-consent-mode' ),
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'm_about_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'wp_kses_post',
				'classes'           => array( 'large-text' ),
				'default'           => wpautop(
					implode(
						PHP_EOL . PHP_EOL,
						array(
							esc_html__( 'Cookies are small data files stored on your device by websites to remember your preferences, login details, or actions. There are different types, including session cookies (temporary) and persistent cookies (long-term). They help personalize your browsing experience but can also track your online behavior.', 'simple-consent-mode' ),
							esc_html__( 'Consent refers to the permission websites must obtain from users before using cookies that collect personal data. Laws like the GDPR require websites to ask for explicit consent through cookie banners, allowing users to accept or reject cookies and control their privacy. You can also withdraw consent at any time, typically through the website’s privacy settings, which lets you manage or delete stored cookies whenever you choose.', 'simple-consent-mode' ),
							esc_html__( 'For more details on how a website uses cookies and collects data, you can refer to the website’s privacy policy. This document outlines the types of cookies used, data collected, and how your information is stored or shared. It also explains how you can manage your preferences.', 'simple-consent-mode' ),
						)
					)
				),
				'description'       => esc_html__( 'You can use HTML tags in this field.', 'simple-consent-mode' ),
				'rows'              => 10,
				'since'             => '1.2.0',
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
				'description'       => esc_html__( 'On the first tab', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'OK', 'simple-consent-mode' ),
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'btn_allow_all',
				'type'              => 'text',
				'th'                => esc_html__( 'Allow All', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Allow All', 'simple-consent-mode' ),
				'since'             => '1.2.0',
				'description'       => esc_html__( 'Not on the first tab', 'simple-consent-mode' ),
			),
			array(
				'name'              => 'btn_selected',
				'type'              => 'text',
				'th'                => esc_html__( 'Allow Selection', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'default'           => __( 'Allow Selection', 'simple-consent-mode' ),
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'btn_choose',
				'type'              => 'text',
				'th'                => esc_html__( 'Choose Consents', 'simple-consent-mode' ),
				'default'           => __( 'Personalize', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
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
			/**
			 * Design
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Design', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'type'  => 'subheading',
				'label' => __( 'Dialog', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'd_width',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Width', 'simple-consent-mode' ),
				'label'             => __( 'px', 'simple-consent-mode' ),
				'default'           => 900,
				'sanitize_callback' => 'absint',
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'd_border_radius',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Radius', 'simple-consent-mode' ),
				'label'             => __( 'px', 'simple-consent-mode' ),
				'default'           => 5,
				'sanitize_callback' => 'absint',
				'since'             => '1.1.2',
			),
			array(
				'name'              => 'c_bg',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Background', 'simple-consent-mode' ),
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			array(
				'name'              => 'c_backdrop',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Backdrop', 'simple-consent-mode' ),
				'default'           => 'rgba(0,0,0,.7)',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
				'data'              => array(
					'enableAlpha' => true,
				),
			),
			array(
				'name'              => 'c_primary',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Primary', 'simple-consent-mode' ),
				'default'           => '#000',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.0.0',
			),
			/**
			 * Logo
			 */
			array(
				'type'  => 'subheading',
				'label' => __( 'Logo', 'simple-consent-mode' ),
				'since' => '1.2.0',
			),
			array(
				'name'              => 'd_logo_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show', 'simple-consent-mode' ),
				'default'           => 1,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
			),
			array(
				'name'              => 'd_logo',
				'type'              => 'image',
				'th'                => __( 'Image', 'simple-consent-mode' ),
				'sanitize_callback' => 'absint',
				'since'             => '1.2.0',
				'max-height'        => 100,
			),
			array(
				'name'              => 'd_logo_max_height',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Max Height', 'simple-consent-mode' ),
				'label'             => __( 'px', 'simple-consent-mode' ),
				'default'           => 48,
				'sanitize_callback' => 'absint',
				'since'             => '1.2.0',
			),
			/**
			 * Button Primary
			 */
			array(
				'type'  => 'subheading',
				'label' => __( 'Button Primary', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'c_btn_pri_text',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Text', 'simple-consent-mode' ),
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'c_btn_pri_bg',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Background', 'simple-consent-mode' ),
				'default'           => '#1f883d',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.2.0',
			),
			/**
			 * Button
			 */
			array(
				'type'  => 'subheading',
				'label' => __( 'Button', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			array(
				'name'              => 'd_btn_border_radius',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Radius', 'simple-consent-mode' ),
				'label'             => __( 'px', 'simple-consent-mode' ),
				'default'           => 5,
				'sanitize_callback' => 'absint',
				'since'             => '1.1.2',
			),
			array(
				'name'              => 'c_btn_text',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Text', 'simple-consent-mode' ),
				'default'           => '#888',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.2.0',
			),
			array(
				'name'              => 'c_btn_bg',
				'type'              => 'wpColorPicker',
				'class'             => 'short-text',
				'th'                => __( 'Background', 'simple-consent-mode' ),
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				'since'             => '1.2.0',
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
				'label' => esc_html__( 'Consents', 'simple-consent-mode' ),
				'since' => '1.0.0',
			),
			/**
			 * Necessary
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Functional', 'simple-consent-mode' ),
				'description' => esc_html__( 'Manages the storage of cookies for essential functions like login.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'functional_storage' ),
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
				'name'              => 'fust_on',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Always on', 'simple-consent-mode' ),
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
				'codename'          => 'functional_storage',
			),
			array(
				'name'              => 'fust_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Necessary cookies help make a website usable by enabling basic functions such as page navigation and access to secure areas of the website. The website cannot function properly without these cookies.', 'simple-consent-mode' ),
			),
			/**
			 * analytics_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Analytics Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Enables storage (such as cookies) related to analytics e.g. visit duration.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'analytics_storage' ),
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
				'description' => esc_html__( 'Enables storage (such as cookies) related to advertising.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'ad_storage' ),
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
				'description' => esc_html__( 'Sets consent for personalized advertising.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'ad_personalization' ),
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
				'description' => esc_html__( 'Sets consent for sending user data related to advertising to Google. The ad_user_data consent type is required for measurement use cases, such as enhanced conversions and tag-based conversion tracking.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'ad_user_data' ),
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
			 * personalization_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Personalization Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Enables storage related to personalization e.g. video recommendations', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'personalization_storage' ),
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
				'codename'          => 'personalization_storage',
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
			 * security_storage
			 */
			array(
				'type'        => 'subheading',
				'label'       => esc_html__( 'Security Storage', 'simple-consent-mode' ),
				'description' => esc_html__( 'Enables storage related to security such as authentication functionality, fraud prevention, and other user protection.', 'simple-consent-mode' ) . iworks_simple_consent_modes_options_g_code( 'security_storage' ),
			),
			array(
				'name'              => 'sest_show',
				'type'              => 'checkbox',
				'th'                => esc_html__( 'Show', 'simple-consent-mode' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
			),
			array(
				'name'              => 'sest_title',
				'type'              => 'text',
				'th'                => esc_html__( 'Title', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Security', 'simple-consent-mode' ),
				'codename'          => 'security_storage',
			),
			array(
				'name'              => 'sest_desc',
				'type'              => 'textarea',
				'th'                => esc_html__( 'Description', 'simple-consent-mode' ),
				'sanitize_callback' => 'esc_html',
				'classes'           => array( 'large-text' ),
				'default'           => __( 'Security storage is the practice of safely storing sensitive data using encryption or secure methods to prevent unauthorized access or theft.', 'simple-consent-mode' ),
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
				'description'       => esc_html__( 'Enable or disable consent logging as needed.', 'simple-consent-mode' ),
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.1.0',
			),
			array(
				'name'              => 'log_duration',
				'type'              => 'number',
				'class'             => 'small-text',
				'th'                => __( 'Duration', 'simple-consent-mode' ),
				'label'             => __( 'Months', 'simple-consent-mode' ),
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

function iworks_simple_consent_modes_options_g_code( $gcode ) {
	return sprintf(
		' [%s: %s]',
		esc_html__( 'Google codename', 'simple-consent-mode' ),
		$gcode
	);
}
