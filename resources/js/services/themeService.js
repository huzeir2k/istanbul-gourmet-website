/**
 * Theme Service for managing day/night themes with sunset/sunrise transitions
 * Brand Colors: #f31e45 (red), #44c4d4 (cyan), white
 */

// Windsor, Ontario coordinates for sunset/sunrise calculations
const LOCATION = {
  latitude: 42.3119234,
  longitude: -82.9454712,
  timezone: 'America/Toronto'
};

// Manual dark mode override (null = auto, true = dark, false = light)
let manualDarkModeOverride = localStorage.getItem('darkModeOverride') 
  ? JSON.parse(localStorage.getItem('darkModeOverride'))
  : null;

// Day theme colors
export const DAY_THEME = {
  primary: '#f31e45',      // Red
  secondary: '#44c4d4',    // Cyan
  background: '#ffffff',   // White
  text: '#54545c',         // Dark gray text
  lightBg: '#f5f5f5',      // Light gray bg
  border: '#e0e0e0',       // Light border
  shadow: 'rgba(0, 0, 0, 0.05)',
  accentDark: '#c91433',   // Darker red
  accentLight: '#2eaaba'   // Darker cyan
};

// Dark theme colors (night mode)
export const NIGHT_THEME = {
  primary: '#ff6b7a',      // Lighter red for dark mode
  secondary: '#5dd4e4',    // Lighter cyan for dark mode
  background: '#1a1a1a',   // Dark background
  text: '#e0e0e0',         // Light text
  lightBg: '#2a2a2a',      // Dark gray bg
  border: '#3a3a3a',       // Dark border
  shadow: 'rgba(0, 0, 0, 0.3)',
  accentDark: '#ff4461',   // Lighter dark red
  accentLight: '#3dd9e8'   // Lighter cyan
};

// Transition theme (used during sunrise/sunset)
export const getTransitionTheme = (progress) => {
  // progress: 0 = day, 0.5 = twilight, 1 = night
  const lerp = (a, b, t) => a + (b - a) * t;
  
  const dayHex = (hex) => parseInt(hex.slice(1), 16);
  const hexColor = (r, g, b) => `#${Math.round(r).toString(16).padStart(2, '0')}${Math.round(g).toString(16).padStart(2, '0')}${Math.round(b).toString(16).padStart(2, '0')}`;

  return {
    primary: interpolateColor(DAY_THEME.primary, NIGHT_THEME.primary, progress),
    secondary: interpolateColor(DAY_THEME.secondary, NIGHT_THEME.secondary, progress),
    background: interpolateColor(DAY_THEME.background, NIGHT_THEME.background, progress),
    text: interpolateColor(DAY_THEME.text, NIGHT_THEME.text, progress),
    lightBg: interpolateColor(DAY_THEME.lightBg, NIGHT_THEME.lightBg, progress),
    border: interpolateColor(DAY_THEME.border, NIGHT_THEME.border, progress),
  };
};

// Helper function to interpolate between colors
const interpolateColor = (color1, color2, t) => {
  const rgb1 = hexToRgb(color1);
  const rgb2 = hexToRgb(color2);
  
  const r = Math.round(rgb1.r + (rgb2.r - rgb1.r) * t);
  const g = Math.round(rgb1.g + (rgb2.g - rgb1.g) * t);
  const b = Math.round(rgb1.b + (rgb2.b - rgb1.b) * t);
  
  return `rgb(${r}, ${g}, ${b})`;
};

const hexToRgb = (hex) => {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : { r: 255, g: 255, b: 255 };
};

/**
 * Calculate sunrise and sunset times for Windsor, Ontario
 * Using simplified algorithm based on solar geometry
 */
const calculateSunTimes = (date = new Date()) => {
  const J2000 = 2451545;
  const JDate = date.getTime() / 86400000 + 2440587.5 - J2000;
  
  const n = JDate + 0.0008;
  const J = n - (LOCATION.longitude / 360);
  
  const M = (357.5291 + 0.98560028 * J) % 360;
  const M_rad = (M * Math.PI) / 180;
  
  const C = (1.9425 - 0.004817 * Math.cos(M_rad) - 0.014615 * Math.cos(2 * M_rad)) * Math.sin(M_rad);
  const lambda = (280.4665 + 0.98564736 * J + C) % 360;
  
  const JTransit = 2451545 + J + 0.0053 * Math.sin(M_rad) - 0.0069 * Math.sin(2 * ((lambda * Math.PI) / 180));
  
  const delta_rad = Math.asin(Math.sin(((lambda * Math.PI) / 180)) * Math.sin((23.4393 * Math.PI) / 180));
  
  const H = Math.acos(-Math.tan((LOCATION.latitude * Math.PI) / 180) * Math.tan(delta_rad)) / (Math.PI / 180);
  
  const JRise = JTransit - H / 360;
  const JSet = JTransit + H / 360;
  
  const sunriseMs = (JRise - 2440587.5) * 86400000;
  const sunsetMs = (JSet - 2440587.5) * 86400000;
  
  const sunrise = new Date(sunriseMs);
  const sunset = new Date(sunsetMs);
  
  return { sunrise, sunset };
};

/**
 * Get current theme based on time of day
 * Smooth transition during sunrise/sunset (1 hour before/after)
 * Respects manual dark mode override
 */
export const getCurrentTheme = (date = new Date()) => {
  // If manual override is active, return that theme
  if (manualDarkModeOverride === true) {
    return { theme: NIGHT_THEME, isDayMode: false, progress: 1 };
  } else if (manualDarkModeOverride === false) {
    return { theme: DAY_THEME, isDayMode: true, progress: 0 };
  }
  
  // Otherwise, use automatic time-based theme
  const { sunrise, sunset } = calculateSunTimes(date);
  const now = date.getTime();
  
  const TRANSITION_DURATION = 3600000; // 1 hour in milliseconds
  
  let progress = 0; // 0 = day, 1 = night
  
  if (now < sunrise.getTime()) {
    // Before sunrise - dark mode with transition
    const timeTillSunrise = sunrise.getTime() - now;
    if (timeTillSunrise < TRANSITION_DURATION) {
      progress = 1 - (timeTillSunrise / TRANSITION_DURATION);
    } else {
      progress = 1; // Full night mode
    }
  } else if (now >= sunrise.getTime() && now < sunrise.getTime() + TRANSITION_DURATION) {
    // Sunrise transition
    const timeSinceSunrise = now - sunrise.getTime();
    progress = 1 - (timeSinceSunrise / TRANSITION_DURATION);
  } else if (now >= sunrise.getTime() + TRANSITION_DURATION && now < sunset.getTime() - TRANSITION_DURATION) {
    // Day mode
    progress = 0;
  } else if (now >= sunset.getTime() - TRANSITION_DURATION && now < sunset.getTime()) {
    // Sunset transition
    const timeSinceSunsetStart = now - (sunset.getTime() - TRANSITION_DURATION);
    progress = timeSinceSunsetStart / TRANSITION_DURATION;
  } else {
    // Night mode
    progress = 1;
  }
  
  // Clamp progress between 0 and 1
  progress = Math.max(0, Math.min(1, progress));
  
  if (progress === 0) {
    return { theme: DAY_THEME, isDayMode: true, progress };
  } else if (progress === 1) {
    return { theme: NIGHT_THEME, isDayMode: false, progress };
  } else {
    return { theme: getTransitionTheme(progress), isDayMode: progress < 0.5, progress };
  }
};

/**
 * Apply theme to document
 */
export const applyTheme = (theme) => {
  const root = document.documentElement;
  
  Object.entries(theme).forEach(([key, value]) => {
    // Convert camelCase to kebab-case for CSS variables
    const cssVar = `--color-${key.replace(/([A-Z])/g, '-$1').toLowerCase()}`;
    root.style.setProperty(cssVar, value);
  });
};

/**
 * Initialize theme system with updates
 */
export const initThemeSystem = (updateInterval = 60000) => {
  // Initial theme application
  const { theme } = getCurrentTheme();
  applyTheme(theme);
  
  // Update theme periodically
  setInterval(() => {
    const { theme } = getCurrentTheme();
    applyTheme(theme);
  }, updateInterval);
};

/**
 * Watch for theme changes and call callback
 */
export const watchTheme = (callback, checkInterval = 60000) => {
  let lastProgress = -1;
  
  const check = () => {
    const { theme, progress, isDayMode } = getCurrentTheme();
    
    // Only callback if progress changed significantly
    if (Math.abs(progress - lastProgress) > 0.01) {
      lastProgress = progress;
      callback({ theme, progress, isDayMode });
    }
  };
  
  check();
  const interval = setInterval(check, checkInterval);
  
  return () => clearInterval(interval); // Return cleanup function
};

/**
 * Set manual dark mode override
 * @param {boolean|null} value - true for dark, false for light, null for auto
 */
export const setDarkModeOverride = (value) => {
  manualDarkModeOverride = value;
  if (value === null) {
    localStorage.removeItem('darkModeOverride');
  } else {
    localStorage.setItem('darkModeOverride', JSON.stringify(value));
  }
  
  // Apply the appropriate theme immediately
  if (value === true) {
    applyTheme(NIGHT_THEME);
  } else if (value === false) {
    applyTheme(DAY_THEME);
  } else {
    const { theme } = getCurrentTheme();
    applyTheme(theme);
  }
  
  // Dispatch event so other components can react
  window.dispatchEvent(new CustomEvent('themeChange', { 
    detail: { darkModeOverride: value } 
  }));
};

/**
 * Get current dark mode override status
 */
export const getDarkModeOverride = () => manualDarkModeOverride;

/**
 * Toggle dark mode (switches between auto, dark, and light modes)
 */
export const toggleDarkMode = () => {
  if (manualDarkModeOverride === null) {
    // Auto -> Dark
    setDarkModeOverride(true);
  } else if (manualDarkModeOverride === true) {
    // Dark -> Light
    setDarkModeOverride(false);
  } else {
    // Light -> Auto
    setDarkModeOverride(null);
  }
};
