import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    red: {
                        50: '#FEF2F2',
                        100: '#FEE2E2',
                        500: '#EF4444',
                        600: '#DC2626',
                        700: '#C62828', // Primary Red
                        800: '#991B1B',
                        900: '#7F1D1D',
                    },
                    green: {
                        50: '#F0FDF4',
                        100: '#DCFCE7',
                        600: '#15803D',
                        700: '#166534', // Brand Green
                        800: '#14532D',
                        900: '#052E16',
                    },
                },
                slate: {
                    50: '#F8FAFC',
                    100: '#F1F5F9',
                    300: '#CBD5E1',
                    500: '#64748B',
                    700: '#334155',
                    900: '#0F172A',
                },
            },
            boxShadow: {
                card: '0 1px 3px rgba(15, 23, 42, 0.06)',
                dropdown: '0 4px 12px rgba(15, 23, 42, 0.08)',
                modal: '0 12px 32px rgba(15, 23, 42, 0.12)',
            },
            borderRadius: {
                sm: '6px',
                md: '8px',
                lg: '12px',
                xl: '16px',
            },
        },
    },

    plugins: [forms],
};
