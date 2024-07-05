/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    // apiKey: "AIzaSyD8Zhjx1DB0hUvjOYJGaYmPyP6DqJqHoYg",
    // authDomain: "car-notifiy.firebaseapp.com",
    // projectId: "car-notifiy",
    // storageBucket: "car-notifiy.appspot.com",
    // messagingSenderId: "1054610038633",
    // appId: "1:1054610038633:web:5c319ef422b80f8f1827f8",
    // measurementId: "G-KJSWHZNDXG"

    apiKey: 'AIzaSyBEn2l0L2pS97sFfP4S3rIE0aQuRFKXLbE',
    appId: '1:635057540220:web:facf844e93dcd91d948df9',
    messagingSenderId: '635057540220',
    projectId: 'eatchen-b2f7e',
    authDomain: 'eatchen-b2f7e.firebaseapp.com',
    storageBucket: 'eatchen-b2f7e.appspot.com',
    measurementId: 'G-WRQ9RFXDHS',
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
