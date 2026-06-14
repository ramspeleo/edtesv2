import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// DataTables
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

// Bootstrap Icons
import 'bootstrap-icons/font/bootstrap-icons.css';