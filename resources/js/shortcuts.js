/**
 * Global shortcuts.
 * @type {*[]}
 */
const globalShortcuts = [
  {
    stroke: '?',
    description: 'Show/hide the shortcuts on the current page.'
  },
  {
    stroke: 'c',
    description: 'Create a new Pattern.'
  },
  {
    stroke: 'r',
    description: 'Open the global resources definition.'
  },
  {
    stroke: 'esc',
    description: 'Close or cancel.'
  }
];


/**
 * Keyboard shortcuts on the create component.
 * @type {*[]}
 */
const createShortcuts = [
  {
    stroke: 'ctrl + enter',
    description: 'Save the newly created Pattern.'
  }
];

/**
 * Keyboard shortcuts on the preview component.
 * @type {*[]}
 */
const previewShortcuts = [
  {
    stroke: 'e',
    description: 'Rename this Pattern.'
  },
  {
    stroke: 'd',
    description: 'Delete this Pattern.'
  },
  {
    stroke: 'ctrl + enter',
    description: 'Save the form.'
  },
];

/**
 * Keyboard shortcuts on the update component.
 * @type {*[]}
 */
const updateShortcuts = [
  {
    stroke: 'ctrl + enter',
    description: 'Save the new name of the Pattern.'
  }
];

/**
 * Exported function that should be used as a computed property.
 * @returns {getters.showKeyMap|boolean|*}
 */
const showKeyMap = function () {
  return this.$store.getters.showKeyMap;
};

/**
 * Constants for shortcuts.
 * @type {{HELP: string, CREATE: string, CLOSE: string}}
 */
const keys = {
  "CREATE": 'c',
  "HELP": '?',
  "CLOSE": 'Escape',
  "EDIT": 'e',
  "DELETE": 'd',
  "RESOURCES": 'r'
};

export {
  createShortcuts,
  globalShortcuts,
  previewShortcuts,
  updateShortcuts,
  showKeyMap,
  keys
};