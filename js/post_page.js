/*
Dependencies: 
    + post.js
    + utilities.js
*/

draw_post();

function draw_post(){
    let post_wrap = document.getElementsByClassName('post_wrap')[0];
    let message_id = post_wrap.dataset.id;

    let URL = `../api/messages.php/${message_id}`;

    ajax(URL, "GET")
        .then(function (responseJSON) {
            let story = responseJSON;
            let post_html_elem = post_html(story);
            post_wrap.appendChild(post_html_elem);
            timeAgo();
        })
        .catch(function () {});
}
