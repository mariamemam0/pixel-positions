console.log('🚀 Starting nuclear debug...');

// Load Echo
import './bootstrap';

import.meta.glob([
    '../images/**'
]);

console.log('🚀 Starting final debug...');



function createNotification(message) {
    const div = document.createElement('div');
    div.textContent = '🎯 ' + message;
    div.style.cssText = 'position:fixed;top:0;left:0;background:green;color:white;padding:20px;z-index:999999;font-size:18px;';
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 5000);
}

if (window.Laravel?.userId) {
    console.log('Subscribing to user.' + window.Laravel.userId);
    
    // Listen for your custom event name with DOT prefix
    window.Echo.private(`user.${window.Laravel.userId}`)
        .listen('.new.job.posted', (data) => {
            createNotification('REAL-TIME WORKING! ' + data.message);
            console.log('✅ Real-time notification:', data);
        })
        .error((error) => {
            console.error('❌ Echo error:', error);
        });
    
    createNotification('Subscribed to real-time notifications!');
}