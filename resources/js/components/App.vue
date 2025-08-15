<template>
  <div class="app-container">
    <Header />
    <main class="app-main">
      <Carousel :products="carouselProducts" />
      <Products :products="products" />
      <Map :googleMapsUrl="googleMapsUrl" />
      <AboutComponent />
      <ContactComponent />
    </main>
    <Footer />
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { asset } from '@/helpers/assets';

export default {
  components: {
    Header: defineAsyncComponent(() => import('./Header.vue')),
    Footer: defineAsyncComponent(() => import('./Footer.vue')),
    AboutComponent: defineAsyncComponent(() => import('./AboutComponent.vue')),
    ContactComponent: defineAsyncComponent(() => import('./ContactComponent.vue')),
    CarouselComponent: defineAsyncComponent(() => import('./CarouselComponent.vue')),
    ProductsComponent: defineAsyncComponent(() => import('./ProductsComponent.vue')),
    Map: defineAsyncComponent(() => import('./MapComponent.vue'))
  },
  data() {
    return {
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
      googleMapsUrl: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.123456!2d-82.9454496!3d42.3119021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b2b6a4382947b:0xc8468b6ed42aef04!2sIstanbul+Gourmet+Market!5e0!3m2!1sen!2sca!4v1699999999999"
    };
  }
};
</script>

<style scoped>
.app-container { display: flex; flex-direction: column; min-height: 100vh; }
.app-main { flex: 1; padding: 2rem; background-color: #FFF; color: #54545c; }
</style>
