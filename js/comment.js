function display_comments(html_element, message_id) {
  request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let responseJSON = JSON.parse(this.responseText);

      responseJSON.forEach(comment => {
        let comment_wrap = createComment(comment);
        createCommentTextarea(comment_wrap);
        html_element.appendChild(comment_wrap);
        doScrolling(comment_wrap, 1000);
      });
    }
  }
  request.open("GET", "../api/comments.php/message/" + message_id, true);
  request.send();
}

function send_comment(html_element, message_id, text) {
  request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let responseJSON = JSON.parse(this.responseText);

      let comment = responseJSON;
      let comment_wrap = createComment(comment);
      Comment.instance(comment.message_id).changeState();
      createCommentTextarea(comment_wrap);

      html_element.appendChild(comment_wrap);
      doScrolling(comment_wrap, 1000);
    }
  }
  request.open("POST", "../api/comments.php", true);
  request.send(JSON.stringify({
    "message_id": message_id,
    "text": text
  }));
}

// Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.username, Channel.title as channel

function createComment(comment) {
  console.log(comment);
  let comment_wrap = comment_html(comment.message_id, comment.username, comment.text, comment.date, comment.comments);
  let subcomments = comment_wrap.querySelector('.subcomments');
  let comments_button = comment_wrap.querySelector('.replies');

  if(comments_button != undefined){
  comments_button.addEventListener('click', function (event) {
    event.preventDefault();
    let state = Comment.instance(comment.message_id).changeState().getState();
    switch (state) {
      case 'OPEN':
        display_comments(subcomments, comment.message_id);
        break;

      case 'CLOSE':
        subcomments.innerHTML = '';
        break;
    }
    doScrolling(subcomments, 1000);
  });
  }
  return comment_wrap;
}

function createCommentTextarea(comment_wrap) {
  let message_id = comment_wrap.dataset.id;
  let subcomments = comment_wrap.querySelector('.subcomments');

  comment_wrap.querySelector('.reply').addEventListener('click', function (event) {
    event.preventDefault();
    let new_comment_area = new_comment_html(message_id);
    let send_button = new_comment_area.querySelector('#send_button');
    
    send_button.addEventListener('click', function (event) {
      event.preventDefault();
      let text = document.getElementById('send_text');
      send_comment(subcomments, message_id, text.value);
      new_comment_area.innerHTML = '';
    });
    subcomments.appendChild(new_comment_area);
    doScrolling(comment_wrap.querySelector('.reply'), 1000);
  });
}




function comment_html(message_id, username, text, date, num_comments) {
  let time = timeSince(new Date(date * 1000));
  let elem = document.createElement('section');
  elem.className = 'comment-wrap';
  elem.dataset.id = message_id;
  elem.innerHTML = `
      <div class="comment">
        <a class="user_name" href="">${username}</a>
        <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;">  
        <div class="message">${text}</div>
        <div class="comment_time"> ${time} </div>
        ${num_comments == 0 ? `` : `<a href="" class="replies">${num_comments}</a>`}
        <a href="" class="reply">REPLY</a>
      </div>  

      <div class="subcomments">
      </div>
    `;
  return elem;
}

function new_comment_html(message_id) {
  let elem = document.createElement('section');
  elem.className = 'new-comment';
  elem.dataset.id = message_id;
  elem.innerHTML = `
    <div class="new-comment">
      <textarea id="send_text" name="text" placeholder="Write comment..." class="text" required></textarea>
      <a id="send_button" href="">Send</a>
    </div>
    `;
  return elem;
}


function init() {
  //Display all message comments
  let html_element = document.querySelector(`.comment-wrap`);
  let message_id = html_element.dataset.id;
  display_comments(html_element, message_id);

  // Install send button handlers
  let sendButton = document.getElementById('send_button');
  sendButton.addEventListener('click', function (event) {
    event.preventDefault();
    let text = document.getElementById('send_text');
    send_comment(html_element, message_id, text.value);
    text.value = '';
  });
}


init();