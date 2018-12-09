function display_comments() {
  request = new XMLHttpRequest();

  let elem = document.getElementById('list_comments');
  let message_id = elem.dataset.message_id;

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var responseJSON = JSON.parse(this.responseText);

      responseJSON.forEach(comment => {
        elem.innerHTML += commentHTML(comment.publisher, comment.text);
      });
    }
  }
  request.open("GET", "../api/comments.php/message/" + message_id, true);
  request.send();
}

function send_comment(message_id, user_id, text){
  request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let elem = document.getElementById('list_comments');
      elem.innerHTML += commentHTML(user_id, text);

    }
  }
  request.open("POST", "../api/comments.php/message", true);
  request.send(JSON.stringify({
    "message_id" : message_id,
    "user_id" : user_id,
    "text" : text
  }));
}

function ready() {

  //Display all message comments
  display_comments();

  //Install send button handlers
  let sendButton = document.getElementById('send_button');

  sendButton.addEventListener('click', function (event) {
    event.preventDefault();

    console.log(this.parentNode);

    let text = document.getElementById('send_text');
    send_comment(1, 2, text.value);
    text.value = '';
    
  });
}

function commentHTML(username, text) {
  return `
    <div class="comment"></div>
      <div class="user_info">
        <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;">
        <a class="user_name" href="">${username}</a>
    </div>
    <textarea readonly class="message">${text}</textarea>
  </div>`;
}

ready();