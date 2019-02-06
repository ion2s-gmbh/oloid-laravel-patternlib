export default {

  /**
   * Set basic application information retrieved from Laravel.
   * @param state
   * @param info
   */
  appInfo: (state, info) => {
    state.appInfo = info.data;
  },

  /**
   * Set the active main menu item.
   * @param state
   * @param menu
   */
  toggleMainMenu: (state, menu) => {
    state.navi.activeMain = menu;
    state.navi.activeSub = '';
  },

  /**
   * Set the active sub menu item.
   * @param state
   * @param subMenu
   */
  toggleSubMenu: (state, subMenu) => {
    state.navi.activeSub = subMenu;
  },

  /**
   * Reset the active main menu item.
   * @param state
   */
  resetMenu: state => {
    state.navi.activeMain = '';
  },

  /**
   * Reset the active sub menu item.
   * @param state
   */
  resetSubMenu: state => {
    state.navi.activeSub = '';
  },

  /**
   * Start/stop a reload of the navi.
   * @param state
   * @param reload
   */
  reloadNavi: (state, reload) => {
    state.navi.reload = reload;
  },

  /**
   * Toggle the keymap.
   * @param state
   */
  toggleKeyMap: (state) => {
    state.showKeyMap = !state.showKeyMap;
  },

  /**
   * Toggle the global resources configuration.
   * @param state
   */
  toggleResources: (state) => {
    state.showResources = !state.showResources;
  },

  /**
   * Toogle a dropdown.
   * @param state
   * @param dropdown
   */
  toggleDropdown: (state, dropdown) => {
    state.activeDropdown = dropdown;
  },

  /**
   * Reset the activeDropdown.
   * @param state
   */
  resetDropdown: (state) => {
    state.activeDropdown = '';
  },

  /**
   * Set the global resources for the head section.
   * @param state
   * @param resources
   */
  headResources: (state, resources) => {
    state.resources.head = resources;
  },

  /**
   * Set the global resources for the body section.
   * @param state
   * @param resources
   */
  bodyResources: (state, resources) => {
    state.resources.body = resources;
  }
}