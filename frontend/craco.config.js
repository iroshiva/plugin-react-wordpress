// minify css
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
// minify js
const TerserPlugin = require("terser-webpack-plugin");
const path = require("path");

module.exports = {
  webpack: {
    configure: {
      output: {
        path: path.join(__dirname, "build"),
        filename: "static/js/[name].[hash].min.js",
        chunkFilename: "[id].[chunkhash].js",
      },
      optimization: {
        minimize: true,
        minimizer: [
          new OptimizeCssAssetsPlugin({
            cssProcessorOptions: {
              map: {
                // false == génération du .map
                inline: false,
                // affiche le fichier .map lié au .css en commentaire
                annotation: true,
              },
            },
          }),
          new TerserPlugin({
            // Use multi-process parallel running to improve the build speed
            // Default number of concurrent runs: os.cpus().length - 1
            parallel: true,
          }),
        ],
      },
    },
  },
  plugins: [
    {
      plugin: {
        overrideWebpackConfig: ({ webpackConfig }) => {
          // console.log(webpackConfig.plugins)
          // MiniCssExtractPlugin
          webpackConfig.plugins[5].options.filename = "static/css/[name].[hash].min.css";

          // webpack-manifest-plugin
          webpackConfig.plugins[6].options.publicPath = "";
          return webpackConfig;
        },
      },
      options: {},
    },
  ],
};
