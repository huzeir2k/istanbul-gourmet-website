<template>
  <div class="about-page">
    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>About Istanbul Gourmet</h1>
        <p>A Journey of Authentic Flavors</p>
      </div>
    </section>

    <!-- History Section -->
    <section class="history">
      <div class="container">
        <h2>Our Story</h2>
        
        <div class="timeline">
          <!-- 2018 -->
          <div class="timeline-item">
            <div class="timeline-marker">2018</div>
            <div class="timeline-content">
              <h3>The Beginning</h3>
              <p>
                Istanbul Gourmet was founded in 2018 with a passion for bringing authentic Turkish 
                and Mediterranean flavors to the community. What started as a small dream has grown 
                into a beloved local destination for gourmet food enthusiasts.
              </p>
            </div>
          </div>

          <!-- Tecumseh Road Move -->
          <div class="timeline-item">
            <div class="timeline-marker">2023</div>
            <div class="timeline-content">
              <h3>New Location on Tecumseh Road</h3>
              <p>
                We relocated to our current location on Tecumseh Road in Windsor to better serve our growing
                community. Our expanded space allows us to showcase a wider selection of products 
                and provide a more welcoming shopping experience for our valued customers.
              </p>
            </div>
          </div>

          <!-- Events Sponsorship -->
          <div class="timeline-item">
            <div class="timeline-marker">Community</div>
            <div class="timeline-content">
              <h3>Supporting Our Community</h3>
              <p>
                We've been proud sponsors of numerous community events, including Ramadan dinners, 
                Eid breakfasts, and various cultural celebrations. Our commitment to the community 
                goes beyond retail—we believe in building connections and preserving cultural traditions.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Highlights Section -->
    <section class="highlights">
      <div class="container">
        <h2>Why Choose Istanbul Gourmet?</h2>
        
        <div class="highlights-grid">
          <div class="highlight-card">
            <div class="highlight-icon">🌍</div>
            <h3>Authentic Sourcing</h3>
            <p>We carefully source products directly from trusted suppliers in Turkey and the Mediterranean region to ensure authentic flavors and quality.</p>
          </div>

          <div class="highlight-card">
            <div class="highlight-icon">👨‍👩‍👧‍👦</div>
            <h3>Community Driven</h3>
            <p>We're not just a shop—we're part of the community. We sponsor events, support local culture, and build lasting relationships with our customers.</p>
          </div>

          <div class="highlight-card">
            <div class="highlight-icon">✨</div>
            <h3>Quality & Freshness</h3>
            <p>Everything we offer is selected for its quality and freshness. From daily-baked pastries to premium imported specialties, we maintain the highest standards.</p>
          </div>

          <div class="highlight-card">
            <div class="highlight-icon">💚</div>
            <h3>Customer Care</h3>
            <p>Your satisfaction is our priority. Our knowledgeable staff is always ready to help you find exactly what you're looking for or answer any questions.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Key Facts -->
    <section class="key-facts">
      <div class="container">
        <h2>By The Numbers</h2>
        
        <div class="facts-grid">
          <div class="fact-box">
            <div class="fact-number">7+</div>
            <div class="fact-label">Years of Excellence</div>
          </div>
          <div class="fact-box">
            <div class="fact-number">500+</div>
            <div class="fact-label">Products Available</div>
          </div>
          <div class="fact-box">
            <div class="fact-number">1000s</div>
            <div class="fact-label">Happy Customers</div>
          </div>
          <div class="fact-box">
            <div class="fact-number">50+</div>
            <div class="fact-label">Community Events Supported</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
      <div class="container">
        <h2>Visit Us Today</h2>
        <p>Experience authentic Turkish and Mediterranean flavors</p>
        <button @click="navigateTo('/shop')" class="btn-primary">Shop Now</button>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'AboutPage',
  methods: {
    /**
     * Navigate to a specified route
     */
    navigateTo(route) {
      window.location.href = route;
    },
  },
};
</script>
