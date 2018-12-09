function add_comment(message_id, value) {
    xmlhttp = new XMLHttpRequest();
  
    xmlhttp.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
        let user = JSON.parse(this.responseText);
        let comments = document.querySelector('.comments[data-id="'+message_id+'"]');
        let new_comment_area = document.querySelector('.comments[data-id="'+message_id+'"] > .new-comment');
        comments.removeChild(new_comment_area);

        let newComment = document.createElement('div');
        newComment.class = "comment";
        newComment.innerHTML ='<div class="user_info"> <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;"> <a class="user_name" href="">' + user['username'] + '</a> </div> <textarea readonly class="message">' + value + '</textarea>';
        comments.appendChild(newComment);
        new_comment_area.querySelector('textarea').value = "";
        comments.appendChild(new_comment_area);
      }
    }

    xmlhttp.open("GET", "../actions/action_add_comment.php?message_id=" + message_id + "&text=" + value, true);
    xmlhttp.send();
  }
  
  function ready() {
    let sendButtons = document.querySelectorAll('.send_button');

    for(let i = 0; i < sendButtons.length; i++){
      sendButtons[i].addEventListener('click', function (event) {
        event.preventDefault();
        let text = this.parentNode.querySelector(".text").value;
        let id = this.parentNode.dataset.id;
        add_comment(id, text);
      });
    }
  }

  ready();