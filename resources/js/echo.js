// resources/js/echo.js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Get CSRF token from meta tag (more reliable)
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
    encrypted: false,
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }
});