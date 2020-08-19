;(function ($) {
  'use strict'

  if (
    typeof window.firebaseOptions !== 'undefined' &&
    window.firebaseDatabaseOptions !== undefined
  ) {
    // Initialize FirebaseApp
    if (!firebase.apps.length) {
      firebase.initializeApp(window.firebaseOptions)
    }

    $(document).ready(function () {
      let db
      let collections

      if (window.firebaseDatabaseOptions.databaseType === 'realtime') {
        db = firebase.database()
      }

      if (window.firebaseDatabaseOptions.databaseType === 'firestore') {
        db = firebase.firestore()
        // timestampsInSnapshots is removed in 7.8.2
        // const settings = {timestampsInSnapshots: true};
        // db.settings()
      }

      if (window.firebaseDatabaseOptions.collections !== undefined) {
        collections = window.firebaseDatabaseOptions.collections
      }

      $('#get_database').on('click', function (e) {
        e.preventDefault()
        let collectionArray = collections.trim().split(',')
        collectionArray.map(name => {
          showDatabase(name.trim())
        })
        $(this).hide()
      })

      const appendData = (collectionName, result, listElemnt) => {
        const text = document.createTextNode(
          collectionName + ': ' + JSON.stringify(result, undefined, 2)
        )
        listElemnt.append(text)
        $('.database-holder').append(listElemnt)
      }

      const showDatabase = collectionName => {
        const listElemnt = document.createElement('pre')

        if (window.firebaseDatabaseOptions.databaseType === 'realtime') {
          const ref = db.ref(collectionName)
          ref.on(
            'value',
            function (snapshot) {
              let result = snapshot.val()
              if (result === null) {
                result = `No results found.`
              }
              if ($.isArray(result)) {
                result = result.filter(val => val !== '')
              }
              appendData(collectionName, result, listElemnt)
            },
            function (error) {
              console.log('There was an error: ' + error)
            }
          )
        } else if (
          window.firebaseDatabaseOptions.databaseType === 'firestore'
        ) {
          db.collection(collectionName)
            .get()
            .then(querySnapshot => {
              let result = {}
              querySnapshot.forEach(doc => {
                result[doc.id] = doc.data()
              })
              if (Object.keys(result).length === 0) {
                result['error'] = 'No results found.'
              }
              appendData(collectionName, result, listElemnt)
            })
        } else {
          $('.database-holder').append('Sorry, this action cannot be done!')
        }
      }
    })
  } else {
    console.warn('Please enter your Firebase settings!')
  }
})(jQuery)
