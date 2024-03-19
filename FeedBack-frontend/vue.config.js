module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost:3000',
        changeOrigin: true,
        pathRewrite: {
          '^/api': '',
        },
        headers: {
          Host: 'subdomain.localhost:8082',
        },
      },
    },
  },
};
