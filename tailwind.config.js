import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/**/*.html',
        './resources/**/*.vue',
    ],

    safelist: [
        // Gradient classes yang sering digunakan
        'bg-gradient-to-r',
        'bg-gradient-to-l',
        'bg-gradient-to-t',
        'bg-gradient-to-b',
        'bg-gradient-to-br',
        'bg-gradient-to-bl',
        'bg-gradient-to-tr',
        'bg-gradient-to-tl',
        // Color combinations untuk gradient
        'from-indigo-600',
        'to-purple-600',
        'from-green-600',
        'to-teal-600',
        'from-orange-600',
        'to-red-600',
        // Backup untuk semua gradient patterns
        {
            pattern: /bg-gradient-to-(r|l|t|b|br|bl|tr|tl)/,
        },
        {
            pattern: /from-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        {
            pattern: /to-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900)/,
        }
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
