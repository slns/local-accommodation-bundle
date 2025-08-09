const path = require("path");

module.exports = {
  content: [
    path.resolve(__dirname, "../templates/**/*.html.twig"),
    path.resolve(__dirname, "./*.js"),
    path.resolve(__dirname, "./*.css"),
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
