function update_vote(message_id, value) {
  let URL = "../actions/action_vote.php?message_id=" + message_id + "&value=" + value;

  ajax(URL, "GET")
    .then(function (responseJSON) {
      let info = document.querySelector('.story_info[data-id=\'' + message_id + '\']');
      info.querySelector('.score').innerHTML = responseJSON.score;

      let color_down = 'inherit';
      let color_up = 'inherit';

      switch (parseInt(responseJSON.button)) {
        case -1:
          color_down = 'red';
          break;
        case 1:
          color_up = 'green';
          break;
      }

      info.querySelector('.vote_down').style.color = color_down;
      info.querySelector('.vote_up').style.color = color_up;
    })
    .catch();
}

function ready() {
  let upButtons = document.querySelectorAll('.vote_up');

  upButtons.forEach(function (item) {
    item.addEventListener('click', function (event) {
      event.preventDefault();
      update_vote(item.dataset.id, 1);
    });
  });


  let vote_down = document.querySelectorAll('.vote_down');

  vote_down.forEach(function (item) {
    item.addEventListener('click', function (event) {
      event.preventDefault();
      update_vote(item.dataset.id, -1);
    });
  });
}
ready();

function addVoteHandler(vote_element){


}