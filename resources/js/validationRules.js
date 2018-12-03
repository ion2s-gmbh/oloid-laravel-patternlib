import {Validator} from 'vee-validate';
import {API} from './httpClient';
import LOG from './logger';

/**
 * UniquePattern validator.
 */
Validator.extend('uniquePattern', {

  /**
   * Checks if a patternName already exists by asking the backend API.
   * @param patternName
   * @returns {*}
   */
  validate: async (patternName) => {
    try {
      let response = await API.get(`pattern/exists/${patternName}`);
      return {
        valid: !response.data.data.exists,
        data: {
          message: `Pattern '${patternName}' already exists!`
        }
      };
    } catch (e) {
      LOG.error(e);
    }
  },

  /**
   * Get the validation message.
   * @param field
   * @param params
   * @param data
   * @returns {string|string}
   */
  getMessage: (field, params, data) => {
    return data.message;
  }
});