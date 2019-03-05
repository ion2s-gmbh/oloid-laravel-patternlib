import config from './config';

export default {

  /**
   * Dubug logging if environment is 'development'.
   * @param params
   */
  debug: function(...params) {
    if (config.environment === 'development') {
      console.log(...params);
    }
  },

  /**
   * Error logging if environment is 'development'.
   * @param params
   */
  error: function (...params) {
    if (config.environment === 'development') {
      console.error(...params);
    }
  }
}