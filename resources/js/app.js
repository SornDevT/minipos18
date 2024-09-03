import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Menu from './Components/Menu.vue';

import Pagination from './Components/Pagination.vue';

import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App);
app.component('Menu',Menu)
app.component('Paginatiom',Pagination);
app.use(router);
app.use(pinia);
app.mount('#app');