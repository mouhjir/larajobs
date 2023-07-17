import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        './vendor/filament/**/*.blade.php',
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                laravel: "#6e7bff",
                colors: {
                    danger: colors.rose,
                    primary: colors.blue,
                    success: colors.green,
                    warning: colors.yellow,
                },
            },
        },
    },
    plugins: [
        forms,
        typography,
    ],
    dark: "class",
};
