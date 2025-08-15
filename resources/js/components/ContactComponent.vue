<template>
  <section id="contact" class="contact-section">
    <h2>Contact Us</h2>
    <ul>
      <li><strong>Name:</strong> Furkan Kezel</li>
      <li><strong>Phone:</strong> +1 (226) 220-9492</li>
      <li><strong>Email:</strong> furkankezel@gmail.com</li>
    </ul>
  </section>
</template>

<script>
export default {
  name: 'Contact'
}
</script>

<style scoped>
.contact-section {
  padding: 3rem 1rem;
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
  color: #54545c; /* Lettering */
  background-color: #FFF;
}

.contact-section h2 {
  font-size: 2rem;
  color: #f31e45; /* Primary accent */
  margin-bottom: 1.5rem;
}

.contact-section ul {
  list-style: none;
  padding: 0;
  font-size: 1.1rem;
  line-height: 1.6;
}

.contact-section li {
  margin-bottom: 0.7rem;
}
</style>
