<?php
/**
 * Add Firebase setting menu
 * @var [type]
 */

class Firebase_Admin {
    private static $initiated = false;
    private static $options;
    private static $options_database;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
        self::$options = get_option("firebase_credentials");
        self::$options_database = get_option("firebase_database");

        add_action("admin_menu", array("Firebase_Admin", "admin_menu"));
        add_action("admin_init", array("Firebase_Admin", "register_settings"));
        add_action('admin_enqueue_scripts', array('Firebase_Admin', 'load_firebase_admin_js'));
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
        $position = null;

        add_options_page(__($page_title, "firebase"), __($menu_title, "firebase"), $capability, $menu_slug, array("Firebase_Admin", $function), $position);
    }

    public static function load_firebase_admin_js() {
        // Load plugins files

        wp_enqueue_style('firebase-admin', plugin_dir_url(dirname(__FILE__)) . 'css/firebase-admin.css');

        wp_enqueue_script('firebase_app', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_auth', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-auth.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_database', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-database.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_firestore', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-firestore.js', array(), FIREBASE_WP_VERSION, false);

        wp_enqueue_script('firebase-admin', plugin_dir_url(dirname(__FILE__)) . 'js/firebase-admin.js', array('jquery'), FIREBASE_WP_VERSION, false);
        wp_localize_script('firebase-admin', 'firebaseDatabaseOptions', array(
            'databaseType' => self::$options_database['database_type'],
            'collections' => self::$options_database['collection_names'],
        )
        );
        wp_localize_script('firebase-admin', 'firebaseOptions', array(
            'apiKey' => self::$options['api_key'],
            'authDomain' => self::$options['auth_domain'],
            'databaseURL' => self::$options['database_url'],
            'projectId' => self::$options['project_id'],
        )
        );
    }

    public static function register_settings() {
        // General Setting
        register_setting(
            "firebase_option_group",
            "firebase_credentials",
            array("Firebase_Admin", "sanitize")
        );

        add_settings_section(
            'setting_section_id', // ID
            'Enter your firebase credentials below:', // Title
            array("Firebase_Admin", 'print_section_info'), // Callback
            'general' // Page
        );

        add_settings_field(
            'api_key', // ID
            'API Key', // Title
            array("Firebase_Admin", 'api_key_callback'), // Callback
            'general', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'auth_domain', // ID
            'Auth Domain', // Title
            array("Firebase_Admin", 'auth_domain_callback'), // Callback
            'general', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'database_url', // ID
            'Database URL', // Title
            array("Firebase_Admin", 'database_url_callback'), // Callback
            'general', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'project_id', // ID
            'Project Id', // Title
            array("Firebase_Admin", 'project_id_callback'), // Callback
            'general', // Page
            'setting_section_id' // Section
        );

        // Database Settings
        register_setting(
            "firebase_database_group",
            "firebase_database",
            array("Firebase_Admin", "sanitize")
        );

        add_settings_section(
            'database_section_id', // ID
            'Please choose your database type and collection names', // Title
            array("Firebase_Admin", 'print_database_section_info'), // Callback
            'database' // Page
        );

        add_settings_field(
            'database_type', // ID
            'Database Type', // Title
            array("Firebase_Admin", 'database_type_callback'), // Callback
            'database', // Page
            'database_section_id', // Section
            array(
                'label_for' => 'Database type', // makes the field name clickable,
                'name' => 'database_type', // value for 'name' attribute
                'value' => esc_attr(isset(self::$options_database['database_type']) ? esc_attr(self::$options_database['database_type']) : 'realtime'),
                'options' => array(
                    'realtime' => 'Real Time',
                    'firestore' => 'Firestore',
                ),
                'option_name' => 'firebase_database',
            )
        );

        add_settings_field(
            'collection_names', // ID
            'Collection Names', // Title
            array("Firebase_Admin", 'collection_names_callback'), // Callback
            'database', // Page
            'database_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public static function sanitize($input) {
        $new_input = array();

        // General

        if (isset($input['api_key'])) {
            $new_input['api_key'] = sanitize_text_field($input['api_key']);
        }

        if (isset($input['auth_domain'])) {
            $new_input['auth_domain'] = sanitize_text_field($input['auth_domain']);
        }

        if (isset($input['database_url'])) {
            $new_input['database_url'] = sanitize_text_field($input['database_url']);
        }

        if (isset($input['project_id'])) {
            $new_input['project_id'] = sanitize_text_field($input['project_id']);
        }

        // Database
        if (isset($input['database_type'])) {
            $new_input['database_type'] = sanitize_text_field($input['database_type']);
        }

        if (isset($input['collection_names'])) {
            $new_input['collection_names'] = sanitize_text_field($input['collection_names']);
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public static function print_section_info() {
        print "Firebase info can be found in Project <strong>Setting > SERVICE ACCOUNTS</strong> in <a href='https://console.firebase.google.com' target='_blank'>Firebase Console</a>";
    }

    /**
     * Print the Section text
     */
    public static function print_database_section_info() {
        print "<i>*This plugin only supports Real Time Database at the momment. I will add Firestore in the future.</i>";
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function api_key_callback() {
        self::print_form("api_key");
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function auth_domain_callback() {
        self::print_form("auth_domain");
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function database_url_callback() {
        self::print_form("database_url");
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function project_id_callback() {
        self::print_form("project_id");
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function database_type_callback($args, $database_type = 'database_type') {
        printf(
            '<select name="%1$s[%2$s]" id="%3$s">',
            $args['option_name'],
            $args['name'],
            $args['name']
        );

        foreach ($args['options'] as $val => $title) {
            printf(
                '<option value="%1$s" %2$s>%3$s</option>',
                $val,
                selected($val, $args['value'], FALSE),
                $title
            );
        }

        print '</select>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public static function collection_names_callback() {
        self::print_form_database("collection_names");
    }

    /**
     * Print input form
     * @param  [type] $form_id [description]
     * @return [type]          [description]
     */
    public static function print_form($form_id) {
        printf(
            "<input type='text' id='$form_id' name='firebase_credentials[$form_id]' value='%s'  style='width: %u%%;'/>",
            isset(self::$options[$form_id]) ? esc_attr(self::$options[$form_id]) : '', 100
        );
    }

    public static function print_form_database($form_id) {
        printf(
            "<input type='text' id='$form_id' name='firebase_database[$form_id]' value='%s'  style='width: %u%%;'/>",
            isset(self::$options_database[$form_id]) ? esc_attr(self::$options_database[$form_id]) : '', 100
        );
    }

    /**
     * Display firebase content on Setting page
     * @return [type] [description]
     */
    public static function display_page() {
        echo "<div class='wrap'>";
        echo "<h1>Firebase Settings</h1>";
        echo "<h3>Integrate Firebase to WordPress (<a href='https://github.com/dalenguyen/firebase-wordpress-plugin' target='_blank'>Github</a> - v" . FIREBASE_WP_VERSION . ")</h3>";
        echo "<p>Are you interested in <a href='https://firebase.dalenguyen.me/' target='_blank'>PRO version?</p>";
        settings_errors();

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
        $general_class = $active_tab === 'general' ? 'nav-tab-active' : '';
        $database_class = $active_tab === 'database' ? 'nav-tab-active' : '';
        $about_class = $active_tab === 'about' ? 'nav-tab-active' : '';

        echo "<h2 class='nav-tab-wrapper'>";
        echo "<a href='?page=firebase-setting&tab=general' class='nav-tab $general_class'>General</a>";
        echo "<a href='?page=firebase-setting&tab=database' class='nav-tab $database_class'>Database</a>";
        echo "<a href='?page=firebase-setting&tab=about' class='nav-tab $about_class'>About</a>";
        echo "</h2>";

        echo "<form method='post' action='options.php'>";
        // This prints out all hidden setting fields
        if ($active_tab === 'general') {
            settings_fields('firebase_option_group');
            do_settings_sections('general');
            submit_button();
        } else if ($active_tab === 'database') {
            settings_fields('firebase_database_group');
            do_settings_sections('database');
            if (isset(self::$options_database['collection_names']) && !empty(self::$options_database['collection_names'])) {
                echo "<a href='#' id='get_database'>Show Database</a>";
            }
            submit_button();
            echo "<div class='database-holder'></div>";
        } else if ($active_tab === 'about') {
            echo "<h3>This plugin is developed by <a href='https://github.com/dalenguyen' target='_blank'>Dale Nguyen</a></h3>";
            echo "<p>If you appreciate the work and want to show your support, just <a href='https://www.paypal.me/DaleNguyen' target='_blank'>buy me a coffee!</a> ;)</p>";
            echo "<p>If you want to create issues or request features, please post it on <a href='https://github.com/dalenguyen/firebase-wordpress-plugin/issues' target='_blank'>Github</a>.";
        }

        echo "</form>";
        echo "</div>";
    }
}
?>
