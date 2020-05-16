module.exports = {
  test: /\.vue$/,
  use: ['cache-loader', ...loaders],
  include: path.resolve('src'),
};
