function update_vote(elem, message_id, value) {
  let URL = '../api/messages.php/vote';

  let sendObj = JSON.stringify({
    "message_id": message_id,
    "value": value
  });

  ajax(URL, "POST", sendObj)
    .then(function (responseJSON) {
      elem.querySelector('.score').innerHTML = responseJSON.score;
      let button = parseInt(responseJSON.button);
      elem.querySelector('.vote_up').style.color = (button == 1) ? 'green' : 'inherit';
      elem.querySelector('.vote_down').style.color = (button == -1) ? 'red' : 'inherit';
    });
}


function color_vote(elem, message_id){
  let URL = `../api/messages.php/vote/${message_id}`;

  ajax(URL, "GET")
    .then(function (responseJSON) {
      let vote = responseJSON['vote'];
      elem.querySelector('.vote_up').style.color = (vote == 1) ? 'green' : 'inherit';
      elem.querySelector('.vote_down').style.color = (vote == -1) ? 'red' : 'inherit';
    });
}


function addVoteListener(element) {
  let upButton = element.querySelector('.vote_up');
  let downButton = element.querySelector('.vote_down');
  let id = element.dataset.id;

  upButton.addEventListener('click', function (event) {
    event.preventDefault();
    update_vote(element, id, 1);
  });

  downButton.addEventListener('click', function (event) {
    event.preventDefault();
    update_vote(element, id, -1);
  });
}