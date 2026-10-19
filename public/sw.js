// Service Worker untuk FKMT-G Mobile PWA
const CACHE_NAME = 'fkmtg-cache-v2';
const urlsToCache = [
  '/',
  '/assets/css/style.css',
  '/assets/images/logo.png',
  '/manifest.json'
];

self.addEventListener('install', event => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache)).catch(() => {})
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cache => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;
  // Jangan campuri halaman admin/login (selalu butuh data terbaru dari server)
  const url = new URL(event.request.url);
  if (url.pathname.startsWith('/admin') || url.pathname === '/login') return;

  event.respondWith(
    fetch(event.request).catch(() =>
      // ignoreSearch: style.css?v=123 tetap cocok dengan cache /assets/css/style.css
      caches.match(event.request, { ignoreSearch: true })
    )
  );
});
