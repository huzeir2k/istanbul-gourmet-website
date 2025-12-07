<template>
  <div class="app-container">
    <Header />
    <main class="app-main" role="main" :aria-label="getPageTitle()">
      <!-- Display the current page based on URL -->
      <HomePage v-if="currentPage === 'home'" />
      <ShopPage v-else-if="currentPage === 'shop'" />
      <ProductDetail v-else-if="currentPage === 'product'" :product-id="productId" />
      <AboutPage v-else-if="currentPage === 'about'" />
      <ContactPage v-else-if="currentPage === 'contact'" />
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from './Header.vue';
import Footer from './Footer.vue';
import HomePage from './HomePage.vue';
import ShopPage from './ShopPage.vue';
import ProductDetail from './ProductDetail.vue';
import AboutPage from './AboutPage.vue';
import ContactPage from './ContactPage.vue';
import { initThemeSystem, watchTheme } from '../services/themeService.js';

export default {
  name: 'App',
  components: {
    Header,
    Footer,
    HomePage,
    ShopPage,
    ProductDetail,
    AboutPage,
    ContactPage,
  },
  data() {
    return {
      currentPage: 'home',
      productId: null,
      themeProgress: 0,
      isDayMode: true,
    };
  },
  mounted() {
    // Determine which page to show based on URL path
    this.updatePageFromUrl();
    
    // Listen for URL changes (when user clicks links)
    window.addEventListener('popstate', () => {
      this.updatePageFromUrl();
    });
    
    // Initialize theme system
    initThemeSystem(60000); // Update every minute
    
    // Watch theme changes and update component state
    this.unsubscribeTheme = watchTheme(({ progress, isDayMode }) => {
      this.themeProgress = progress;
      this.isDayMode = isDayMode;
    }, 60000);
  },
  beforeUnmount() {
    // Cleanup theme watcher
    if (this.unsubscribeTheme) {
      this.unsubscribeTheme();
    }
  },
  methods: {
    /**
     * Parse the current URL and set the appropriate page
     */
    updatePageFromUrl() {
      const path = window.location.pathname;
      
      if (path === '/' || path === '') {
        this.currentPage = 'home';
      } else if (path === '/shop') {
        this.currentPage = 'shop';
      } else if (path === '/about') {
        this.currentPage = 'about';
      } else if (path === '/contact') {
        this.currentPage = 'contact';
      } else if (path.startsWith('/products/')) {
        this.currentPage = 'product';
        // Extract product ID from URL: /products/{id}
        this.productId = path.split('/')[2];
      }
    },
    /**
     * Get the current page title for aria-label
     */
    getPageTitle() {
      const titles = {
        'home': 'Home page',
        'shop': 'Shop page - Browse our products',
        'about': 'About Us',
        'contact': 'Contact Us',
        'product': `Product Details - Item ${this.productId}`,
      };
      return titles[this.currentPage] || 'Istanbul Gourmet Market';
    },
  },
};
</script>

<style scoped>
.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: var(--color-background);
  color: var(--color-text);
  transition: background-color var(--theme-transition), color var(--theme-transition);
}

.app-main {
  flex: 1;
  background-color: var(--color-light-bg);
  transition: background-color var(--theme-transition);
}
</style>
