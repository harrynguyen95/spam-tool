if ('function' === typeof importScripts) {
  const firebaseVersion = '8.10.1';

  importScripts("https://www.gstatic.com/firebasejs/" + firebaseVersion + "/firebase-app.js");
  importScripts("https://www.gstatic.com/firebasejs/" + firebaseVersion + "/firebase-messaging.js");
  addEventListener('message', onMessage);

  function onMessage(e) {
    // do some work here
    console.log('onMessage: ', e)
  }

  // Initialize the Firebase app in the service worker by passing in the
  // messagingSenderId.
  const firebaseConfig = {
    apiKey: "AIzaSyAsEXrun5if1Lj-gbdvEBf5AC_yXBvKfX4",
    authDomain: "hiennd-test.firebaseapp.com",
    projectId: "hiennd-test",
    storageBucket: "hiennd-test.appspot.com",
    messagingSenderId: "1030560407608",
    appId: "1:1030560407608:web:8a66a245cc1c46941486cd",
    measurementId: "G-JMCV77SEQ0"
  };

  console.log('sw initializeApp.. ')
  firebase.initializeApp(firebaseConfig);

  // Retrieve an instance of Firebase Messaging so that it can handle background messages.
  const messaging = firebase.messaging();

  messaging.onBackgroundMessage(function (payload) {
    // do some work here
    console.log('onBackgroundMessage: ', payload)

    /*
    if (!payload.notification && payload.webpush && payload.webpush.notification) {
        const notificationTitle = payload.webpush.notification.title;
        const notificationOptions = payload.webpush.notification;

        if (notificationOptions.image && !notificationOptions.icon) {
            notificationOptions.icon = notificationOptions.image;
        }

        return self.registration.showNotification(
            notificationTitle,
            notificationOptions
        );
    }
    */
  });
}