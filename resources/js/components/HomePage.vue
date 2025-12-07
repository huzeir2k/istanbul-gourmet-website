<template>
  <div class="home-page">
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Istanbul Gourmet Market</h1>
        <p>Authentic Turkish & Mediterranean Flavors</p>
        <button @click="navigateTo('/shop')" class="cta-button">
          Explore Our Shop
        </button>
      </div>
    </section>

    <!-- What's New Section -->
    <section class="whats-new">
      <div class="container">
        <h2>What's New</h2>
        <p class="section-subtitle">Freshly arrived items this week</p>
        
        <!-- Loading State -->
        <div v-if="loading" class="loading">
          <p>Loading new products...</p>
        </div>

        <!-- New Products Grid -->
        <div v-else-if="newProducts.length > 0" class="product-grid">
          <div v-for="product in newProducts" :key="product.id" class="product-card">
            <div class="product-image">
              <img :src="getImageUrl(product)" :alt="product.name" />
            </div>
            <div class="product-info">
              <h3>{{ product.name }}</h3>
              <p class="description">{{ product.short_description }}</p>
              <div class="price-row">
                <span class="price">CAD${{ product.price_with_tax }} (after tax)</span>
              </div>
              <button @click="viewProduct(product.id)" class="btn-secondary">
                View Details
              </button>
            </div>
          </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="error-message">
          <p>{{ error }}</p>
        </div>

        <!-- Empty State -->
        <div v-else class="empty-state">
          <p>No new products at the moment. Check back soon!</p>
        </div>
      </div>
    </section>

    <!-- Google Maps Location Section -->
    <section class="location">
      <div class="container">
        <h2>Our Location</h2>
        <p class="section-subtitle">Visit us in Windsor, Ontario</p>
        
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2946.8894844445776!2d-82.9454712!3d42.3119234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b2b6a4382947b:0xc8468b6ed42aef04!2sIstanbul+Gourmet+Market!5e0!3m2!1sen!2sca!4v1234567890"
            width="100%"
            height="400"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>

        <div class="location-info">
          <h3>Tecumseh Road Location</h3>
          <p><strong>Address:</strong> Tecumseh Road, Windsor, Ontario, Canada</p>
          <p><strong>Hours:</strong> Mon-Sat 10am - 8pm, Sun 11am - 6pm</p>
          <p><strong>Phone:</strong> <a href="tel:+12262209492">(226) 220-9492</a></p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'HomePage',
  data() {
    return {
      newProducts: [],
      loading: false,
      error: null,
    };
  },
  mounted() {
    this.fetchNewProducts();
  },
  methods: {
    /**
     * Fetch the 6 most recently added products from the API
     * Sorts by created_at in descending order to show newest first
     */
    async fetchNewProducts() {
      this.loading = true;
      this.error = null;

      try {
        const response = await window.axios.get('/api/products', {
          params: {
            per_page: 6,
            sort_by: 'created_at',
            sort_order: 'desc',
          },
        });

        // Extract products from paginated response (Laravel API returns data in .data)
        this.newProducts = response.data.data || [];
      } catch (err) {
        console.error('Error fetching new products:', err);
        this.error = 'Failed to load new products. Please try again later.';
      } finally {
        this.loading = false;
      }
    },

    /**
     * Get image URL for a product with fallback to placeholder
     * If product has image path, prepend /storage/ prefix
     * Otherwise show SVG placeholder
     */
    getImageUrl(product) {
      if (product.image) {
        return `/storage/${product.image}`;
      }
      // SVG placeholder when no image available
      return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="300" height="300"%3E%3Crect fill="%23ddd" width="300" height="300"/%3E%3Ctext fill="%23999" font-size="16" x="50%" y="50%" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
    },

    /**
     * Navigate to product detail page
     */
    viewProduct(productId) {
      window.location.href = `/products/${productId}`;
    },

    /**
     * Navigate to a specified route
     */
    navigateTo(route) {
      window.location.href = route;
    },
  },
};
</script>

