// resources/js/helpers/assets.js
export function asset(path) {
  // Vite requires `new URL(..., import.meta.url).href` for static assets
  return new URL(`../assets/${path}`, import.meta.url).href;
}
