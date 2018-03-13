
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


// https://datatables.net/
window.datatables = require('datatables.net');
window.datatables_bs = require('datatables.net-bs');
require("drmonty-datatables-plugins/sorting/datetime-moment");
require("datatables.net-bs/css/dataTables.bootstrap.css");

// https://momentjs.com/
window.moment = require('moment');

// https://twitter.github.io/typeahead.js/
window.typeahead = require('typeahead.js');
window.Bloodhound = require('bloodhound-js');

// https://github.com/uxsolutions/bootstrap-datepicker
// window.datetimepicker = require('eonasdan-bootstrap-datetimepicker');

// http://selectize.github.io/selectize.js/
// window.selectize = require('selectize');

// https://chmln.github.io/flatpickr/getting-started/#usage
// window.flatpickr = require('flatpickr');
// require("flatpickr/dist/themes/airbnb.css");


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
//

//
// window.Jasny = require('jasny-bootstrap');
window.Jasny = require('jasny-bootstrap/dist/js/jasny-bootstrap.js');