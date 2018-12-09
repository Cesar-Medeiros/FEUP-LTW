function add_comment(message_id, value) {
    xmlhttp = new XMLHttpRequest();
  
    xmlhttp.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
        var responseJSON = JSON.parse(this.responseText);
        let comments = document.querySelector('.comments_wrap')
  
      }
    }

    xmlhttp.open("GET", "../actions/action_add_comment.php?message_id=" + message_id + "&text=" + value, true);
    xmlhttp.send();
  }
  
  function ready() {
    let sendButton = document.querySelector('.send_button');
  
    sendButton.addEventListener('click', function (event) {
        event.preventDefault();
        let text = this.parentNode.querySelector(".text").value;
        let id = this.parentNode.parentNode.parentNode.dataset.id;
        add_comment(id, text);
      });
  }

  ready();