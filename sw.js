var CACHE_STATIC_NAME = 'static-v1';

var STATIC_FILES = [
  '/',
  '/index.html',
  '/main.php',
  '/css/front.css',
  '/css/reaction.css',
];

self.addEventListener('install', (event) => {
    console.log('Inside the install handler:', event);
    event.waitUntil(
      caches.open(CACHE_STATIC_NAME)
        .then(function (cache) {
          console.log('[Service Worker] Precaching App Shell');
          cache.addAll(STATIC_FILES);
        })
    )
  });
  
  self.addEventListener('activate', (event) => {
    console.log('Inside the activate handler:', event);
  });
  
  self.addEventListener(fetch, (event) => {
    console.log('Inside the fetch handler:', event);
    event.respondWith(fetch(event.request))

  });