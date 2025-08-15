<template>
  <section class="map-section">
    <iframe
      width="100%"
      height="400"
      :src="googleMapsUrl"
      style="border:0;"
      allowfullscreen
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
  </section>
</template>

<script>
export default {
  name: "Map",
  props: { googleMapsUrl: { type: String, required: true } }
};
</script>

<style scoped>
.map-section { margin-top: 3rem; border-radius: 12px; overflow: hidden; border: 2px solid #44c4d4; }
.map-section iframe { width: 100%; height: 400px; border: 0; border-radius: 12px; }
</style>
