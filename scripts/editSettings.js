let editUsernameArea = document.getElementById("username").querySelector('label');
let editUsernameField = editUsernameArea.querySelector("span");

editUsernameArea.addEventListener("click", editUsername);
editUsernameField.addEventListener("input", verifyInput);

function verifyInput() {
  let listItem = this.parentNode.parentNode;
  if (this.innerHTML != this.dataset.backup)
    addSaveAndCancelButtons(listItem);
  else removeSaveAndCancelButtons(listItem);
}
//editUsernameArea.addEventListener("blur", hey);

/*
let editPasswordArea = document.getElementById("password").querySelector("label");
editPasswordArea.addEventListener("click", editPassword);
let editEmailArea = document.getElementById("email").querySelector("label");
editEmailArea.addEventListener("click", editEmail);
let areas = {
  "username" : editUsernameArea,
  "password" : editPasswordArea,
  "email" : editEmailArea
}
let editing = "none";

*/
//Handlers for mouse click
function editUsername() {
  console.log("here");
  editUsernameField.focus();
  /*document.activeElement = this;
  console.log(document.activeElement);
  editing = "username";
  this.removeEventListener("click", editUsername);
  let usernameLabel = editUsernameArea.querySelector("label");
  let username = usernameLabel.innerHTML;
  editUsernameArea.removeChild(usernameLabel);

  let newForm = document.createElement('form');
  let input = '<input name="username" maxlength="255" type="text" class="input" value=' + username + ' required />';
  let saveButton = '<input type="submit" class="button" formaction="#" value="Save"></input>'
  let cancelButton = '<input  type="submit" class="button" formaction="#" value="Cancel"></input>'
  newForm.innerHTML =  input + saveButton + cancelButton;

  editUsernameArea.appendChild(newForm);

  let save = newForm.querySelector('input:nth-child(2)');
  save.addEventListener("click", saveUsername);
  */
}
/*
function editPassword() {
  editing = "password";
  this.removeEventListener("click", editPassword);

  let newForm = document.createElement('form');
  let currentPass = '<label> Current Password <input name="username" maxlength="255" type="text" class="input" value="" required /> </label>';
  let newPass = '<label> New Password <input name="username" maxlength="255" type="text" class="input" value="" required /> </label>';
  let newPassConfirm = '<label> Confirm Password <input name="username" maxlength="255" type="text" class="input" value="" required /> </label>';
  let saveButton = '<input type="submit" class="button" formaction="#" value="Save"></input>'
  let cancelButton = '<input  type="submit" class="button" formaction="#" value="Cancel"></input>'
  newForm.innerHTML = currentPass + newPass + newPassConfirm + saveButton + cancelButton;

  editPasswordArea.appendChild(newForm);

  let save = newForm.querySelector('input:nth-child(2)');
  save.addEventListener("click", savePassword);
}

function editEmail() {
  editing = "email";
  this.removeEventListener("click", editEmail);
  let emailLabel = editEmailArea.querySelector("label");
  let email = emailLabel.innerHTML;
  editEmailArea.removeChild(emailLabel);

  let newForm = document.createElement('form');
  let input = '<input name="username" maxlength="255" type="text" class="input" value=' + email + ' required />';
  let saveButton = '<input type="submit" class="button" formaction="#" value="Save"></input>'
  let cancelButton = '<input  type="submit" class="button" formaction="#" value="Cancel"></input>'
  newForm.innerHTML =  input + saveButton + cancelButton;

  editEmailArea.appendChild(newForm);

  let save = newForm.querySelector('input:nth-child(2)');
  save.addEventListener("click", saveEmail);
}

// Save new settings on database functions

function saveUsername(event) {
  event.preventDefault();
  let request = new XMLHttpRequest();
  request.addEventListener("load", updateUsername);
  request.open("get", "../database/updateUsername.php?username=" + this.parentNode.querySelector('input').value, true);
  request.send();
}

function savePassword(event) {
  event.preventDefault();
  let request = new XMLHttpRequest();
  request.addEventListener("load", updatePassword);
  request.open("get", "../database/updatePassword.php?password=" + this.parentNode.querySelector('input').value, true);
  request.send();
}

function saveEmail(event) {
  event.preventDefault();
  let request = new XMLHttpRequest();
  request.addEventListener("load", updateEmail);
  request.open("get", "../database/updateEmail.php?email=" + this.parentNode.querySelector('input').value, true);
  request.send();
}

// Handlers for ajax response received

function updateUsername() {
  let newUsername = JSON.parse(this.responseText);
  let form = editUsernameArea.querySelector('form');
  editUsernameArea.removeChild(form);
  let newLabel = document.createElement('label');
  newLabel.innerHTML = newUsername;
  editUsernameArea.appendChild(newLabel);
  editUsernameArea.addEventListener("click", editUsername);
}

function updatePassword() {
  let newPassword = JSON.parse(this.responseText);
  let form = editPasswordArea.querySelector('form');
  editPasswordArea.removeChild(form);
  let newLabel = document.createElement('label');
  newLabel.innerHTML = newPassword;
  editPasswordArea.appendChild(newLabel);
  editPasswordArea.addEventListener("click", editPassword);
}

function updateEmail() {
  let newEmail = JSON.parse(this.responseText);
  let form = editEmailArea.querySelector('form');
  editEmailArea.removeChild(form);
  let newLabel = document.createElement('label');
  newLabel.innerHTML = newEmail;
  editEmailArea.appendChild(newLabel);
  editEmailArea.addEventListener("click", editEmail);
}
*/
function saveEdit(){
  let type = this.parentNode.parentNode.id;

}

function cancelEdit() {
  let span = this.parentNode.parentNode.querySelector('span');
  span.innerHTML = span.dataset.backup;
  let listItem = this.parentNode.parentNode;
  removeSaveAndCancelButtons(listItem);
}

function generateSaveButton() {
  //let save = '<input type="submit" class="button" value="Save"></input>';
  //let cancel = '<input  type="submit" class="button" value="Cancel"></input>';
  let save = document.createElement('input');
  save.type = "submit";
  save.class = "button";
  save.value = "Save";

  return save;
}

function generateCancelButton(){
  let cancel = document.createElement('input');
  cancel.type = "submit";
  cancel.class = "button";
  cancel.value = "Cancel";
  return cancel;
}

function addSaveAndCancelButtons(item) {
  let buttons = item.querySelector('form');
  if (buttons == undefined) {
    let save = generateSaveButton();
    item.appendChild(save);
    let cancel = generateCancelButton();
    item.appendChild(cancel);
  }
}

function removeSaveAndCancelButtons(item) {
  let buttons = item.querySelector('form');
  if (buttons != undefined)
    item.removeChild(buttons);
  item.focus();
}

