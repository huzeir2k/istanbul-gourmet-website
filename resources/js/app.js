import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import ShopPage from './components/ShopPage.vue';
import AboutPage from './components/AboutPage.vue';
import ContactPage from './components/ContactPage.vue';
import ProductDetail from './components/ProductDetail.vue';

window.Alpine = Alpine;
Alpine.start();

// Create Vue app instance
const app = createApp(App);

// Register all page components globally
app.component('HomePage', HomePage);
app.component('ShopPage', ShopPage);
app.component('AboutPage', AboutPage);
app.component('ContactPage', ContactPage);
app.component('ProductDetail', ProductDetail);

// Mount Vue app
app.mount('#app');

