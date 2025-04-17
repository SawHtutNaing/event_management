import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
    ],

    theme: {
        extend: {




            colors: {
                primary: {
                    50:  '#fffdf3',
                    100: '#fff9df',
                    200: '#fff2b2',
                    300: '#ffe97d',
                    400: '#ffe048',
                    500: '#FDCC30', // your base color
                    600: '#e0b124',
                    700: '#b68d1a',
                    800: '#8c6a11',
                    900: '#6e520c',
                },
                secondary: {
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                }
            },


            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
