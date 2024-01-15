/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
// Bootstrap
require('bootstrap');
// start the Stimulus application
import 'bootstrap';
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

// Font Awesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import './JS/calendar';
import a2lix_lib from '@a2lix/symfony-collection/dist/a2lix_sf_collection.min'
// import a2lix_lib from 'https://esm.run/@a2lix/symfony-collection/dist/a2lix_sf_collection.min';

a2lix_lib.sfCollection.init()
