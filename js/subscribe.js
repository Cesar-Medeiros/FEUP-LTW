let subscribeButton = document.querySelector('.button_subscribe')
subscribeButton.addEventListener('click', function(event){
  let channel_id = this.dataset.id;
  event.preventDefault();
  subscribe(this, channel_id);
})

function subscribe(elem, channel) {
  let URL = '../database/subscribe.php?channel='+channel;
  ajax(URL, "GET")
    .then(function (responseJSON) {
      if (elem.innerHTML == 'SUBSCRIBE')
          elem.innerHTML = 'UNSUBSCRIBE';
      else elem.innerHTML = 'SUBSCRIBE';

      let subscribers = elem.parentNode.querySelector('.subscribers');
      subscribers.innerHTML = ' '+responseJSON.num_subscribers+ ' subscribers ';

      /* <?=$channel_info['num_subscribers']?> subscribers */
      // elem.querySelector('.score').innerHTML = responseJSON.score;
      // let button = parseInt(responseJSON.button);
      // elem.querySelector('.vote_up').style.color = (button == 1) ? 'green' : 'inherit';
      // elem.querySelector('.vote_down').style.color = (button == -1) ? 'red' : 'inherit';
    });
}