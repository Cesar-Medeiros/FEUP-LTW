function add_comment(message_id, value) {
    xmlhttp = new XMLHttpRequest();
  
    xmlhttp.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
        var responseJSON = JSON.parse(this.responseText);
  
      }
    }
    // xmlhttp.open("GET", "../actions/action_vote.php?message_id=" + message_id + "&value=" + value, true);
    xmlhttp.send();
  }
  
  function ready() {
    let sendButton = document.querySelector('.send_button');
  
    sendButton.addEventListener('click', function (event) {
        event.preventDefault();
        let message = this.parentNode.querySelector(".text").value;

      });
  }

  ready();