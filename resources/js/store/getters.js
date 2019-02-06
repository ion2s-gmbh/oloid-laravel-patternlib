export default {

  /**
   * Return the devMode.
   * @param state
   * @returns {boolean}
   */
  isDevMode: state => state.config.devMode,

  /**
   * Get the Laravel app name.
   * @param state
   * @returns {string}
   */
  appName: state => state.appInfo.appName,

  /**
   * Determine if the navi should be reloaded.
   * @param state
   * @returns {boolean}
   */
  reloadNavi: state => state.navi.reload === true,

  /**
   * Check if the given menu is active.
   * @param state
   * @returns {function(*): boolean}
   */
  isActiveMainMenu: (state) => (menu) => state.navi.activeMain === menu,

  /**
   * Determine if the given sub menu is currently active.
   * @param state
   * @returns {function(*=): boolean}
   */
  isActiveSubmenu: (state) => (menu) => state.navi.activeSub.includes(menu),

  /**
   * Determine if the keyMap is shown.
   * @param state
   * @returns {getters.showKeyMap|(function(*))|boolean}
   */
  showKeyMap: state => state.showKeyMap,

  /**
   * Determine if the global resources are shown.
   * @param state
   * @returns {getters.showResources|(function(*))|default.computed.showResources|showResources|boolean|*}
   */
  showResources: state => state.showResources,

  /**
   *
   * @param state
   * @returns {getters.activeDropdown|(function(*))|string|any}
   */
  activeDropdown: state => state.activeDropdown,

  /**
   * Get the global head resources.
   * @param state
   * @returns {string}
   */
  headResources: state => state.resources.head,

  /**
   * Get the global body resources.
   * @param state
   * @returns {string}
   */
  bodyResources: state => state.resources.body,
}