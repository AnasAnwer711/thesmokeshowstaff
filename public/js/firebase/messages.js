import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-messaging.js";

// subscribe to firebase messaging
function subscribeFirebaseMessaging(messaging) {
    // Get the token from the service
    getToken(messaging, {
        vapidKey: "BDkIZBFqaIk4CvL2IyhfZK6x-7xGVHkMHV3Lo0JNTlQsx2LZ3a1TJl15x7mCP6iF_Lb-Wd6fUIzORXZOfsU7ujo",
    })
        .then((token) => {
            let oldToken = window.localStorage.getItem("firebaseToken");

            if ((!!oldToken && oldToken !== token) || !oldToken) {
                // send token to server
                angular
                    .element("#baseScope")
                    .scope()
                    .ajaxPost("save-fcm-token", { token })
                    .then(({ data }) => {
                        if (data.success) {
                            window.localStorage.setItem("firebaseToken", token);
                        }
                    })
                    .catch(({ response: { data } }) => {
                        console.log(data.message);
                    });
            }

            // send token to server
            onMessage(messaging, (payload) => {
                toastr.success(payload.notification.title, payload.notification.body, {
                    closeButton: true,
                    timeOut: 0,
                    onclick: () => {
                        if (payload.notification.click_action) {
                            window.location(payload.notification.click_action);
                        } else {
                            console.log("clicked");
                        }
                    },
                });
            });
        })
        .catch((err) => {
            console.log(err);
        });
}

function enableFirebase() {
    const firebaseConfig = {
        apiKey: "AIzaSyCqR2G5uty-MxV4ZKckl26-JkP_oQCwv9Q",
        authDomain: "show-staff.firebaseapp.com",
        projectId: "show-staff",
        storageBucket: "show-staff.appspot.com",
        messagingSenderId: "116329160490",
        appId: "1:116329160490:web:190df7f734cccf6d090853",
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);

    // Initialize Firebase Cloud Messaging and get a reference to the service
    const messaging = getMessaging(app);

    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
        subscribeFirebaseMessaging(messaging);
    } else if (Notification.permission !== "denied" || Notification.permission === "default") {
        Notification.requestPermission()
            .then((permission) => {
                if (permission === "granted") {
                    subscribeFirebaseMessaging(messaging);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }
}

enableFirebase();
