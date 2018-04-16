<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

new SabianThemeSettings();

class SabianThemeSettings {

    /**
     * The main theme section key
     */
    const CUSTOMIZER_HEADER_SECTION_KEY = "sabian_theme_header_options";

    /**
     * The main theme section key
     */
    const CUSTOMIZER_STYLE_SECTION_KEY = "sabian_theme_colors_options";
	
	 /**
     * The main theme section key
     */
    const CUSTOMIZER_SOCIAL_MEDIA_SECTION_KEY = "sabian_theme_social_media_options";
	
	/**
     * The main theme section key
     */
    const CUSTOMIZER_GENERAL_SECTION_KEY = "sabian_theme_general_options";

    /**
     * The header type option key
     */
    const HEADER_TYPE_OPTION_KEY = "_sabian_header_type";

    /**
     * The header type option key
     */
    const HEADER_POSITION_OPTION_KEY = "_sabian_header_position";

    /**
     * The color option key
     */
    const THEME_COLOR_OPTION_KEY = "_sabian_theme_color";

    /**
     * The second theme color option key
     */
    const THEME_SECONDARY_COLOR_OPTION_KEY = "_sabian_secondary_theme_color";

    /**
     * The header color
     */
    const HEADER_COLOR_OPTION_KEY = "_sabian_header_color";

    /**
     * The header color
     */
    const HEADER_TOP_COLOR_OPTION_KEY = "_sabian_header_top_color";

    /**
     * The header top text color
     */
    const HEADER_TEXT_COLOR_OPTION_KEY = "_sabian_header_text_color";

    /**
     * The header top text color
     */
    const HEADER_TOP_TEXT_COLOR_OPTION_KEY = "_sabian_header_top_text_color";

    /**
     * The header hover color
     */
    const HEADER_HOVER_COLOR_OPTION_KEY = "_sabian_hover_header_color";

    /**
     * The header hover text color
     */
    const HEADER_HOVER_TEXT_COLOR_OPTION_KEY = "_sabian_hover_header_text_color";
    
    /**
     * The social media key
     */
    const HEADER_TOP_SOCIAL_MEDIA_KEY = "_sabian_social_media_links";
    
    
    /**
     * The contact key
     */
    const HEADER_TOP_CONTACT_KEY = "_sabian_top_header_contact_key";
    
    /**
     * The email key
     */
    const HEADER_TOP_EMAIL_KEY = "_sabian_top_header_email_key";
	
	/**
     * The location key
     */
    const HEADER_TOP_LOCATION_KEY = "_sabian_top_header_location_key";
    
    /**
     * The display option key
     */
    const HEADER_TOP_DISPLAY_OPTION_KEY="_sabian_top_display_option_key";
	
	/**
	* The logo option key
	*/
	const HEADER_LOGO_KEY="_sabian_image_logo";
    
    /**
     * The transparent header type constant
     */
    const HEADER_TYPE_TRANSPARENT = "transparent";

    /**
     * The transparent header type constant
     */
    const HEADER_TYPE_LIGHT = "light";

    /**
     * The normal header type constant
     */
    const HEADER_TYPE_NORMAL = "standard";
	
	/**
	* The middle bar header type constant
	*/
	const HEADER_TYPE_MIDDLE_BAR="middle-bar";
	
	
	/**
     * Whether to display the page loader
     */
    const DISPLAY_PAGE_LOADER_OPTION_KEY = "_sabian_display_page_loader";
	
	/**
     * The page loader type
     */
    const PAGE_LOADER_TYPE_OPTION_KEY = "_sabian_page_loader_type";
	
	/**
     * The page loader image
     */
    const PAGE_LOADER_IMAGE_KEY = "_sabian_page_loader_image";
	
	/**
     * The page loader image
     */
    const PAGE_LOADER_BG_COLOR_KEY = "_sabian_page_bg_color";
	
	

    /**
     * The default theme settings. They include :
     * $header_type,
     * $theme_color,
     * $theme_secondary_color,
     * $theme_alt_color,
     * $header_color,
     * $header_text_color,
     * $header_hover_color,
     * $header_hover_text_color,
     * $header_top_color,
     * $header_top_text_color
     * $header_position,
     * $header_top_social_media,
     * $header_top_email,
     * $header_top_phone,
     * $header_top_display
	 * $header_logo
	 * $display_page_loader
	 * $page_loader_type
     */
    public static $defaults = array(
        "header_type" => self::HEADER_TYPE_NORMAL,
        "theme_color" => "#59B2E5",
        "theme_secondary_color" => "#208ccb",
        "theme_alt_color" => "rgba(89,178,229)",
        "header_color" => "#59B2E5",
        "header_text_color" => "#fff",
        "header_hover_color" => "#59B2E5",
        "header_hover_text_color" => "#fff",
        "header_top_color" => "#208ccb",
        "header_top_text_color" => "#fff",
        "header_position" => "left",
        "header_top_email" => "",
        "header_top_phone" => "",
		"header_top_location" => "",
        "header_top_social_media" => "",
        "header_top_display"=>1,
		"header_logo"=>"",
		"display_page_loader"=>true,
		"page_loader_type"=>"sabian_wave",
		"page_loader_image"=>"",
		"page_loader_bg"=>""
    );
	
	public static $header_types = array(
            self::HEADER_TYPE_NORMAL => "Normal",
            self::HEADER_TYPE_TRANSPARENT => 'Transparent',
            self::HEADER_TYPE_LIGHT => "Light",
			self::HEADER_TYPE_MIDDLE_BAR=>"With Middle Bar"
    );

    /**
     * The wp customizer manager instance
     * @var WP_Customize_Manager 
     */
    private $wp_customizer;

    /**
     * Initializes the settings
     */
    public function __construct() {

        $this->init_customizer();

        add_action('sabian_deactivated', function() {
            remove_theme_mod(self::HEADER_TYPE_OPTION_KEY);
        });
    }

    /**
     * Initializes the theme settings customizer
     */
    private function init_customizer() {

        add_action('customize_register', array($this, '_customizer_init'));
    }

    /**
     * The customizer settings action
     * @param WP_Customize_Manager $wp_customize
     */
    public function _customizer_init($wp_customize) {

        /* Define a customizer environment */
        if (!defined("SABIAN_CUSTOMIZER_INIT")) {

            /**
             * Determines whether the customizer environment is active
             */
            define("SABIAN_CUSTOMIZER_INIT", true);
        }

        $this->wp_customizer = $wp_customize;

        $this->init_setting_options();

        $this->init_sections();
		
		$this->init_general_controls();

        $this->init_header_controls();

        $this->init_theme_color_controls();
		
		$this->init_social_media_controls();
    }

    /**
     * Initialize the sections
     */
    private function init_sections() {

        $wp_customize = $this->wp_customizer;
		
		/* Register customizer settings */
        $wp_customize->add_section(self::CUSTOMIZER_GENERAL_SECTION_KEY, array(
            'title' => __('Sabian General', 'sabian_theme'), //Visible title of section
            'priority' => 35, //Determines what order this appears in 
            'description' => __('Allows you to customize the genral theme options', 'sabian_theme'), //Descriptive tooltip
                )
        );

        /* Register customizer settings */
        $wp_customize->add_section(self::CUSTOMIZER_HEADER_SECTION_KEY, array(
            'title' => __('Sabian Header', 'sabian_theme'), //Visible title of section
            'priority' => 35, //Determines what order this appears in 
            'description' => __('Allows you to customize the header settings for Sabian Corporate.', 'sabian_theme'), //Descriptive tooltip
                )
        );


        /* Register customizer settings */
        $wp_customize->add_section(self::CUSTOMIZER_STYLE_SECTION_KEY, array(
            'title' => __('Sabian Styling', 'sabian_theme'), //Visible title of section
            'priority' => 35, //Determines what order this appears in 
            'description' => __('Allows you to customize color settings for Sabian Corporate.', 'sabian_theme'), //Descriptive tooltip
                )
        );
		
		
		/* Register customizer settings */
        $wp_customize->add_section(self::CUSTOMIZER_SOCIAL_MEDIA_SECTION_KEY, array(
            'title' => __('Sabian Social Media Links', 'sabian_theme'), //Visible title of section
            'priority' => 35, //Determines what order this appears in 
            'description' => __('Allows you to customize your social media pages.', 'sabian_theme'), //Descriptive tooltip
                )
        );
    }

    /**
     * Initialize the settings options
     */
    private function init_setting_options() {

        $wp_customize = $this->wp_customizer;

        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TYPE_OPTION_KEY, array(
            'default' => self::$defaults["header_type"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );


        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_POSITION_OPTION_KEY, array(
            'default' => self::$defaults["header_position"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );

        /* Register wp setting */
        $wp_customize->add_setting(self::THEME_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["theme_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );

        /* Register wp setting */
        $wp_customize->add_setting(self::THEME_SECONDARY_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["theme_secondary_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );

        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );

        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_top_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );


        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TEXT_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_text_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );


        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_TEXT_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_top_text_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );


        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_HOVER_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_hover_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );


        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_HOVER_TEXT_COLOR_OPTION_KEY, array(
            'default' => self::$defaults["header_hover_text_color"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
        
        /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_CONTACT_KEY, array(
            'default' => self::$defaults["header_top_phone"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
        
         /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_EMAIL_KEY, array(
            'default' => self::$defaults["header_top_email"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_LOCATION_KEY, array(
            'default' => self::$defaults["header_top_location"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
        
        
         /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_DISPLAY_OPTION_KEY, array(
            'default' => self::$defaults["header_top_display"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		 /* Register wp setting */
        $wp_customize->add_setting(self::HEADER_LOGO_KEY, array(
            'default' => self::$defaults["header_logo"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::HEADER_TOP_SOCIAL_MEDIA_KEY, array(
            'default' => self::$defaults["header_top_social_media"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
           	'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::DISPLAY_PAGE_LOADER_OPTION_KEY, array(
            'default' => self::$defaults["display_page_header"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
           	'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => function($checked) { return ( ( isset( $checked ) && true == $checked ) ? true : false ); },
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::PAGE_LOADER_TYPE_OPTION_KEY, array(
            'default' => self::$defaults["page_loader_type"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
           	'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::PAGE_LOADER_IMAGE_KEY, array(
            'default' => self::$defaults["page_loader_image"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
		
		/* Register wp setting */
        $wp_customize->add_setting(self::PAGE_LOADER_BG_COLOR_KEY, array(
            'default' => self::$defaults["page_loader_bg"], //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
                )
        );
    }
	
	private function init_general_controls(){
		
		$wp_customize=$this->wp_customizer;
		
		/*Add Image Selector*/
		$wp_customize->add_control(
		new WP_Customize_Image_Control(
           $wp_customize,
           self::HEADER_LOGO_KEY,
           array(
               'label'      => __( 'Upload a logo', '' ),
               'section'    => self::CUSTOMIZER_GENERAL_SECTION_KEY,
               'settings'   => self::HEADER_LOGO_KEY,
           )
       )
	   );
	   
	   $wp_customize->add_control( 'sabian_display_page_loader_control', array(
		'type' => 'checkbox',
		'section' => self::CUSTOMIZER_GENERAL_SECTION_KEY, // Add a default or your own section
		'label' => __( 'Display Page Loader' ),
		'description' => __( 'Whether to display the page header' ),
		'settings' => self::DISPLAY_PAGE_LOADER_OPTION_KEY,
		) );
		
		
		$loader_choices=array();
		
		$choices=self::getPageLoaders();
		
		$choices=array_keys($choices);
		
		foreach($choices as $choice){
			$loader_choices[$choice]=ucfirst(preg_replace("/^[A-Za-z0-9]+_/i","",$choice));	
		}
		
		$wp_customize->add_control('sabian_page_loader_control', array(
            'type' => 'select',
            'section' => self::CUSTOMIZER_GENERAL_SECTION_KEY,
            'settings' => self::PAGE_LOADER_TYPE_OPTION_KEY,
            'label' => __('The page loader'),
             'choices'=>$loader_choices
        ));
		
		/*Add Image Selector*/
		$wp_customize->add_control(
		new WP_Customize_Image_Control(
           $wp_customize,
           self::PAGE_LOADER_IMAGE_KEY,
           array(
               'label'      => __( 'Upload page loader image', '' ),
               'section'    => self::CUSTOMIZER_GENERAL_SECTION_KEY,
               'settings'   => self::PAGE_LOADER_IMAGE_KEY,
			   'description' => __('The image to show on top of the loader animation.', 'sabian_theme'),
           )
       )
	   );
	   
	   /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::PAGE_LOADER_BG_COLOR_KEY, array(
            'label' => __('Page loader background', 'sabian_theme'),
            'section' => self::CUSTOMIZER_GENERAL_SECTION_KEY,
            'settings' => self::PAGE_LOADER_BG_COLOR_KEY,
                ))
        );
						
		
	}

    private function init_theme_color_controls() {

        $wp_customize = $this->wp_customizer;

        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::THEME_COLOR_OPTION_KEY, array(
            'label' => __('Theme General Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::THEME_COLOR_OPTION_KEY,
                ))
        );

        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::THEME_SECONDARY_COLOR_OPTION_KEY, array(
            'label' => __('Theme Secondary Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::THEME_SECONDARY_COLOR_OPTION_KEY,
                ))
        );



        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::HEADER_COLOR_OPTION_KEY, array(
            'label' => __('Header Menu Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::HEADER_COLOR_OPTION_KEY,
                ))
        );

        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::HEADER_TEXT_COLOR_OPTION_KEY, array(
            'label' => __('Header Menu Text Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::HEADER_TEXT_COLOR_OPTION_KEY,
                ))
        );


        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::HEADER_HOVER_COLOR_OPTION_KEY, array(
            'label' => __('Header Menu Hover Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::HEADER_HOVER_COLOR_OPTION_KEY,
                ))
        );


        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::HEADER_HOVER_TEXT_COLOR_OPTION_KEY, array(
            'label' => __('Header Menu Hover Text Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::HEADER_HOVER_TEXT_COLOR_OPTION_KEY,
                ))
        );


        /* Add theme color control */
        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                $wp_customize, self::HEADER_TOP_COLOR_OPTION_KEY, array(
            'label' => __('Header Menu Top Color', 'sabian_theme'),
            'section' => self::CUSTOMIZER_STYLE_SECTION_KEY,
            'settings' => self::HEADER_TOP_COLOR_OPTION_KEY,
                ))
        );


        
    }

    private function init_header_controls() {

        $wp_customize = $this->wp_customizer;

        /* Add header control */
        $header_choices = apply_filters("sabian_settings_header_types", self::$header_types);

        /* Add header control */
        $header_positions = apply_filters("sabian_settings_header_positions", array(
            "right" => "Right",
            "left" => 'Left',
        ));
		
		

        $wp_customize->add_control('sabian_header_type_control', array(
            'type' => 'select',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_TYPE_OPTION_KEY,
            'label' => __('The Header Type'),
            'description' => __('Select the theme header type.', 'sabian_theme'),
            'choices' => $header_choices,
        ));
        
        
        $wp_customize->add_control('sabian_header_position_control', array(
            'type' => 'select',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_POSITION_OPTION_KEY,
            'label' => __('The Header Menu Position'),
            'description' => __('Select the theme header position.', 'sabian_theme'),
            'choices' => $header_positions,
        ));
        
        
         $wp_customize->add_control('sabian_header_display_control', array(
            'type' => 'select',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_TOP_DISPLAY_OPTION_KEY,
            'label' => __('Whether to display the top header'),
             'choices'=>array(1=>"Yes",0=>"No")
        ));
        
        $wp_customize->add_control('sabian_header_email_control', array(
            'type' => 'text',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_TOP_EMAIL_KEY,
            'label' => __('The Top Header Email Information'),
        ));
        
        $wp_customize->add_control('sabian_header_phone_control', array(
            'type' => 'text',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_TOP_CONTACT_KEY,
            'label' => __('The Top Header Phone Information'),
        ));
		
		$wp_customize->add_control('sabian_header_location_control', array(
            'type' => 'text',
            'section' => self::CUSTOMIZER_HEADER_SECTION_KEY,
            'settings' => self::HEADER_TOP_LOCATION_KEY,
            'label' => __('The Top Header Location Information'),
        ));
		
		
		
	   
	   
    }
	
	private function init_social_media_controls(){
		
		$wp_customize=$this->wp_customizer;
		
		/*Add social media key*/
	   $wp_customize->add_control(
		new SabianSocialMediaEditControl(
		$wp_customize,
		self::HEADER_TOP_SOCIAL_MEDIA_KEY,
		array(
		'label' => __( 'Edit social media links', 'sabian' ),
		'section' => self::CUSTOMIZER_SOCIAL_MEDIA_SECTION_KEY,
		'settings' => self::HEADER_TOP_SOCIAL_MEDIA_KEY,
		'social_links' => self::getSocialMediaLinks()
        )));	
	}

    /**
     * Gets the default header type to be used
     * @return string
     */
    public static function getHeaderType() {

        $header = get_theme_mod(self::HEADER_TYPE_OPTION_KEY, self::HEADER_TYPE_NORMAL);

        return $header;
    }
	
	/**
     * Gets the default logo
     * @return string
     */
    public static function getLogo() {
		
		return get_theme_mod(self::HEADER_LOGO_KEY,self::$defaults["header-logo"]);
    }
    /**
     * Gets the default header position to be used
     * @return string
     */
    public static function getHeaderPosition() {

        $header = get_theme_mod(self::HEADER_POSITION_OPTION_KEY, self::$defaults["header_position"]);

        return $header;
    }

    /**
     * Gets the theme color to be used
     * @return string
     */
    public static function getThemeColor() {

        $header = get_theme_mod(self::THEME_COLOR_OPTION_KEY, self::$defaults["theme_color"]);

        return $header;
    }

    /**
     * Gets the theme secondary color
     * @return string
     */
    public static function getThemeSecondaryColor() {

        $header = get_theme_mod(self::THEME_SECONDARY_COLOR_OPTION_KEY, self::$defaults["theme_secondary_color"]);

        return $header;
    }
	
	 /**
     * Gets the social media links
     * @return array
	 * @type string $type e.g facebook
	 * @link string $link the url
     */
    public static function getSocialMediaLinks() {

        $setting = self::getSetting(self::HEADER_TOP_SOCIAL_MEDIA_KEY,null);
		
		$def_links=self::getDefaultSocialMediaLinks();
		
		if(!$setting){
			return $def_links;
		}
		
		$social=json_decode($setting,true);
		
		$social=array_merge($def_links,$social);

        return $social;
    }
	
	/**
     * Gets the default social media links
     * @return array
	 * @type string $type e.g facebook
	 * @link string $link the url
     */
	private static function getDefaultSocialMediaLinks(){
		
		$def= array(
		"facebook"=>array("type"=>"facebook","link"=>""),
		"twitter"=>array("type"=>"twitter","link"=>""),
		"instagram"=>array("type"=>"instagram","link"=>""),
		"linkedin"=>array("type"=>"linkedin","link"=>""),
		"google-plus"=>array("type"=>"google-plus","link"=>""),
		"youtube"=>array("type"=>"youtube","link"=>""),
		);
		
		$def=apply_filters("sabian_default_social_media_links",$def);
		
		//print_r(array_keys($def));
		
		return $def;
	}
	
	/**
     * Gets the default page loader types
     * @return array
     */
	public static function getPageLoaders(){
		
		$loaders=array(
		"sabian_wave"=>'<div class="sabian_wave">
        <div class="sw-rect sw-rect1"></div>
        <div class="sw-rect sw-rect2"></div>
        <div class="sw-rect sw-rect3"></div>
        <div class="sw-rect sw-rect4"></div>
        <div class="sw-rect sw-rect5"></div>
      </div>',
	  
	  "sabian_snake"=>'<div class="sabian-snake">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>'
		);
		
		return apply_filters("sabian_page_loader_types",$loaders);		
	}
	
	/**
     * Gets the default page loader
     * @return string The html loader
     */
	public static function getPageLoader($type=null){
		
		$type=(!$type)?self::getSetting(self::PAGE_LOADER_TYPE_OPTION_KEY,self::$defaults["page_loader_type"]):$type;
		
		$loaders=self::getPageLoaders();
		
		return $loaders[$type]; 		
	}
	
	/**
     * Whether to display the page loader
     */
	public static function canDisplayPageLoader(){
		
		$display=self::getSetting(self::DISPLAY_PAGE_LOADER_OPTION_KEY,self::$defaults["display_page_loader"]);
		
		return $display;		
	}
	
	/**
     * Gets the default logo
     * @return string
     */
    public static function getPageLoaderImage() {
		
		return get_theme_mod(self::PAGE_LOADER_IMAGE_KEY,self::$defaults["page_loader_image"]);
    }
	
	/**
     * Gets the page loader bg color
     * @return string
     */
    public static function getPageLoaderBackground() {

        $cl = get_theme_mod(self::PAGE_LOADER_BG_COLOR_KEY, self::$defaults["page_loader_bg"]);

        return $cl;
    }


    /**
     * Gets a setting
     * @param string $key
     * @param object $default
     * @return string
     */
    public static function getSetting($key, $default = null) {

        $setting = get_theme_mod($key, $default);

        return $setting;
    }

}

if (class_exists("WP_Customize_Control")) {

    /**
     * The header customize control
     */
    class SabianSocialMediaEditControl extends WP_Customize_Control {
		
		
		public $type="sabian-social-media-control";

        /**
         * The social media key
         * @var array 
         */
        public $social_media_links=array();
		
			/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->social_media_links = $args[ 'social_links' ];
		parent::__construct( $manager, $id, $args );
	}
		
			/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0
	 */
	public function enqueue() {
		wp_enqueue_script('sabian_underscore');
		wp_enqueue_script( 'sabian_theme_settings_script' );
	}
        
        /**
         * Renders the content
         */
        protected function render_content() {
			
			$social_links=$this->social_media_links;
			
			
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            
            
            <?php foreach($social_links as $i=>$link) {
				
				$key=$i;
				
				 ?>
            <label style="margin-bottom:5px; display:block">
                <span class="customize-control-title" style="margin-bottom:0px"><?php echo ucfirst($i); ?> Link</span>
                <input type="text" value="<?php echo $link["link"]; ?>" name="social_media[<?php echo $key; ?>]" class="social_media_setting" data-type="<?php echo $key; ?>" />
            </label>
            <?php } ?>
            
            
            
            <label style="margin-top:10px; display:none">
            <button type="button" class="button button-primary button-social-media-save" class="" aria-label="Save Details">Save Details</button>
            </label>
			<?php
        }
		

    }
	
	

}
