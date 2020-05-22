(function ($) {
  'use strict';

  if (typeof window.firebaseOptions !== 'undefined') {
    // Initialize FirebaseApp
    if (!firebase.apps.length) {
      firebase.initializeApp(window.firebaseOptions);
    }

    $(document).ready(function () {
      init();

      // Check user state
      checkUserState().then((loggedin) => {
        if (loggedin) {
          action_when_login();
          showGreetings();
        } else {
          action_when_logout();
        }
      });

      // Firebase login
      $('#firebase-form-submit').click(function (event) {
        event.preventDefault();
        let data = $('#firebase-login-form :input').serializeArray();
        let email = data[0].value;
        let password = data[1].value;

        // start login into firebase
        if (email !== '' && password !== '') {
          firebase
            .auth()
            .signInWithEmailAndPassword(email, password)
            .then(() => {
              action_when_login();
              showGreetings();
            })
            .catch((error) => {
              console.log(error.message);
              $('p#firebase-login-error').show();
              $('p#firebase-login-error').text(error.message);
            });
        } else {
          $('p#firebase-login-error').text(
            'Your email or password is missing!'
          );
        }
      });

      // Sign out action
      $('#firebase-signout').on('click', (e) => {
        e.preventDefault();
        firebase
          .auth()
          .signOut()
          .then(() => {
            action_when_logout();
          })
          .catch((error) => console.log(error));
      });

      function checkUserState() {
        return new Promise((resolve, reject) => {
          return firebase.auth().onAuthStateChanged(function (user) {
            if (user) {
              // User is signed in.
              resolve(true);
            } else {
              // User is signed out.
              resolve(false);
            }
          });
        });
      }

      function showGreetings() {
        firebase.auth().onAuthStateChanged(function (user) {
          if (user) {
            // User is signed in.
            if (user.displayName === null) {
              $('#firebase-user').text(`Greetings, ${user.email}!`);
            } else {
              $('#firebase-user').text(`Greetings, ${user.displayName}!`);
            }
          } else {
            $('#firebase-user').hide();
          }
        });
      }

      // Realtime database
      function showRealtimeDatabase() {
        var db = firebase.database();
        var realtimeEl = $('#if-realtime');
        var collectionName = realtimeEl.data('collection-name');
        var documentName = realtimeEl.data('document-name');

        if (collectionName && documentName) {
          db.ref('/' + collectionName + '/' + documentName)
            .once('value')
            .then(function (snapshot) {
              var dataObj = snapshot.val();
              if (dataObj) {
                var html = '<table>';
                $.each(dataObj, function (key, value) {
                  html += '<tr>';
                  html += '<td>' + key + '</td>';
                  html += '<td>' + value + '</td>';
                  html += '</tr>';
                });
                html += '</table>';
                realtimeEl.append(html);
              } else {
                console.error(
                  'Please check your collection and document name in the [realtime] shortcode!'
                );
              }
            });
        } else {
          console.warn(
            'Please check your collection and document name in the [realtime] shortcode!'
          );
        }
      }

      function init() {
        action_when_logout();
        // Realtime database
        showRealtimeDatabase();
      }

      function action_when_login() {
        $('.firebase-show').show();
        $('#firebase-signout').show();
        $('p#firebase-login-error').hide();
        $('.firebase-show-when-not-login').hide();
        $('#firebase-login-form').hide();
      }

      function action_when_logout() {
        $('.firebase-show').hide();
        $('#firebase-signout').hide();
        $('p#firebase-login-error').hide();
        $('.firebase-show-when-not-login').show();
        $('#firebase-login-form').show();
      }
    });
  } else {
    console.warn('Please enter your Firebase settings!');
  }
})(jQuery);
