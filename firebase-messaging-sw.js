importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

const firebaseConfig = {
  apiKey: "AIzaSyBj4q_GMjkGYj-o4FPKMuIh1K8me51Grvs",
  authDomain: "v-tutor-b5f7c.firebaseapp.com",
  projectId: "v-tutor-b5f7c",
  storageBucket: "v-tutor-b5f7c.firebasestorage.app",
  messagingSenderId: "1042624521253",
  appId: "1:1042624521253:web:87347e224c32713425cbcc",
  measurementId: "G-Q9NNV8XQT1"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();


messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message:', payload);

    const notificationTitle = payload.notification?.title || payload.data?.title || 'VTutor Notification';
    const notificationBody = payload.notification?.body || payload.data?.body || 'You have a new update.';
    const clickLink = payload.data?.link || '/';

    const notificationOptions = {
        body: notificationBody,
        icon: '/assets/images/logo.png',
        data: { url: clickLink },
    };


    self.registration.showNotification(notificationTitle, notificationOptions);


    self.clients.matchAll({ includeUncontrolled: true, type: 'window' }).then(clients => {
        clients.forEach(client => {
            client.postMessage({
                type: 'FCM_NOTIFICATION',
                data: payload.data,
            });
        });
    });
});


self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    const target = event.notification.data?.url || '/';
    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(windowClients => {

            for (let client of windowClients) {
                if (client.url.includes(target) && 'focus' in client) {
                    return client.focus();
                }
            }

            if (clients.openWindow) {
                return clients.openWindow(target);
            }
        })
    );
});
