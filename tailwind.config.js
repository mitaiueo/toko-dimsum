import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#A31D1D',
                secondary: '#D84040',
                dark: '#2d3436',
                light: '#f5f6fa',
                accent: '#ECDCBF',
            },
            fontFamily: {
                sans: ['Quicksand', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'soft': '0 4px 15px rgba(0, 0, 0, 0.08)',
                'hover': '0 8px 20px rgba(0, 0, 0, 0.12)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'pulse-subtle': 'pulseSubtle 2s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                pulseSubtle: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.85' },
                },
            },
            transitionProperty: {
                'height': 'height',
            },
        },
    },

    plugins: [forms],
};
