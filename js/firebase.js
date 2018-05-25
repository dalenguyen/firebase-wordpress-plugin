(function( $ ) {
  'use strict';

  console.log('firebase added!');
  if(typeof window.firebaseOptions !== 'undefined'){
    // console.log(window.firebaseOptions);

    // Initialize FirebaseApp
    if (!firebase.apps.length) {
        firebase.initializeApp(window.firebaseOptions);
    }

    $(document).ready(function(){
      // Check user state
      checkUserState().then(loggedin => {
          console.log(loggedin);
          if(loggedin){
              $('#webcam').show();
              showGreetings();
          } else {
              $('#webcam').hide();
          }
      })

      // Firebase login
      $("#form-submit").click(function(event){
        event.preventDefault();
        console.log('ready to login');
        let data = $('#login-form :input').serializeArray();
        let email = data[0].value;
        let password = data[1].value;

        // start login into firebase
        if(email !== '' && password !== ''){
            firebase.auth().signInWithEmailAndPassword(email, password)
            .then(() => {
                $('#webcam').show();
                showGreetings();
            })
            .catch( error => {
                console.log(error.message);
            })
        } else {
            alert('Your email or password is missing!');
        }
      });

      // Sign out action
      $('#firebase-signout').on('click', e => {
          console.log('Start loggint out!');
          e.preventDefault();
          firebase.auth().signOut()
          .then(() => {
              $('#webcam').hide();
          })
          .catch(error => console.log(error))
      })

      function checkUserState(){
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
          })
      }

      function showGreetings() {
          let userName = '';
          firebase.auth().onAuthStateChanged(function (user) {
              if (user) {
                  // User is signed in.
                  $('#firebase-user').text(`Greeting ${user.email}!`);
              } else {
                $('#firebase-user').hide();
              }
          })
      }
    })
  }
})( jQuery )
