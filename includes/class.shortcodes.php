<?php
  class Firebase_Shortcode {
    private static $initiated = false;

    public static function init() {
      if( ! self::$initiated ){
        self::init_hooks();
      }
    }

    public static function init_hooks() {
      self::$initiated = true;
      // Login & Logout
      add_shortcode('firebase_login', array( 'Firebase_Shortcode', 'firebase_login_func' ));
      add_shortcode('firebase_logout', array( 'Firebase_Shortcode', 'firebase_logout_func' ));
      add_shortcode('firebase_greetings', array( 'Firebase_Shortcode', 'firebase_greetings_func' ));
      add_shortcode('firebase_login_error', array( 'Firebase_Shortcode', 'firebase_login_error_func' ));

      //  General data
      add_shortcode('firebase_show', array( 'Firebase_Shortcode', 'firebase_show_func' ));
      add_shortcode('firebase_show_not_login', array( 'Firebase_Shortcode', 'firebase_show_not_login_func' ));

      // Realtime database
      add_shortcode('realtime', array( 'Firebase_Shortcode', 'realtime_func' ));
    }

    public static function firebase_login_func() {
      $html = "";
      $html .= "<form id='firebase-login-form'>";
          $html .= "<div>";
              $html .= "<div>";
                  $html .= "<label for='name'>E-mail</label>";
                  $html .= "<input type='email' name='email'>";
              $html .= "</div>";
          $html .= "</div>";

          $html .= "<div>";
              $html .= "<div>";
                  $html .= "<label for='email'>Password</label>";
                  $html .= "<input type='password' name='password'>";
              $html .= "</div>";
          $html .= "</div>";

          $html .= "<button id='firebase-form-submit' class='firebase-btn'>Login</button>";
      $html .= "</form>";
      return $html;
    }

    public static function firebase_logout_func() {
      $html = "";
      $html .= "<button id='firebase-signout' class='firebase-btn'>Sign Out</button>";
      return $html;
    }

    public static function firebase_greetings_func() {
      $html = "";
      $html .= "<div id='firebase-user'></div>";
      return $html;
    }

    public static function firebase_show_func($atts, $content) {
      $class_name = "";
      if(isset($atts['class'])){
        $class_name = $atts['class'];
      }
      $html = "";
      $html .= "<div class='firebase-show $class_name'>";
      $html .= $content;
      $html .= "</div>";
      return $html;
    }

    public static function firebase_show_not_login_func($atts, $content) {
      $class_name = "";
      if(isset($atts['class'])){
        $class_name = $atts['class'];
      }
      $html = "";
      $html .= "<div class='firebase-show-when-not-login $class_name'>";
      $html .= $content;
      $html .= "</div>";
      return $html;
    }

    public static function firebase_login_error_func($atts) {
      $class_name = "";
      if(isset($atts['class'])){
        $class_name = $atts['class'];
      }
      $html = "";
      $html .= "<div class='$class_name'>";
        $html .= "<p id='firebase-login-error'></p>";
      $html .= "</div>";
      return $html;
    }

    /**
     * Realtime database
     */
     public static function realtime_func($atts) {
       $class_name = "";
       $collection_name = "";
       $document_name = "";

       if(isset($atts['class'])){
         $class_name = $atts['class'];
       }

       if(isset($atts['collection_name'])){
         $collection_name = $atts['collection_name'];
       }

       if(isset($atts['document_name'])){
         $document_name = $atts['document_name'];
       }

       $html = "";
       $html .= "<div id='if-realtime' class='if-realtime $class_name' data-collection-name='$collection_name' data-document-name='$document_name'>";       
       $html .= "</div>";
       return $html;
     }

  }
?>
