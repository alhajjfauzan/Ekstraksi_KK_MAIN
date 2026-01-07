/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          'brand-green': '#00C988', // Warna hijau tombol/aksen
          'brand-dark': '#050505',  // Warna latar belakang gelap
          'brand-gray': '#1F1F1F',  // Warna container form
        },
        fontFamily: {
          sans: ['Inter', 'sans-serif'], // Pastikan font sesuai (biasanya Inter/Poppins)
        }
      },
    },
    plugins: [],
  }