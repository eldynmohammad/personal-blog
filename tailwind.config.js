const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
	mode: 'jit',
	purge: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.vue'
	],

	theme: {
		extend: {
			colors: {
				accentcolor: {
					light: '#6f90dc',
					DEFAULT: '#537ad5',
					dark: '#3b64c4'
				}
			},
			fontFamily: {
				sans: [ 'Nunito', ...defaultTheme.fontFamily.sans ]
			}
		}
	},

	plugins: [ require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('@tailwindcss/line-clamp') ]
};
