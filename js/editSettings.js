
let handle = [];
handle['editable'] = {
  getContent: getEditableContent,
  handleClick: handleClickOnEditable,
  handleBlur: handleBlurOnEditable,
  handleCancel: handleCancelOnEditable,
  handleSave: handleSaveOnEditable,
  handleInput: updateToolsOfEditable,
  cancelInput: cancelEditable,
  openInput: openEditable,
  
};

handle['password'] = {
  getContent: getPasswordContent,
  handleClick: handleClickOnPassword,
  handleBlur: handleBlurOnPassword,
  handleCancel: handleCancelOnPassword,
  handleSave: handleSaveOnPassword,
  cancelInput: cancelPassword,
  openInput: openPassword
};

let contents = [];

let inputs = document.querySelectorAll('#input');

for (let i = 0; i < inputs.length; i++) {
  addListeners(inputs[i]);
  let type = inputs[i].dataset.type;
  contents[inputs[i].dataset.id] = {
    type: type,
    content: handle[type].getContent(inputs[i]),
    input: inputs[i]
  }
}

var selectedInput = null;

/* EDITABLE */

/* _________ Get Content __________ */

function getEditableContent(input) {
  let span = input.querySelector('span');
  return span.innerHTML;
}

function getPasswordContent(input) {
  return input.dataset.previous;
}

/* _________ Add Listeners __________ */

function addListeners(input) {
  let type = input.dataset.type;

  /* Click */
  let div = input.querySelector('div');
  div.addEventListener("click", handle[type].handleClick);
  
  /* Blur */
  handle[type].handleBlur(input);

  /* Input */
  if (type == "editable") {
    let span = input.querySelector('span');
    span.addEventListener("input", handle[type].handleInput);
  }

  /* Cancel */
  let cancel = input.querySelector('.buttons #cancel');
  cancel.addEventListener("click", handle[type].handleCancel);

  /* Save */
  let save = input.querySelector('.buttons #save');
  save.addEventListener("click", handle[type].handleSave);
}

/* _________ Handle Click __________ */

function handleClickOnEditable() {
  let input = this.parentNode;
  openEditable(input);
}

function handleClickOnPassword() {
  let input = this.parentNode;
  openPassword(input);
}

/* _________ Handle Blur __________ */

function handleBlurOnEditable(input) {
  input.querySelector('span').addEventListener('blur', function() {
  let previous = document.querySelector('#input[data-selected = true]');
    if (previous != null)
      previous.dataset.selected = false;
  });
}

function handleBlurOnPassword(input) {
  //do nothing;
}

/* _________ Open Environment __________ */

function openEditable(input) {
  if (selectedInput == null) {
    input.querySelector('span').focus();
    let previous = document.querySelector('#input[data-selected = true]');
    if (previous != null)
      previous.dataset.selected = false;
    input.dataset.selected = true;
  }
  else if (selectedInput != input.dataset.id)
    throwPopup(input);
}

function openPassword(input) {
  let id = input.dataset.id;
  if (selectedInput == null) {
    selectedInput = id;
    let previous = document.querySelector('#input[data-selected = true]');
    console.log(previous);
    if (previous != null)
      previous.dataset.selected = false;
    input.dataset.selected = true;

    showEditingTools(input);
  }
  else if (selectedInput != input.dataset.id)
    throwPopup(input);
}


/* _________ Handle Input __________ */

function updateToolsOfEditable() {
  let listItem = this.parentNode.parentNode;
  console.log('ufadkshj' + listItem);
  if (this.innerHTML != this.dataset.backup)
    showEditingTools(listItem);
  else hideEditingTools(listItem);
}

/* _________ Handle Cancel __________ */


function handleCancelOnEditable() {
  let input = this.parentNode.parentNode.parentNode;
  cancelEditable(input);
}

function cancelEditable(input) {
  let span = input.querySelector('span');
  span.innerHTML = span.dataset.backup;
  
  hideEditingTools(input);
  selectedInput = null;
  input.dataset.selected = false;
}

function handleCancelOnPassword() {
  let input = this.parentNode.parentNode.parentNode;
  cancelPassword(input);
}

function cancelPassword(input) {
  hideEditingTools(input);
  selectedInput = null;
  input.dataset.selected = false;
}
/* _________ Handle Save __________ */

function handleSaveOnEditable() {
  event.preventDefault();
  let input = this.parentNode.parentNode.parentNode;
  let span = input.querySelector('span');
  let id = input.dataset.id;
  contents[id].content = span.innerHTML;
  if (updateInfo())
    span.dataset.backup = span.innerHTML;
  else contents[id].content = span.dataset.backup;

  hideEditingTools(input);
  selectedInput = null;
  input.dataset.selected = false;
}

function handleSaveOnPassword() {
  
  let input = this.parentNode.parentNode.parentNode;
  let oldP = input.querySelector('#old input').value;
  let newP = input.querySelector('#new input').value;
  let confirmNewP = input.querySelector('#new-conf input').value;
  let id = input.dataset.id;
  if (oldP != contents['password'].content)
    alert("OLDP Could not update user info!");

  else if (newP != confirmNewP)
    alert("Passwords do not match!");
  else {
    //the update can already be made since there are no invalid passwords
    contents[id].content = newP;
    updateInfo();
    hideEditingTools(input);
    selectedInput = null;
    input.dataset.selected = false;
  }

  
}

/* _________ Update info __________ */


function updateInfo() {
  let request = new XMLHttpRequest();
  request.addEventListener("load", handleUpdateAnswer);
  let args = "";
  for (let key in contents) {
    args += key + "=" + contents[key].content + "&";
  }
  request.open("get", "../database/updateUser.php?" + args, true);
  request.send();
}

function handleUpdateAnswer() {
  let result = JSON.parse(this.responseText);
  if (!result)
    alert('Could not update user info!');
  else alert("User info succefully changed!");
}


/* _________ Show Tools __________ */

function throwPopup(newInput) {
  let oldInput = contents[selectedInput].input;
  let oldType = oldInput.dataset.type;
  let newType = newInput.dataset.type;
  if (confirm('Are you sure you want to discard the changes?')) {
    handle[oldType].cancelInput(oldInput);
    handle[newType].openInput(newInput);
  }
}

/* _________ Generic __________ */


function showEditingTools(input) {
  input.querySelector("#editionTools").hidden = false;
  let id = input.dataset.id;
  selectedInput = id;
  input.dataset.selected = true;
}

function hideEditingTools(input) {
  input.querySelector("#editionTools").hidden = true;
  selectedInput = null;
  input.dataset.selected = false;
}

function areToolsHidden(input) {
  return input.querySelector('#editionTools').hidden;
}

