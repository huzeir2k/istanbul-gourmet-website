<template>
  <div class="shop-page">
    <!-- Page Header -->
    <section class="page-header">
      <h1>Our Shop</h1>
      <p>Browse our full selection of authentic Turkish & Mediterranean products</p>
    </section>

    <!-- Filters and Search -->
    <section class="filters-section">
      <div class="container">
        <!-- Mobile Filter Toggle Button -->
        <button class="filter-toggle-btn" @click="showFilters = !showFilters" aria-label="Toggle Filters">
          <span class="filter-icon">⚙️</span>
          {{ showFilters ? 'Hide Filters' : 'Show Filters' }}
        </button>

        <!-- Filters Container (stacked on mobile, modal overlay) -->
        <div class="filters-container" :class="{ active: showFilters }">
          <div class="filters-grid">
            <!-- Search Bar -->
            <div class="filter-group">
              <label for="search">Search Products</label>
              <input
                id="search"
                v-model="searchQuery"
                type="text"
                placeholder="Search by name, SKU, or description..."
                class="search-input"
                @input="applyFilters"
              />
            </div>

            <!-- Category Filter -->
            <div class="filter-group">
              <label for="category">Category</label>
              <select id="category" v-model="selectedCategory" class="select-input" @change="applyFilters">
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>

            <!-- Brand Filter -->
            <div class="filter-group">
              <label for="brand">Brand</label>
              <select id="brand" v-model="selectedBrand" class="select-input" @change="applyFilters">
                <option value="">All Brands</option>
                <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                  {{ brand.name }}
                </option>
              </select>
            </div>

            <!-- Price Range Filter -->
            <div class="filter-group">
              <label for="price-range">Price Range: ${{ minPrice }} - ${{ maxPrice }}</label>
              <div class="price-inputs">
                <input
                  id="min-price"
                  v-model.number="minPrice"
                  type="number"
                  placeholder="Min"
                  class="price-input"
                  @input="applyFilters"
                />
                <span>to</span>
                <input
                  id="max-price"
                  v-model.number="maxPrice"
                  type="number"
                  placeholder="Max"
                  class="price-input"
                  @input="applyFilters"
                />
              </div>
            </div>

            <!-- Sort By -->
            <div class="filter-group">
              <label for="sort">Sort By</label>
              <select id="sort" v-model="sortBy" class="select-input" @change="applyFilters">
                <option value="name">Name (A-Z)</option>
                <option value="price_cents">Price (Low to High)</option>
                <option value="created_at">Newest First</option>
              </select>
            </div>
          </div>

          <!-- Reset Filters Button -->
          <button @click="resetFilters" class="btn-reset">Reset Filters</button>
        </div>

        <!-- Mobile Backdrop -->
        <div v-if="showFilters" class="filters-backdrop" @click="showFilters = false"></div>
      </div>
    </section>

    <!-- Products Display -->
    <section class="products-section">
      <div class="container">
        <!-- Loading State -->
        <div v-if="loading" class="state-message loading-state">
          <p>Loading products...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="state-message error-state">
          <p>{{ error }}</p>
        </div>

        <!-- Empty State -->
        <div v-else-if="products.length === 0" class="state-message empty-state">
          <p>No products match your filters. Try adjusting your search.</p>
        </div>

        <!-- Products Grid -->
        <div v-else class="products-grid">
          <div v-for="product in products" :key="product.id" class="product-card">
            <div class="product-image-wrapper">
              <img :src="getImageUrl(product)" :alt="product.name" class="product-image" />
              <span v-if="product.category" class="category-badge">{{ product.category.name }}</span>
            </div>

            <div class="product-content">
              <h3 class="product-name">{{ product.name }}</h3>
              <p class="product-description">{{ product.short_description }}</p>

              <div class="product-meta">
                <span v-if="product.brand" class="brand-tag">{{ product.brand.name }}</span>
                <span v-if="product.sku" class="sku-tag">SKU: {{ product.sku }}</span>
              </div>

              <div class="product-pricing">
                <div class="price-info">
                  <span class="label">Price:</span>
                  <span class="price-with-tax">CAD${{ product.price_with_tax }} (after tax)</span>
                </div>
              </div>

              <div class="stock-info">
                <span v-if="product.stock > 0" class="in-stock">
                  ✓ In Stock ({{ product.stock }} available)
                </span>
                <span v-else class="out-of-stock">Out of Stock</span>
              </div>

              <button
                @click="viewProduct(product.id)"
                class="btn-view-details"
                :disabled="product.stock === 0"
              >
                View Details
              </button>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1 && products.length > 0" class="pagination">
          <button
            @click="previousPage"
            :disabled="currentPage === 1"
            class="btn-pagination"
          >
            ← Previous
          </button>

          <div class="page-info">
            Page {{ currentPage }} of {{ totalPages }}
          </div>

          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="btn-pagination"
          >
            Next →
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'ShopPage',
  data() {
    return {
      // Product data
      products: [],
      categories: [],
      brands: [],

      // Filter state
      searchQuery: '',
      selectedCategory: '',
      selectedBrand: '',
      minPrice: 0,
      maxPrice: 100,

      // Sorting and pagination
      sortBy: 'name',
      currentPage: 1,
      perPage: 12,
      totalPages: 1,

      // UI state
      loading: false,
      error: null,
      showFilters: false,
    };
  },

  mounted() {
    // Fetch categories, brands, and initial products
    this.fetchCategories();
    this.fetchBrands();
    this.fetchProducts();
  },

  methods: {
    /**
     * Fetch all categories from API
     */
    async fetchCategories() {
      try {
        // Note: You may need to create a categories endpoint
        // For now, we'll extract them from products
        const response = await window.axios.get('/api/products', { params: { per_page: 100 } });
        const uniqueCategories = new Map();

        response.data.data.forEach((product) => {
          if (product.category && !uniqueCategories.has(product.category.id)) {
            uniqueCategories.set(product.category.id, product.category);
          }
        });

        this.categories = Array.from(uniqueCategories.values());
      } catch (err) {
        console.error('Error fetching categories:', err);
      }
    },

    /**
     * Fetch all brands from API
     */
    async fetchBrands() {
      try {
        // Note: You may need to create a brands endpoint
        // For now, we'll extract them from products
        const response = await window.axios.get('/api/products', { params: { per_page: 100 } });
        const uniqueBrands = new Map();

        response.data.data.forEach((product) => {
          if (product.brand && !uniqueBrands.has(product.brand.id)) {
            uniqueBrands.set(product.brand.id, product.brand);
          }
        });

        this.brands = Array.from(uniqueBrands.values());
      } catch (err) {
        console.error('Error fetching brands:', err);
      }
    },

    /**
     * Fetch products with current filters applied
     */
    async fetchProducts() {
      this.loading = true;
      this.error = null;

      try {
        const params = {
          per_page: this.perPage,
          page: this.currentPage,
          sort_by: this.sortBy,
          sort_order: this.sortBy === 'price_cents' ? 'asc' : 'asc',
        };

        // Add optional filters if they're set
        if (this.searchQuery) params.q = this.searchQuery;
        if (this.selectedCategory) params.category_id = this.selectedCategory;
        if (this.selectedBrand) params.brand_id = this.selectedBrand;
        if (this.minPrice > 0) params.min_price = this.minPrice;
        if (this.maxPrice < 999) params.max_price = this.maxPrice;

        const response = await window.axios.get('/api/products', { params });

        this.products = response.data.data || [];
        this.totalPages = response.data.last_page || 1;
        this.currentPage = response.data.current_page || 1;
      } catch (err) {
        console.error('Error fetching products:', err);
        this.error = 'Failed to load products. Please try again.';
      } finally {
        this.loading = false;
      }
    },

    /**
     * Apply current filter settings and fetch products
     * Resets to page 1 when filters change
     */
    applyFilters() {
      this.currentPage = 1;
      this.fetchProducts();
    },

    /**
     * Reset all filters to default values
     */
    resetFilters() {
      this.searchQuery = '';
      this.selectedCategory = '';
      this.selectedBrand = '';
      this.minPrice = 0;
      this.maxPrice = 100;
      this.sortBy = 'name';
      this.currentPage = 1;
      this.fetchProducts();
    },

    /**
     * Get image URL with fallback
     */
    getImageUrl(product) {
      if (product.image) {
        return `/storage/${product.image}`;
      }
      return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="300" height="300"%3E%3Crect fill="%23ddd" width="300" height="300"/%3E%3Ctext fill="%23999" font-size="16" x="50%" y="50%" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
    },

    /**
     * Navigate to product detail page
     */
    viewProduct(productId) {
      window.location.href = `/products/${productId}`;
    },

    /**
     * Pagination: go to next page
     */
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    },

    /**
     * Pagination: go to previous page
     */
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    },
  },
};
</script>
