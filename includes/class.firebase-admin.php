<?php
/**
 * Add Firebase setting menu
 * @var [type]
 */

class Firebase_Admin{
  private static $initiated = false;
  private static $options;

  public static function init(){
    if( ! self::$initiated ) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;
    self::$options = get_option("firebase_credentials");

    add_action( "admin_menu", array( "Firebase_Admin", "admin_menu" ) );
    add_action( "admin_init", array ( "Firebase_Admin", "register_settings" ) );
  }

  public static function admin_menu() {
    self::load_menu();
  }

  public static function load_menu() {

    $page_title = 'Firebase for Wordpress';
    $menu_title = 'Firebase';
    $capability = 'manage_options';
    $menu_slug = 'firebase-setting';
    $function = 'display_page';
    $icon_url = '';
    $position = '';

    add_options_page( __( $page_title, "firebase" ), __( $menu_title, "firebase" ), $capability, $menu_slug, array( "Firebase_Admin", $function ), $icon_url, $position );
  }

  public static function register_settings(){
    register_setting(
        "firebase_option_group",
        "firebase_credentials",
        array( "Firebase_Admin", "sanitize")
      );

    add_settings_section(
            'setting_section_id', // ID
            'Enter your firebase credentials below:', // Title
            array( "Firebase_Admin", 'print_section_info' ), // Callback
            'firebase-setting' // Page
        );

    add_settings_field(
            'api_key', // ID
            'API Key', // Title
            array( "Firebase_Admin", 'api_key_callback' ), // Callback
            'firebase-setting', // Page
            'setting_section_id' // Section
        );

    add_settings_field(
            'auth_domain', // ID
            'Auth Domain', // Title
            array( "Firebase_Admin", 'auth_domain_callback' ), // Callback
            'firebase-setting', // Page
            'setting_section_id' // Section
        );

    add_settings_field(
            'database_url', // ID
            'Database URL', // Title
            array( "Firebase_Admin", 'database_url_callback' ), // Callback
            'firebase-setting', // Page
            'setting_section_id' // Section
        );

    add_settings_field(
            'project_id', // ID
            'Project Id', // Title
            array( "Firebase_Admin", 'project_id_callback' ), // Callback
            'firebase-setting', // Page
            'setting_section_id' // Section
        );
  }

  /**
 * Sanitize each setting field as needed
 *
 * @param array $input Contains all settings fields as array keys
 */
  public static function sanitize( $input )
  {
      $new_input = array();

      if( isset( $input['api_key'] ) )
          $new_input['api_key'] = sanitize_text_field( $input['api_key'] );

      if( isset( $input['auth_domain'] ) )
          $new_input['auth_domain'] = sanitize_text_field( $input['auth_domain'] );

      if( isset( $input['database_url'] ) )
          $new_input['database_url'] = sanitize_text_field( $input['database_url'] );

      if( isset( $input['project_id'] ) )
          $new_input['project_id'] = sanitize_text_field( $input['project_id'] );

      return $new_input;
  }

  /**
   * Print the Section text
   */
  public static function print_section_info()
  {
      print "Firebase info can be found in Project <strong>Setting > SERVICE ACCOUNTS</strong> in <a href='https://console.firebase.google.com' target='_blank'>Firebase Console</a>";
  }

  /**
   * Get the settings option array and print one of its values
   */
  public static function api_key_callback()
  {
      self::print_form("api_key");
  }

  /**
   * Get the settings option array and print one of its values
   */
  public static function auth_domain_callback()
  {
      self::print_form("auth_domain");
  }

  /**
   * Get the settings option array and print one of its values
   */
  public static function database_url_callback()
  {
      self::print_form("database_url");
  }


  /**
   * Get the settings option array and print one of its values
   */
  public static function project_id_callback()
  {
      self::print_form("project_id");
  }

  /**
   * Print input form
   * @param  [type] $form_id [description]
   * @return [type]          [description]
   */
  public static function print_form($form_id){
      printf(
          "<input type='text' id='$form_id' name='firebase_credentials[$form_id]' value='%s'  style='width: %u%%;'/>",
          isset( self::$options[$form_id] ) ? esc_attr( self::$options[$form_id]) : '', 100
      );
  }

  /**
   * Display firebase content on Setting page
   * @return [type] [description]
   */
  public static function display_page() {
    echo "<div class='wrap'>";
        echo "<h1>Firebase Settings</h1>";
        echo "<form method='post' action='options.php'>";
            // This prints out all hidden setting fields
            settings_fields( 'firebase_option_group' );
            do_settings_sections( 'firebase-setting' );
            submit_button();
        echo "</form>";
    echo "</div>";
  }
}
?>
