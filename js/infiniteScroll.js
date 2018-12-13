var stories = document.querySelectorAll('#stories aside');
var min_id = -1;
if (stories.length > 0) {
    var min_id = stories[stories.length - 1].dataset.id;
}

var loading = false;

function loadMore() {
    let URL = "../database/getPosts.php?min_id=" + min_id + "&channel_id=" + "all";

    ajax(URL, "GET")
        .then(function (responseJSON) {    

            let allStories = document.querySelector('#stories');
            let stories_arr = responseJSON;
            for (let i = 0; i < stories_arr.length; i++) {
                let post_shrink = post_html(stories_arr[i]);
                allStories.appendChild(post_shrink);
            }
            let stories = document.querySelectorAll('#stories aside');
            min_id = stories[stories.length - 1].dataset.id;
            loading = false;responseJSON

        })
        .catch(function () {});
}

document.addEventListener("scroll", function () {

    let scrollHeight = Math.max(
        document.body.scrollHeight, document.documentElement.scrollHeight,
        document.body.offsetHeight, document.documentElement.offsetHeight,
        document.body.clientHeight, document.documentElement.clientHeight
    );
    let scrollOffset = 1000;

    if ((window.pageYOffset + scrollOffset) > scrollHeight && !loading) {
        loading = true;
        loadMore();
    }
});


function story_html(story) {
    let div = document.createElement('div');
    div.innerHTML = `
            <article class="story">        
                <header>
                <a class="title" href="../pages/post.php?id=${story['message_id']}"> ${story['title']}</a>
                </header>
                <div class="content-wrap">
                <p class="text">${story['text']}</p>
                <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg"
                    alt="image">
                </div>
                <a href="../pages/post.php?id=${story['message_id']}" class="readmore">Read more</a>
            </article>
        `;
    return div.firstElementChild
}


function story_info_html(story) {
    let div = document.createElement('div');
    div.innerHTML = `
        <aside class="story_info" data-id="${story['message_id']}">
            <div class="channel">${story['channel']}</div>
              <div class="vote">
                  <a class="vote_up" data-id="${story['message_id']}" href=""><i class="fas fa-angle-up"></i></a>
                  <a class="vote_down" data-id="${story['message_id']}" href=""><i class="fas fa-angle-down"></i></a>
              </div>
              <a class="author_info" href="../pages/profile.php?user_id=${story['user_id']}">
                  <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;">
                  <label class="user_name">${story['username']}</label>
              </a>
              <div class="score">${story['score']}</div>
              <div class="comments">${story['comments']}</div>
              <div class="date">${story['date']}</div>
            </div>
        </aside>
        `;
    return div.firstElementChild;
}

function post_html(story) {
    let post_shrink = document.createElement('div');
    post_shrink.className = "post shrink";
    let story_elem = story_html(story);
    let story_info_elem = story_info_html(story);
    post_shrink.appendChild(story_elem);
    post_shrink.appendChild(story_info_elem);
    return post_shrink;
}