var CACHE_NAME = 'FotoVoting-cache-v2';
var urlsToCache = [

];

self.addEventListener('install', function(event) {
    // Perform install steps
});

self.addEventListener('fetch', function(event) {

});

self.addEventListener('activate', function(event) {

    var cacheAllowlist = [];

    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheAllowlist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});