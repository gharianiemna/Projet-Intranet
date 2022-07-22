/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
// Require jQuery normally & create global $ and jQuery variables
const $ = require('jquery');
global.$ = global.jQuery = $;
 
// Bootstrap
import 'bootstrap/dist/js/bootstrap.js';
 
// Datatable (plugin jquery) pour bootstrap
import 'datatables.net/js/jquery.dataTables.js';
import 'datatables.net-bs5/js/dataTables.bootstrap5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
