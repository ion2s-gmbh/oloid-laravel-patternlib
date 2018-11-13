import config from './config';

export default {

  /**
   * Dubug logging if devMode is enabled.
   * @param params
   */
  debug: function(...params) {
    if (config.devMode) {
      console.log(...params);
    }
  },

  /**
   * Error logging if devMode is enabled.
   * @param params
   */
  error: function (...params) {
    if (config.devMode) {
      console.error(...params);
    }
  }
}