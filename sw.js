// sw.js
self.addEventListener('install', (e) => {
    self.skipWaiting();
});

self.addEventListener('fetch', (event) => {
    // Esse evento vazio é o que libera a instalação no Chrome
});
