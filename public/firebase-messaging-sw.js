importScripts('https://www.gstatic.com/firebasejs/8.1.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.2/firebase-messaging.js');

var config = {
    apiKey: "AIzaSyBYqNsqffWTgHtxdt7Pl5SXMJEJdsaWwrM",
    authDomain: "bumblebee-833833.firebaseapp.com",
    projectId: "bumblebee-833833",
    storageBucket: "bumblebee-833833.appspot.com",
    messagingSenderId: "589243070383",
    appId: "1:589243070383:web:96a6bc7fa6006c81b2e15a",
    measurementId: "G-V7JBXL9PL5"
};

firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    // console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    // console.log('click action: ', payload.data.click_action);
    const notificationTitle = payload.data.message;
    const notificationOptions = {
        data: {
            order_id: payload.data.order_id
        }
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

addEventListener('notificationclick', event => {
    event.waitUntil(async function() {
        const clientList = await clients.matchAll({
            includeUncontrolled: true
        });
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url.includes('/driver_app') && 'focus' in client)
            {
                client.focus();
                event.notification.close();
                return;
            }
        }
        if (clients.openWindow) {
            event.notification.close();
            return clients.openWindow('/driver_app#/order-details/' + event.notification.data.order_id);
        }
    }());
});
