const { file_path } = require("./library/constants/global");
const fg = require('fast-glob');

const phpFilesPattern = "**/*.php"; // The glob pattern to find PHP files recursively

// Use fast-glob to find PHP files
const phpFiles = fg.sync(phpFilesPattern, {
  ignore: ["node_modules", "dist", ".git"],
  cwd: file_path, // The base directory where the search starts
});

module.exports = {
  mode: 'jit',
  content: phpFiles, // Set the content property to include the found PHP files

  theme: {
    extend: {
       colors: {
        "leadership-knoxville-gold": "#ECAB1F",
        "leadership-knoxville-purple": "#74308C",
        "leadership-knoxville-green": "#2C8B4B",
        "leadership-knoxville-orange": "#D34729",
        "leadership-knoxville-maroon": "#AA1F2D",
        "leadership-knoxville-white": "#FFFFFF",
        "leadership-knoxville-cyan": "#36b6e6",
        "leadership-knoxville-blue": "#1674b0",
        "leadership-knoxville-teal": "#1c6591",
        "leadership-knoxville-slate": "#064975"
    }
    },
    screens: {
      // 480, 767, 1200,  1800
      'xs': '320px',
      'sm': '480px',
      'md': '767px',
      "lg": "1200px",
      "xl": "1800px",
       "2xl": "1800px"
      }
  },
};
