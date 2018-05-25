(function( $ ) {
  'use strict';

  console.log('firebase added!');
  if(typeof window.firebaseOptions !== 'undefined'){
    console.log(window.firebaseOptions);

    // Initialize FirebaseApp
    if (!firebase.apps.length) {
        firebase.initializeApp(window.firebaseOptions);
    }
  }
})( jQuery )
