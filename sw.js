const CACHE_NAME = 'oque-cache-v1';

// Estratégia: Instala rápido e tenta fazer cache básico
self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(clients.claim());
});

// Responde do cache se houver, senão vai para rede
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
