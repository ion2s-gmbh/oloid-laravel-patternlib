const keyPressed = function (event) {

  let key;

  if (event.keyIdentifier !== undefined) {
    key = event.keyIdentifier;
  } else if (event.keyCode !== undefined) {
    key = event.keyCode;
  }

  return key;
};

export { keyPressed };