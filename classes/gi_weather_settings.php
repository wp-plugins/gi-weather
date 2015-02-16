<?php
if (!class_exists('gi_weather_settings_section')):
    class gi_weather_settings_section {
		private $BP = false;
	
        public function __construct() {
			add_action( 'plugins_loaded', array($this, 'giw_check_buddypress') );
			
            add_action( 'admin_menu', array($this, 'giw_admin_settings') );
            add_action( 'admin_init', array($this, 'giw_register_settings') );
        }

        #********************************
        # BuddyPress Locations
        #********************************
        /**
         * This is the display function for your section's description
         */
        function giw_setting_callback_section() {
            ?>
            <h3>Genetal Settings</h3>
            <form action="<?php echo admin_url('options-general.php'); ?>?page=gi_weather_settings" method="post">
                <?php settings_fields( 'GeoLocation_g' ); ?>
                <table class="form-table">
                    <?php self::giw_field_callback(); ?>
                </table>
                <p class="submit">
                    <input type="submit" name="giw_submit" class="button-primary" value="Save Settings">
                </p>
            </form>



        <?php

        }
        /**
         * Your setting main function
         */

        function giw_admin_settings() {
            add_options_page( 'GI Weather Settings', 'GI Weather Settings', 'manage_options', 'gi_weather_settings', array($this,'giw_setting_callback_section'));

        }

        function giw_register_settings() {
            if(isset($_POST['giw_submit'])){
                $settings = (isset($_POST['giw_settings']))? $_POST['giw_settings'] : '';


                if(get_option('giw_settings')) update_option('giw_settings',$settings);
                else add_option('giw_settings', $settings);
            }
        }

        /**
         * This is the display function for your field
         */

        function giw_field_callback() {
            $opt = get_option( 'giw_settings' );
			wp_register_script( 'giw_js', plugins_url('gi-weather').'/js/select.js' , array( 'jquery' ) );
			wp_enqueue_script( 'giw_js' );

			wp_register_style( 'giw_css', plugins_url('gi-weather').'/css/select.css');
			wp_enqueue_style( 'giw_css' );

            include(dirname(dirname(__FILE__)).'/templates/settings.php');
        }
		
		function giw_check_buddypress(){
			if(class_exists('BuddyPress')):
				$this->BP = true;
			endif;
		}


    }

endif;