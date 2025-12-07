import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{js,vue}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand colors using CSS variables
                primary: 'var(--color-primary)',
                secondary: 'var(--color-secondary)',
                'accent-dark': 'var(--color-accent-dark)',
                'accent-light': 'var(--color-accent-light)',
            },
            backgroundColor: {
                base: 'var(--color-background)',
                light: 'var(--color-light-bg)',
            },
            textColor: {
                base: 'var(--color-text)',
            },
            borderColor: {
                base: 'var(--color-border)',
                DEFAULT: 'var(--color-border)',
            },
        },
    },

    plugins: [forms],
};
