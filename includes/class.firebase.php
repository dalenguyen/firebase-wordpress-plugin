<?php
class Firebase {
    private static $initiated = false;
    private static $options;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
        self::$options = get_option("firebase_credentials");

        add_action('wp_enqueue_scripts', array('Firebase', 'load_firebase_js'));
    }

    public static function load_firebase_js() {

        wp_enqueue_style('firebase', plugin_dir_url(dirname(__FILE__)) . 'css/firebase.css');

        wp_enqueue_script('firebase_app', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_auth', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-auth.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_database', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-database.js', array(), FIREBASE_WP_VERSION, false);
        wp_enqueue_script('firebase_firestore', 'https://www.gstatic.com/firebasejs/7.18.0/firebase-firestore.js', array(), FIREBASE_WP_VERSION, false);

        wp_enqueue_script('firebase', plugin_dir_url(dirname(__FILE__)) . 'js/firebase.js', array('jquery'), FIREBASE_WP_VERSION, false);

        wp_localize_script('firebase', 'firebaseOptions', array(
            'apiKey' => self::$options['api_key'],
            'authDomain' => self::$options['auth_domain'],
            'databaseURL' => self::$options['database_url'],
            'projectId' => self::$options['project_id'],
        )
        );
    }
}
?>
