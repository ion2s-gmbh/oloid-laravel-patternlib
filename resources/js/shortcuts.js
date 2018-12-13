const createShortcuts = [
  {
    stroke: 'Ctrl + S',
    description: 'Save the newly created Pattern.'
  },
  {
    stroke: 'ESC',
    description: 'Cancel the creation of the new Pattern.'
  }
];

const globalShortcuts = [
  {
    stroke: 'Ctrl + C',
    description: 'Trigger creation of a new Pattern.'
  },
  {
    stroke: 'Ctrl + K',
    description: 'Show/hide the shortcuts on the current page.'
  }
];
const previewShortcuts = [
  {
    stroke: 'Ctrl + DEL',
    description: 'Trigger deletion of the Pattern.'
  },
  {
    stroke: 'ESC',
    description: 'Cancel deletion of the Pattern.'
  },
  {
    stroke: 'Ctrl + S',
    description: 'Save the edited description of the Pattern.'
  },
  {
    stroke: 'ESC',
    description: 'Cancel edit mode of the Pattern\'s description.'
  }
];

const updateShortcuts = [
  {
    stroke: 'Ctrl + S',
    description: 'Save the new name of the Pattern.'
  },
  {
    stroke: 'ESC',
    description: 'Cancel the renaming of the Pattern.'
  }
];

/**
 * Exported function that should be used as a computed property.
 * @returns {getters.showKeyMap|boolean|*}
 */
const showKeyMap = function () {
  return this.$store.getters.showKeyMap;
};

export {
  createShortcuts,
  globalShortcuts,
  previewShortcuts,
  updateShortcuts,
  showKeyMap
};