<script setup>
import logo from '../assets/imgs/istanbul-gourmet-logo.png';
</script>

<template>
  <header class="app-header">
    <nav>
    <div class="logo">
        <img :src="logo" alt="Istanbul Gourmet Logo" />
      </div>
      <ul class="nav-list">
        <li><a href="#" @click.prevent="scrollToTop">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>

    </nav>
  </header>
</template>
<script>
export default {
  name: 'Header',
  methods: {
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  }
}
</script>

<style scoped>

.logo img {
  height: 50px; /* Adjust as needed */
  object-fit: contain;
}

nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.app-header {
  background-color: #FFF; /* Background */
  color: #54545c; /* Lettering */
  padding: 1rem 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Subtle shadow */
  position: sticky;
  top: 0;
  z-index: 1000;
}

.nav-list {
  display: flex;
  gap: 2rem;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-list li a {
  color: #54545c; /* Lettering */
  text-decoration: none;
  font-weight: bold;
  transition: color 0.2s ease, border-bottom 0.2s ease;
  padding-bottom: 4px;
  border-bottom: 2px solid transparent;
}

.nav-list li a:hover {
  color: #f31e45; /* Primary accent on hover */
  border-bottom: 2px solid #f31e45;
}

.nav-list li a.active {
  color: #44c4d4; /* Secondary accent for active page */
  border-bottom: 2px solid #44c4d4;
}
</style>

