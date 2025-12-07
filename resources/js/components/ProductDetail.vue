<template>
  <div class="product-detail-page">
    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <p>Loading product details...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-state">
      <p>{{ error }}</p>
      <button @click="goBack" class="btn-back">Go Back</button>
    </div>

    <!-- Product Detail -->
    <div v-else-if="product" class="product-layout">
      <!-- Image Section -->
      <section class="image-section">
        <div class="main-image-container">
          <img :src="getCurrentImage()" :alt="product.name" class="main-image" />
          <span v-if="product.category" class="category-badge">{{ product.category.name }}</span>
        </div>

        <!-- Thumbnail Gallery -->
        <div v-if="product.images && product.images.length > 0" class="thumbnail-gallery">
          <div
            class="thumbnail"
            :class="{ active: selectedImageIndex === 0 }"
            @click="selectedImageIndex = 0"
          >
            <img :src="getImageUrl(product.image)" :alt="product.name" />
          </div>
          <div
            v-for="(image, index) in product.images"
            :key="index"
            class="thumbnail"
            :class="{ active: selectedImageIndex === index + 1 }"
            @click="selectedImageIndex = index + 1"
          >
            <img :src="getImageUrl(image)" :alt="`${product.name} - Image ${index + 1}`" />
          </div>
        </div>
      </section>

      <!-- Info Section -->
      <section class="info-section">
        <!-- Product Name & Rating -->
        <div class="product-header">
          <h1>{{ product.name }}</h1>
          <p v-if="product.brand" class="brand">by {{ product.brand.name }}</p>
        </div>

        <!-- Description -->
        <div class="description-section">
          <p class="short-description">{{ product.short_description }}</p>
          <p class="full-description">{{ product.description }}</p>
        </div>

        <!-- Pricing Section -->
        <div class="pricing-section">
          <div class="price-box highlight">
            <span class="price-label">Price</span>
            <span class="price-with-tax">CAD${{ product.price_with_tax }} (after tax)</span>
          </div>
        </div>

        <!-- Stock Status -->
        <div class="stock-section">
          <div v-if="product.stock > 0" class="in-stock">
            <span class="status-badge in">✓ In Stock</span>
            <span class="stock-count">{{ product.stock }} units available</span>
          </div>
          <div v-else class="out-of-stock">
            <span class="status-badge out">✗ Out of Stock</span>
          </div>
        </div>

        <!-- Product Meta -->
        <div class="meta-section">
          <div class="meta-item">
            <span class="meta-label">SKU:</span>
            <span class="meta-value">{{ product.sku }}</span>
          </div>
          <div v-if="product.brand" class="meta-item">
            <span class="meta-label">Brand:</span>
            <span class="meta-value">{{ product.brand.name }}</span>
          </div>
          <div v-if="product.category" class="meta-item">
            <span class="meta-label">Category:</span>
            <span class="meta-value">{{ product.category.name }}</span>
          </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
          <button
            @click="showLocationPopup = true"
            class="btn-buy-now"
            :disabled="product.stock === 0"
          >
            {{ product.stock > 0 ? 'Buy Now' : 'Out of Stock' }}
          </button>
          <button @click="goBack" class="btn-back-secondary">
            ← Continue Shopping
          </button>
        </div>
      </section>
    </div>

    <!-- Location Popup Modal -->
    <div v-if="showLocationPopup" class="modal-overlay" @click.self="showLocationPopup = false">
      <div class="modal-content">
        <button class="modal-close" @click="showLocationPopup = false">✕</button>

        <h2>Visit Our Store</h2>
        <p class="modal-subtitle">Order in-store or call ahead to reserve your items</p>

        <div class="location-details">
          <div class="detail-box">
            <h3>📍 Location</h3>
            <p><strong>Istanbul Gourmet Market</strong></p>
            <p>Tecumseh Road</p>
            <p>Windsor, Ontario, Canada</p>
          </div>

          <div class="detail-box">
            <h3>📱 Contact</h3>
            <p>
              <strong><a href="tel:+12262209492" class="phone-link">(226) 220-9492</a></strong>
            </p>
            <p>
              <strong><a href="mailto:info@istanbulgourmet.ca" class="email-link">
                info@istanbulgourmet.ca
              </a></strong>
            </p>
          </div>

          <div class="detail-box">
            <h3>🕐 Hours</h3>
            <ul class="hours-list">
              <li>Mon-Sat: 10:00 AM - 8:00 PM</li>
              <li>Sunday: 11:00 AM - 6:00 PM</li>
            </ul>
          </div>
        </div>

        <div class="modal-actions">
          <a
            href="https://www.google.com/maps/search/Istanbul+Gourmet+Market,+Windsor,+Ontario"
            target="_blank"
            rel="noopener noreferrer"
            class="btn-modal"
          >
            Open in Google Maps
          </a>
          <button @click="showLocationPopup = false" class="btn-modal secondary">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductDetail',
  props: {
    /**
     * Product ID passed from Blade template via :product-id prop
     */
    productId: {
      type: [String, Number],
      required: true,
    },
  },
  data() {
    return {
      product: null,
      loading: false,
      error: null,
      selectedImageIndex: 0,
      showLocationPopup: false,
    };
  },
  mounted() {
    this.fetchProduct();
  },
  methods: {
    /**
     * Fetch product details from API using the product ID from props
     */
    async fetchProduct() {
      this.loading = true;
      this.error = null;

      try {
        const response = await window.axios.get(`/api/products/${this.productId}`);
        this.product = response.data;
      } catch (err) {
        console.error('Error fetching product:', err);
        if (err.response?.status === 404) {
          this.error = 'Product not found.';
        } else {
          this.error = 'Failed to load product details. Please try again.';
        }
      } finally {
        this.loading = false;
      }
    },

    /**
     * Get the current image to display (main or from gallery)
     */
    getCurrentImage() {
      if (this.selectedImageIndex === 0) {
        return this.getImageUrl(this.product.image);
      }
      const imageIndex = this.selectedImageIndex - 1;
      if (this.product.images && this.product.images[imageIndex]) {
        return this.getImageUrl(this.product.images[imageIndex]);
      }
      return this.getImageUrl(this.product.image);
    },

    /**
     * Get full image URL with /storage/ prefix or SVG placeholder
     */
    getImageUrl(imagePath) {
      if (!imagePath) {
        return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="500" height="500"%3E%3Crect fill="%23ddd" width="500" height="500"/%3E%3Ctext fill="%23999" font-size="24" x="50%" y="50%" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
      }
      return `/storage/${imagePath}`;
    },

    /**
     * Navigate back to previous page
     */
    goBack() {
      window.history.back();
    },
  },
};
</script>
