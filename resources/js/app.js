import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Menu from './Components/Menu.vue';

import Pagination from './Components/Pagination.vue';

import { createPinia } from 'pinia';
const pinia = createPinia();

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import Cleave from 'vue-cleave-component';


const app = createApp(App);
app.component('Menu',Menu)
app.component('Paginatiom',Pagination);
app.use(VueSweetalert2);
app.use(Cleave);
app.use(router);
app.use(pinia);
app.mount('#app');