import './bootstrap';
import './bootstrap.bundle.js';

import $ from 'jquery';
import axios from 'axios';
import Alpine from 'alpinejs';

window.$ = $;
window.axios = axios;
window.Alpine = Alpine;

import './alpine.js';

Alpine.start();
