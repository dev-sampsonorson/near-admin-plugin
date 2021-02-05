const tailwindcss = require('tailwindcss');

module.exports = {
    plugins: [
        tailwindcss('./tailwind.config.js'),
        require('precss'),
        require('tailwindcss'),
        require('autoprefixer')
    ]
}