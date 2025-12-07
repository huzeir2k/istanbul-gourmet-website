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
  background-color: var(--color-background); /* Background */
  color: var(--color-text); /* Lettering */
  text-align: center;
  padding: 1.5rem 2rem;
  border-top: 2px solid var(--color-secondary); /* Secondary accent */
  font-size: 0.9rem;
  margin-top: auto; /* Stick footer to bottom in flex layout */
  box-shadow: 0 -2px 6px var(--color-shadow); /* Subtle top shadow */
  transition: background-color var(--theme-transition), color var(--theme-transition), border-color var(--theme-transition), box-shadow var(--theme-transition);
}

.app-footer p {
  margin: 0;
}

.app-footer a {
  color: var(--color-primary); /* Primary accent for links */
  text-decoration: none;
  transition: color 0.2s ease;
}

.app-footer a:hover {
  color: var(--color-secondary); /* Secondary accent on hover */
}
</style>

