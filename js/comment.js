function display_comments(html_element, message_id) {
  request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let responseJSON = JSON.parse(this.responseText);
      responseJSON.forEach(comment => {
        let comment_wrap = createComment(comment);
        html_element.appendChild(comment_wrap);
      });
    }
  }
  request.open("GET", "../api/comments.php/message/" + message_id, true);
  request.send();
}

function send_comment(comment_wrap, message_id, text) {
  request = new XMLHttpRequest();

  let subcomments = comment_wrap.querySelector('.subcomments');

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let responseJSON = JSON.parse(this.responseText);
      let comment = responseJSON;

      let new_comment_wrap = createComment(comment);
      let replies_button = comment_wrap.querySelector('.replies');
      Comment.instance(message_id).setOpenState();

      subcomments.innerHTML = '';
      display_comments(subcomments, message_id);
    }
  }
  request.open("POST", "../api/comments.php", true);
  request.send(JSON.stringify({
    "message_id": message_id,
    "text": text
  }));
}

function createComment(comment) {
  let comment_wrap = comment_html(comment.message_id, comment.username, comment.text, comment.date, comment.comments);
  let subcomments = comment_wrap.querySelector('.subcomments');
  let replies_button = comment_wrap.querySelector('.replies');
  let arrow_up = comment_wrap.querySelector('.arrow_up');
  let arrow_down = comment_wrap.querySelector('.arrow_down');
  let reply_button = comment_wrap.querySelector('.reply');

  if (replies_button != undefined) {
    replies_button.addEventListener('click', function (event) {
      event.preventDefault();
      let state = Comment.instance(comment.message_id).changeState().getState();
      switch (state) {
        case 'OPEN':
          arrow_down.style.display = "none";
          arrow_up.style.display = "initial";
          display_comments(subcomments, comment.message_id);
          break;

        case 'CLOSE':
          arrow_up.style.display = "none";
          arrow_down.style.display = "initial";
          subcomments.innerHTML = '';
          break;
      }
    });
  }

  reply_button.addEventListener('click', function (event) {
    event.preventDefault();
    createCommentTextarea(comment_wrap);
  });

  return comment_wrap;
}

function createCommentTextarea(comment_wrap) {
  let message_id = comment_wrap.dataset.id;
  let new_comment_area_wrap = comment_wrap.querySelector('.new_comment_area');

  let new_comment_area = new_comment_html(message_id);

  let send_button = new_comment_area.querySelector('#send_button');
  send_button.addEventListener('click', function (event) {
    event.preventDefault();
    let text = new_comment_area.querySelector('.send_text');
    send_comment(comment_wrap, message_id, text.value);

    if(comment_wrap.classList.contains('comment-main')){
      text.value = '';
    }
    else{
      new_comment_area_wrap.innerHTML = '';
    }
  });
  new_comment_area_wrap.appendChild(new_comment_area);
}




function init() {
  //Display all message comments
  let html_element = document.querySelector('.comment-wrap');
  let subcomments = html_element.querySelector('.subcomments');
  let message_id = html_element.dataset.id;
  createCommentTextarea(html_element);
  display_comments(subcomments, message_id);
}


init();






















function comment_html(message_id, username, text, date, num_comments) {
  let time = timeSince(new Date(date * 1000));
  let elem = document.createElement('section');
  elem.className = 'comment-wrap';
  elem.dataset.id = message_id;
  elem.innerHTML = `
      <div class="comment">
        <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;">  
        
        <a class="user_name" href="">${username}</a>
        <span class="comment_time"> ${time} </span>
        <div class="message">${text}</div>
        <span class="vote">
          <a class="vote_up" href=""><i class="fas fa-angle-up"></i></a>
          <a class="vote_down" href=""><i class="fas fa-angle-down"></i></a>
        </span>
        <a href="" class="reply">REPLY</a>
        </br>
        ${num_comments == 0 
          ? ""
          : `<a href="" class="replies">View ${num_comments} replies <i class="fas fa-angle-up arrow_up" style="display:none"></i><i class="fas fa-angle-down arrow_down"></i></a>`
        }
      </div>  
      <div class="new_comment_area">
      </div>
      <div class="subcomments">
      </div>
    `;
  return elem;
}

function new_comment_html(message_id) {
  let elem = document.createElement('div');
  elem.className = 'new-comment';
  elem.dataset.id = message_id;
  elem.innerHTML = `
      <textarea placeholder="Write a comment..." class="message text send_text" name="text" oninput='this.style.height = "";this.style.height = this.scrollHeight + 10 + "px"'></textarea>
      <a id="send_button" href="">Send</a>
    `;
  return elem;
}