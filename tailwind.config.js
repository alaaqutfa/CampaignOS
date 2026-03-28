import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                // الألوان الأساسية للهوية البصرية
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#5B3DF5',
                    600: '#3B82F6',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                accent: {
                    50: '#ecfeff',
                    100: '#cffafe',
                    200: '#a5f3fc',
                    300: '#67e8f9',
                    400: '#22D3EE',
                    500: '#06b6d4',
                    DEFAULT: '#22D3EE',
                },
                // يمكنك إضافة neutral هنا أيضاً إذا أردت استخدامه مباشرة في الكلاسات العامة
                neutral: {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                },
            },

            backgroundColor: {
                'dark': '#0F172A',
                'light': '#F8FAFC',
            },

            backgroundImage: {
                'primary-gradient': 'linear-gradient(135deg, #5B3DF5, #3B82F6, #4DC0DE)',
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')({
            theme: {
                extend: {
                    colors: {
                        // تطبيق نفس الألوان على مكونات Flowbite
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#5B3DF5',
                            600: '#3B82F6',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            200: '#a5f3fc',
                            300: '#67e8f9',
                            400: '#22D3EE',
                            500: '#06b6d4',
                            DEFAULT: '#22D3EE',
                        },
                        neutral: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        },
                    },
                },
            },
        }),
    ],
};
