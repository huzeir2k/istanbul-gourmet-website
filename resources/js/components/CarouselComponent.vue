<template>
  <section class="carousel-section">
    <div class="carousel">
      <div
        v-for="(product, index) in products"
        :key="index"
        class="carousel-item"
        :class="{ active: index === activeIndex }"
      >
        <img :src="product.image" :alt="product.name" />
        <div class="carousel-caption">{{ product.name }}</div>
      </div>

      <!-- Carousel controls -->
      <button class="prev" @click="prevSlide">&#10094;</button>
      <button class="next" @click="nextSlide">&#10095;</button>
    </div>
  </section>
</template>

<script>
export default {
  name: "Carousel",
  props: {
    products: { type: Array, required: true }
  },
  data() {
    return { activeIndex: 0 };
  },
  methods: {
    nextSlide() {
      this.activeIndex = (this.activeIndex + 1) % this.products.length;
    },
    prevSlide() {
      this.activeIndex =
        (this.activeIndex - 1 + this.products.length) % this.products.length;
    }
  },
  mounted() {
    setInterval(() => this.nextSlide(), 3000);
  }
};
</script>

<style scoped>
/* reuse your carousel styles here */
.carousel-section { position: relative; overflow: hidden; margin-bottom: 2rem; border-radius: 12px; }
.carousel { display: flex; position: relative; align-items: center; }
.carousel-item { min-width: 100%; opacity: 0; transition: opacity 0.5s ease; position: absolute; top: 0; left: 0; border-radius: 12px; }
.carousel-item.active { opacity: 1; position: relative; }
.carousel-item img { width: 100%; height: 400px; object-fit: cover; border-radius: 12px; }
.carousel-caption { position: absolute; bottom: 1rem; left: 1rem; color: #FFF; font-weight: bold; background-color: rgba(0,0,0,0.5); padding: 0.5rem 1rem; border-radius: 8px; font-size: 1.1rem; }
.carousel button.prev, .carousel button.next { position: absolute; top: 50%; transform: translateY(-50%); background-color: #f31e45; color: #FFF; border: none; font-size: 2rem; padding: 0 0.5rem; cursor: pointer; z-index: 10; border-radius: 50%; opacity: 0.8; transition: opacity 0.2s ease; }
.carousel button.prev:hover, .carousel button.next:hover { opacity: 1; }
.carousel button.prev { left: 1rem; }
.carousel button.next { right: 1rem; }
</style>
