import {Validator} from 'vee-validate';
import {API} from './httpClient';

/**
 * UniquePattern validator.
 */
Validator.extend('uniquePattern', {

  /**
   * Checks if a patternName already exists by asking the backend API.
   * @param patternName
   * @returns {*}
   */
  validate: (patternName) => {
    return API.get(`pattern/exists/${patternName}`)
      .then((response) => {
        return {
          valid: !response.data.data.exists,
          data: {
            message: `Pattern '${patternName}' already exists!`
          }
        };
      });
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