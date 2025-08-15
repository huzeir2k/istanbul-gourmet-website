<template>
  <section class="products-section">
    <input
      type="text"
      placeholder="Search products..."
      v-model="searchQuery"
      class="search-bar"
    />

    <div class="product-grid">
      <div v-for="product in filteredProducts" :key="product.id" class="product-card">
        <img :src="product.image" :alt="product.name" />
        <h3>{{ product.name }}</h3>
        <p>${{ product.price.toFixed(2) }}</p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Products",
  props: { products: { type: Array, required: true } },
  data() { return { searchQuery: "" }; },
  computed: {
    filteredProducts() {
      if (!this.searchQuery) return this.products;
      return this.products.filter(p =>
        p.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  }
};
</script>

<style scoped>
/* reuse your products styles here */
.products-section { padding: 2rem 0; }
.search-bar { width: 100%; padding: 0.7rem 1rem; margin-bottom: 1.5rem; font-size: 1rem; border: 2px solid #44c4d4; border-radius: 8px; outline: none; transition: border 0.2s ease; }
.search-bar:focus { border-color: #f31e45; }
.product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; }
.product-card { border: 1px solid #ddd; padding: 1rem; text-align: center; border-radius: 12px; transition: transform 0.2s ease, box-shadow 0.2s ease; background-color: #FFF; }
.product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.product-card img { width: 100%; height: 180px; object-fit: cover; margin-bottom: 0.7rem; border-radius: 8px; }
.product-card h3 { color: #54545c; font-size: 1.1rem; margin-bottom: 0.3rem; }
.product-card p { color: #f31e45; font-weight: bold; font-size: 1rem; }
</style>
