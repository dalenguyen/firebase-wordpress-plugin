(function( $ ) {
  'use strict';

  if(typeof window.firebaseOptions !== 'undefined' && window.firebaseDatabaseOptions !== undefined){

    // Initialize FirebaseApp
    if (!firebase.apps.length) {
        firebase.initializeApp(window.firebaseOptions);
    }

    $(document).ready(function(){
      let db;
      let collections;
      if(window.firebaseDatabaseOptions.databaseType === 'realtime') {
        db = firebase.database();
        if(window.firebaseDatabaseOptions.collections !== undefined) {
          collections = window.firebaseDatabaseOptions.collections;
        }
      }

      $('#get_database').on('click', function(e){
        e.preventDefault();
        let collectionArray = collections.trim().split(',');
        collectionArray.map(name => {
          showDatabase(name.trim());
        })
        $(this).hide();
      })

      const showDatabase = (collectionName) => {
        const ref = db.ref(collectionName);
        ref.on('value', function (snapshot) {
            let result = snapshot.val();            
            const listElemnt = document.createElement('pre');
            if(result === null){
              result = `No results found.`;
            }
            if($.isArray(result)){
              result = result.filter(val => val !== '');
            }
            const text = document.createTextNode(collectionName + ': ' + JSON.stringify(result));
            listElemnt.append(text);
            $('.database-holder').append(listElemnt);
        }, function (error) {
            console.log('There was an error: ' + error);
        });
      }
    })
  } else {
    console.warn('Please enter your Firebase settings!');
  }
})( jQuery )
