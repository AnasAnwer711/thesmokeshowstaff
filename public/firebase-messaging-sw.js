importScripts("https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyCqR2G5uty-MxV4ZKckl26-JkP_oQCwv9Q",
    authDomain: "show-staff.firebaseapp.com",
    projectId: "show-staff",
    storageBucket: "show-staff.appspot.com",
    messagingSenderId: "116329160490",
    appId: "1:116329160490:web:190df7f734cccf6d090853",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log("Message received. ", payload);

    toastr.success("testing back");

    let notification = new Notification({
        title: payload.notification.title,
        body: payload.notification.body,
    });

    notification.click = () => {
        if (payload.notification.click_action) {
            window.location(payload.notification.click_action);
        } else {
            console.log("background notification clicked");
        }
    };
});
