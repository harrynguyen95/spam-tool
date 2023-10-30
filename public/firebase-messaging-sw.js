if ('function' === typeof importScripts) {
  const firebaseVersion = '8.10.1';

  importScripts("https://www.gstatic.com/firebasejs/" + firebaseVersion + "/firebase-app.js");
  importScripts("https://www.gstatic.com/firebasejs/" + firebaseVersion + "/firebase-messaging.js");

  // Initialize the Firebase app in the service worker by passing in the messagingSenderId.
  const firebaseConfig = {
    apiKey: "AIzaSyDO6esatJ8i14whnx7jzdevf37N9X4bRes",
    authDomain: "location-sharing-abdc2.firebaseapp.com",
    projectId: "location-sharing-abdc2",
    storageBucket: "location-sharing-abdc2.appspot.com",
    messagingSenderId: "706387942723",
    appId: "1:706387942723:web:acaa81aabe6a57ab5ea3f6",
    measurementId: "G-HY33PGT11H"
  };

  // console.log('sw initializeApp.. ')
  firebase.initializeApp(firebaseConfig);

  // Retrieve an instance of Firebase Messaging so that it can handle background messages.
  const messaging = firebase.messaging();

  messaging.onBackgroundMessage(function (payload) {
    // console.log('[firebase-messaging-sw.js] Received background message ', payload);

    self.clients.matchAll({includeUncontrolled: true}).then(function (clients) {
      // console.log(clients); 
      // You can see your main window client in this list.
      clients.forEach(function(client) {
        client.postMessage(payload.data ?? {});
      })
    })
    
  });

}
