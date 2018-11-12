import config from './config';

export default {

  debug: function(...params) {
    if (config.devMode) {
      console.log(...params);
    }
  },

  error: function (...params) {
    if (config.devMode) {
      console.error(...params);
    }
  }
}