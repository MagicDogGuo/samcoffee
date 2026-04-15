/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        coffee: {
          dark: '#3e2723',
          brown: '#4e342e',
          medium: '#5d4037',
          light: '#8d6e63',
          cream: '#fffef5',
        },
      },
      fontFamily: {
        logo: ['"Edu AU VIC WA NT Pre"', 'cursive'],
        body: ['"Open Sans"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

