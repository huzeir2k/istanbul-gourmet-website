<script setup>
import logo from '../assets/imgs/istanbul-gourmet-logo.png';
</script>

<template>
  <header class="app-header" role="banner">
    <nav role="navigation" aria-label="Main navigation">
      <div class="logo">
        <a href="/" @click.prevent="navigate('/')" aria-label="Istanbul Gourmet - Home">
          <img :src="logo" alt="Istanbul Gourmet Market Logo" />
        </a>
      </div>

      <!-- Hamburger Menu Button (mobile only, when menu is closed) -->
      <button 
        v-if="!showMobileMenu"
        class="hamburger-menu" 
        @click="showMobileMenu = true"
        aria-label="Open menu"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>

      <!-- Desktop Nav + Mobile Modal -->
      <div class="nav-wrapper" :class="{ active: showMobileMenu }">
        <!-- Close Button (Mobile Only - Only visible when menu is open) -->
        <button 
          v-if="showMobileMenu"
          class="modal-close" 
          @click="showMobileMenu = false"
          aria-label="Close menu"
        >
          ✕
        </button>

        <ul class="nav-list" role="menubar">
          <li role="none"><a href="/" @click.prevent="navigate('/')" role="menuitem" :aria-current="isActive('/') ? 'page' : false">Home</a></li>
          <li role="none"><a href="/shop" @click.prevent="navigate('/shop')" role="menuitem" :aria-current="isActive('/shop') ? 'page' : false">Shop</a></li>
          <li role="none"><a href="/about" @click.prevent="navigate('/about')" role="menuitem" :aria-current="isActive('/about') ? 'page' : false">About</a></li>
          <li role="none"><a href="/contact" @click.prevent="navigate('/contact')" role="menuitem" :aria-current="isActive('/contact') ? 'page' : false">Contact</a></li>
        </ul>

        <!-- Dark Mode Toggle in Modal -->
        <button 
          @click="toggleDarkMode" 
          class="dark-mode-toggle" 
          :aria-label="darkModeLabel"
          :title="darkModeLabel"
        >
          <span class="toggle-icon">{{ darkModeIcon }}</span>
          <span class="toggle-text">{{ darkModeText }}</span>
        </button>
      </div>

      <!-- Dark Mode Toggle (desktop only) -->
      <button 
        @click="toggleDarkMode" 
        class="dark-mode-toggle desktop-only" 
        :aria-label="darkModeLabel"
        :title="darkModeLabel"
      >
        <span class="toggle-icon">{{ darkModeIcon }}</span>
      </button>
    </nav>

    <!-- Mobile Menu Backdrop -->
    <div v-if="showMobileMenu" class="nav-backdrop" @click="showMobileMenu = false"></div>
  </header>
</template>

<script>
import { toggleDarkMode, getDarkModeOverride } from '../services/themeService.js';

export default {
  name: 'Header',
  data() {
    return {
      darkModeOverride: null,
      showMobileMenu: false,
    };
  },
  computed: {
    darkModeIcon() {
      const override = this.darkModeOverride;
      if (override === true) return '🌙'; // Dark mode active
      if (override === false) return '☀️'; // Light mode active
      return '⚙️'; // Auto mode
    },
    darkModeLabel() {
      const override = this.darkModeOverride;
      if (override === true) return 'Dark Mode - Click for Light Mode';
      if (override === false) return 'Light Mode - Click for Auto';
      return 'Auto Mode - Click for Dark Mode';
    },
    darkModeText() {
      const override = this.darkModeOverride;
      if (override === true) return 'Dark Mode';
      if (override === false) return 'Light Mode';
      return 'Auto Mode';
    },
  },
  mounted() {
    this.darkModeOverride = getDarkModeOverride();
    window.addEventListener('themeChange', this.handleThemeChange);
  },
  beforeUnmount() {
    window.removeEventListener('themeChange', this.handleThemeChange);
  },
  methods: {
    /**
     * Navigate to a page and update the URL
     */
    navigate(path) {
      this.showMobileMenu = false; // Close menu on navigation
      window.history.pushState({}, '', path);
      // Trigger popstate event to update App component
      window.dispatchEvent(new PopStateEvent('popstate'));
    },
    /**
     * Check if a path is currently active
     */
    isActive(path) {
      return window.location.pathname === path || (path === '/' && window.location.pathname === '');
    },
    /**
     * Toggle dark mode and update local state
     */
    toggleDarkMode() {
      toggleDarkMode();
      this.darkModeOverride = getDarkModeOverride();
    },
    /**
     * Handle theme change event from theme service
     */
    handleThemeChange(event) {
      this.darkModeOverride = event.detail.darkModeOverride;
    },
  },
};
</script>

<style scoped>
.logo img {
  height: 50px;
  object-fit: contain;
}

.logo a {
  display: flex;
  align-items: center;
  text-decoration: none;
}

nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 2rem;
}

.app-header {
  background-color: var(--color-background);
  color: var(--color-text);
  padding: 1rem 2rem;
  box-shadow: 0 2px 8px var(--color-shadow);
  position: sticky;
  top: 0;
  z-index: 1000;
  transition: background-color var(--theme-transition), color var(--theme-transition), box-shadow var(--theme-transition);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nav-list {
  display: flex;
  gap: 2rem;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-list a {
  text-decoration: none;
  color: var(--color-text);
  font-weight: 600;
  transition: color 0.3s ease;
}

.nav-list a:hover {
  color: var(--color-primary);
}

.nav-list li a {
  color: var(--color-text); /* Lettering */
  text-decoration: none;
  font-weight: bold;
  transition: color 0.2s ease, border-bottom 0.2s ease;
  padding-bottom: 4px;
  border-bottom: 2px solid transparent;
}

.nav-list li a:hover {
  color: var(--color-primary); /* Primary accent on hover */
  border-bottom: 2px solid var(--color-primary);
}

.nav-list li a.active {
  color: var(--color-secondary); /* Secondary accent for active page */
  border-bottom: 2px solid var(--color-secondary);
}

/* Dark Mode Toggle Button */
.dark-mode-toggle {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.5rem;
  padding: 0.5rem;
  margin-left: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background-color 0.3s ease, transform 0.2s ease;
  color: var(--color-text);
}

.dark-mode-toggle:hover {
  background-color: var(--color-light-bg);
  transform: scale(1.1);
}

.dark-mode-toggle:focus {
  outline: 3px solid var(--color-primary);
  outline-offset: 2px;
}

.toggle-icon {
  display: inline-block;
  transition: transform 0.3s ease;
}

.dark-mode-toggle:active .toggle-icon {
  transform: rotate(20deg);
}

/* Hamburger Menu Button */
.hamburger-menu {
  display: none;
  flex-direction: column;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  gap: 5px;
  margin-left: auto;
  z-index: 1001;
}

.hamburger-menu span {
  width: 28px;
  height: 3px;
  background-color: var(--color-text);
  border-radius: 2px;
  transition: transform 0.3s ease, opacity 0.3s ease, background-color 0.3s ease;
  display: block;
}

.hamburger-menu:hover span {
  background-color: var(--color-primary);
}

/* Navigation Wrapper Modal */
.nav-wrapper {
  position: fixed;
  top: 0;
  right: -300px;
  width: 300px;
  height: 100vh;
  background-color: var(--color-background);
  box-shadow: -2px 0 8px var(--color-shadow);
  z-index: 999;
  transition: right 0.3s ease;
  overflow-y: auto;
  padding: 1rem 0;
}

.nav-wrapper.active {
  right: 0;
}

/* Modal Close Button */
.modal-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--color-text);
  padding: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  transition: background-color 0.2s ease, color 0.2s ease;
  z-index: 1002;
}

.modal-close:hover {
  background-color: var(--color-light-bg);
  color: var(--color-primary);
}

.modal-close:focus {
  outline: 3px solid var(--color-primary);
  outline-offset: 2px;
}

.nav-wrapper nav {
  flex-direction: column;
  gap: 0;
  padding: 0;
}

.nav-wrapper .nav-list {
  flex-direction: column;
  gap: 0;
  width: 100%;
}

.nav-wrapper .nav-list li {
  border-bottom: 1px solid var(--color-light-bg);
}

.nav-wrapper .nav-list li a {
  display: block;
  padding: 1rem;
  color: var(--color-text);
  text-decoration: none;
  font-weight: 600;
  transition: color 0.2s ease, background-color 0.2s ease;
  border: none;
}

.nav-wrapper .nav-list li a:hover {
  background-color: var(--color-light-bg);
  color: var(--color-primary);
  border: none;
}

.nav-wrapper .nav-list li a.active {
  background-color: var(--color-light-bg);
  color: var(--color-secondary);
  border: none;
}

/* Dark Mode Toggle in Mobile Menu */
.nav-wrapper .dark-mode-toggle {
  width: 100%;
  margin: 1rem 0;
  justify-content: flex-start;
  padding: 1rem;
  border-radius: 0;
  background-color: transparent;
  font-size: 1rem;
  gap: 0.5rem;
}

.nav-wrapper .dark-mode-toggle:hover {
  background-color: var(--color-light-bg);
  transform: none;
}

.nav-wrapper .dark-mode-toggle span {
  flex-grow: 1;
  text-align: left;
  font-weight: 600;
  color: var(--color-text);
}

.nav-wrapper .dark-mode-toggle .toggle-icon {
  font-size: 1.5rem;
  margin-right: 0.5rem;
  order: -1;
}

/* Navigation Backdrop Overlay */
.nav-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 998;
  opacity: 1;
  transition: opacity 0.3s ease;
}

/* Desktop: Show nav inline, hide hamburger */
@media (min-width: 769px) {
  .hamburger-menu {
    display: none !important;
  }

  .modal-close {
    display: none;
  }

  .nav-wrapper {
    position: static;
    max-width: 100%;
    height: auto;
    width: auto;
    background-color: transparent;
    box-shadow: none;
    padding: 0;
    right: 0;
    overflow: visible;
    display: flex;
    align-items: center;
    gap: 2rem;
    justify-content: center;
  }

  .nav-wrapper.active {
    right: 0;
  }

  .nav-wrapper nav {
    flex-direction: row;
    gap: 2rem;
    width: auto;
  }

  .nav-wrapper .nav-list {
    flex-direction: row;
    gap: 2rem;
  }

  .nav-wrapper .nav-list li {
    border-bottom: none;
  }

  .nav-wrapper .nav-list li a {
    padding: 0;
    border-bottom: 2px solid transparent;
    transition: color 0.2s ease, border-bottom 0.2s ease;
  }

  .nav-wrapper .nav-list li a:hover {
    background-color: transparent;
    color: var(--color-primary);
    border-bottom: 2px solid var(--color-primary);
  }

  .nav-wrapper .nav-list li a.active {
    background-color: transparent;
    color: var(--color-secondary);
    border-bottom: 2px solid var(--color-secondary);
  }

  .nav-wrapper .dark-mode-toggle {
    position: static;
    width: auto;
    margin: 0;
    padding: 0.5rem;
    font-size: 1.5rem;
    justify-content: center;
    display: flex;
    background: none;
    border: none;
  }

  .nav-wrapper .dark-mode-toggle span {
    display: none;
  }

  .nav-wrapper .dark-mode-toggle .toggle-icon {
    margin: 0;
    order: 0;
  }

  .nav-backdrop {
    display: none;
  }
}

/* Mobile: Show hamburger, hide nav inline */
@media (max-width: 768px) {
  .hamburger-menu {
    display: flex;
  }

  .app-header {
    flex-wrap: wrap;
  }

  nav {
    width: 100%;
    gap: 0;
  }

  .nav-wrapper {
    position: fixed;
    right: -300px;
    width: 300px;
    padding-top: 0;
  }

  .logo {
    flex: 1;
  }

  .desktop-only {
    display: none;
  }

  .modal-close {
    display: flex;
  }
}
</style>




