import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './components/App.vue';

window.Alpine = Alpine;
Alpine.start();

// Mount Vue separately
const app = createApp(App);
app.mount('#app');

