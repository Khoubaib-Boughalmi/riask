self.addEventListener('install', function (event) {
    console.log('[Service Worker] Installing Service Worker ...', event);

  });
  
self.addEventListener('activate', function (event) {
    console.log('[Service Worker] Activating Service Worker ....', event);
 
return self.clients.claim();
});

self.addEventListener(fetch, (event) => {
    console.log('Inside the fetch handler:', event);
});