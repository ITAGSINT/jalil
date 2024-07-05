window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

// const Token = window.Larvel;




// window.axios.defaults.headers.common['Authorization'] = "Bearer " + bearerToken;
// window.axios.defaults.withCredentials = true;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');




// Echo.channel('location')
//     .listen('TestEvent', (e) => {
//         console.log(e);
//     });
