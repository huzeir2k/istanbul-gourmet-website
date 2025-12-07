<template>
  <div class="contact-page">
    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you!</p>
      </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-info-section">
      <div class="container">
        <div class="info-grid">
          <!-- Address -->
          <div class="info-card">
            <div class="info-icon">📍</div>
            <h3>Our Location</h3>
            <p><strong>Istanbul Gourmet Market</strong></p>
            <p>Tecumseh Road</p>
            <p>Windsor, Ontario, Canada</p>
          </div>

          <!-- Phone -->
          <div class="info-card">
            <div class="info-icon">📱</div>
            <h3>Call Us</h3>
            <p>
              <a href="tel:+12262209492" class="contact-link">(226) 220-9492</a>
            </p>
            <p class="text-muted">Available during store hours</p>
          </div>

          <!-- Email -->
          <div class="info-card">
            <div class="info-icon">✉️</div>
            <h3>Email Us</h3>
            <p>
              <a href="mailto:info@istanbulgourmet.ca" class="contact-link">info@istanbulgourmet.ca</a>
            </p>
            <p class="text-muted">We'll respond within 24 hours</p>
          </div>

          <!-- Hours -->
          <div class="info-card">
            <div class="info-icon">🕐</div>
            <h3>Store Hours</h3>
            <ul class="hours-list">
              <li><span>Monday - Saturday:</span> <strong>10:00 AM - 8:00 PM</strong></li>
              <li><span>Sunday:</span> <strong>11:00 AM - 6:00 PM</strong></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
      <div class="container">
        <h2>Find Us On The Map</h2>
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2946.8894844445776!2d-82.9454712!3d42.3119234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b2b6a4382947b:0xc8468b6ed42aef04!2sIstanbul+Gourmet+Market!5e0!3m2!1sen!2sca!4v1234567890"
            width="100%"
            height="400"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
      <div class="container">
        <h2>Send Us A Message</h2>
        <p class="form-subtitle">Have questions? Fill out the form below and we'll get back to you soon.</p>

        <form @submit.prevent="submitForm" class="contact-form">
          <!-- Name Field -->
          <div class="form-group">
            <label for="name">Full Name *</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              placeholder="Enter your full name"
              class="form-input"
            />
            <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
          </div>

          <!-- Email Field -->
          <div class="form-group">
            <label for="email">Email Address *</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              placeholder="Enter your email address"
              class="form-input"
            />
            <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
          </div>

          <!-- Phone Field -->
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              placeholder="Enter your phone number"
              class="form-input"
            />
          </div>

          <!-- Subject Field -->
          <div class="form-group">
            <label for="subject">Subject *</label>
            <input
              id="subject"
              v-model="form.subject"
              type="text"
              required
              placeholder="What is this about?"
              class="form-input"
            />
            <span v-if="errors.subject" class="error-message">{{ errors.subject }}</span>
          </div>

          <!-- Message Field -->
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea
              id="message"
              v-model="form.message"
              required
              placeholder="Please share your message or inquiry..."
              class="form-textarea"
              rows="6"
            ></textarea>
            <span v-if="errors.message" class="error-message">{{ errors.message }}</span>
          </div>

          <!-- Submission Status -->
          <div v-if="submitStatus === 'success'" class="success-message">
            ✓ Thank you for your message! We'll be in touch soon.
          </div>
          <div v-else-if="submitStatus === 'error'" class="error-message-block">
            ✗ Sorry, there was an error sending your message. Please try again.
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-submit" :disabled="submitting">
            {{ submitting ? 'Sending...' : 'Send Message' }}
          </button>
        </form>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'ContactPage',
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: '',
      },
      errors: {},
      submitting: false,
      submitStatus: null, // 'success', 'error', or null
    };
  },
  methods: {
    /**
     * Validate form inputs
     */
    validateForm() {
      this.errors = {};

      if (!this.form.name.trim()) {
        this.errors.name = 'Name is required';
      }

      if (!this.form.email.trim()) {
        this.errors.email = 'Email is required';
      } else if (!this.isValidEmail(this.form.email)) {
        this.errors.email = 'Please enter a valid email address';
      }

      if (!this.form.subject.trim()) {
        this.errors.subject = 'Subject is required';
      }

      if (!this.form.message.trim()) {
        this.errors.message = 'Message is required';
      }

      return Object.keys(this.errors).length === 0;
    },

    /**
     * Validate email format
     */
    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    },

    /**
     * Submit the contact form
     * Note: This is a frontend-only implementation
     * For production, you'd want to create a backend endpoint
     */
    async submitForm() {
      this.submitStatus = null;

      if (!this.validateForm()) {
        return;
      }

      this.submitting = true;

      try {
        // Simulate sending the message
        // In production, this would POST to a contact endpoint
        await new Promise((resolve) => setTimeout(resolve, 1000));

        // Success
        this.submitStatus = 'success';
        this.form = {
          name: '',
          email: '',
          phone: '',
          subject: '',
          message: '',
        };

        // Clear success message after 5 seconds
        setTimeout(() => {
          this.submitStatus = null;
        }, 5000);
      } catch (err) {
        console.error('Error submitting form:', err);
        this.submitStatus = 'error';
      } finally {
        this.submitting = false;
      }
    },
  },
};
</script>
