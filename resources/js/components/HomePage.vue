<template>
  <div class="home-container">
  </div>
</template>

<script>
export default {
  components: {
    Header: () => import('./Header.vue'),
    Footer: () => import('./Footer.vue')
  },
  name: "Home",
  data() {
    return {
      activeIndex: 0,
      searchQuery: "",
      carouselProducts: [
        { name: "Product 1", image: "/images/product1.jpg" },
        { name: "Product 2", image: "/images/product2.jpg" },
        { name: "Product 3", image: "/images/product3.jpg" },
      ],
      products: [
        { id: 1, name: "Apple", price: 12.99, image: "/images/product1.jpg" },
        { id: 2, name: "Banana", price: 9.99, image: "/images/product2.jpg" },
        { id: 3, name: "Cherry", price: 15.99, image: "/images/product3.jpg" },
        { id: 4, name: "Date", price: 7.5, image: "/images/product1.jpg" },
        { id: 5, name: "Eggplant", price: 11.0, image: "/images/product2.jpg" },
      ],
      googleMapsUrl: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.123456!2d-83.032!3d42.314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b8b123456789:0xabcdef123456!2sYour+Shop+Name!5e0!3m2!1sen!2sca!4v1699999999999"
    };
  },
  computed: {
    filteredProducts() {
      if (!this.searchQuery) return this.products;
      return this.products.filter((p) =>
        p.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    nextSlide() {
      this.activeIndex =
        (this.activeIndex + 1) % this.carouselProducts.length;
    },
    prevSlide() {
      this.activeIndex =
        (this.activeIndex - 1 + this.carouselProducts.length) %
        this.carouselProducts.length;
    },
  },
  mounted() {
    // Simple auto-slide every 3 seconds
    setInterval(() => {
      this.nextSlide();
    }, 3000);
  },
};
</script>

<style scoped>
/* General */
.home-container {
  background-color: #FFF; /* Background */
  color: #54545c; /* Lettering */
  font-family: 'Arial', sans-serif;
}

/* Carousel */
.carousel-section {
  position: relative;
  overflow: hidden;
  margin-bottom: 2rem;
  border-radius: 12px;
}

.carousel {
  display: flex;
  position: relative;
  align-items: center;
}

.carousel-item {
  min-width: 100%;
  opacity: 0;
  transition: opacity 0.5s ease;
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 12px;
}

.carousel-item.active {
  opacity: 1;
  position: relative;
}

.carousel-item img {
  width: 100%;
  height: 400px;
  object-fit: cover;
  border-radius: 12px;
}

.carousel-caption {
  position: absolute;
  bottom: 1rem;
  left: 1rem;
  color: #FFF;
  font-weight: bold;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 1.1rem;
}

.carousel button.prev,
.carousel button.next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: #f31e45; /* Primary accent */
  color: #FFF;
  border: none;
  font-size: 2rem;
  padding: 0 0.5rem;
  cursor: pointer;
  z-index: 10;
  border-radius: 50%;
  opacity: 0.8;
  transition: opacity 0.2s ease;
}

.carousel button.prev:hover,
.carousel button.next:hover {
  opacity: 1;
}

.carousel button.prev { left: 1rem; }
.carousel button.next { right: 1rem; }

/* Products Section */
.products-section {
  padding: 2rem 0;
}

.search-bar {
  width: 100%;
  padding: 0.7rem 1rem;
  margin-bottom: 1.5rem;
  font-size: 1rem;
  border: 2px solid #44c4d4; /* Secondary accent */
  border-radius: 8px;
  outline: none;
  transition: border 0.2s ease;
}

.search-bar:focus {
  border-color: #f31e45; /* Primary accent */
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1.5rem;
}

.product-card {
  border: 1px solid #ddd;
  padding: 1rem;
  text-align: center;
  border-radius: 12px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  background-color: #FFF;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.product-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  margin-bottom: 0.7rem;
  border-radius: 8px;
}

.product-card h3 {
  color: #54545c; /* Lettering */
  font-size: 1.1rem;
  margin-bottom: 0.3rem;
}

.product-card p {
  color: #f31e45; /* Primary accent for price */
  font-weight: bold;
  font-size: 1rem;
}

/* Map Section */
.map-section {
  margin-top: 3rem;
  border-radius: 12px;
  overflow: hidden;
  border: 2px solid #44c4d4; /* Secondary accent border */
}

/* Optional: Make map responsive */
.map-section iframe {
  width: 100%;
  height: 400px;
  border: 0;
  border-radius: 12px;
}
</style>

