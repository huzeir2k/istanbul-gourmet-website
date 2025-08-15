<template>
  <footer class="app-footer">
    <p>&copy; 2025 Istanbul Gourmet Shop; All rights reserved.</p>
  </footer>
</template>

<script>
export default {
  name: 'Footer'
}
</script>

<style scoped>
.app-footer {
  background-color: #FFF; /* Background */
  color: #54545c; /* Lettering */
  text-align: center;
  padding: 1.5rem 2rem;
  border-top: 2px solid #44c4d4; /* Secondary accent */
  font-size: 0.9rem;
  margin-top: auto; /* Stick footer to bottom in flex layout */
  box-shadow: 0 -2px 6px rgba(0,0,0,0.05); /* Subtle top shadow */
}

.app-footer p {
  margin: 0;
}

.app-footer a {
  color: #f31e45; /* Primary accent for links */
  text-decoration: none;
  transition: color 0.2s ease;
}

.app-footer a:hover {
  color: #44c4d4; /* Secondary accent on hover */
}
</style>

