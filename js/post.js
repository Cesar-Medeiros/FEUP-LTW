function story_html(story) {
    let div = document.createElement('div');
    div.innerHTML = `
            <article class="story">        
                <header>
                    <a class="title" href="../pages/post.php?id=${story['message_id']}"> ${story['title']}</a>
                </header>
                <div class="content-wrap">
                    <p class="text">${story['text']}</p>
                    <img class="image" src="../resources/images/medium/${story['message_id']}.jpeg" onerror="this.style.display='none'" alt="image"></img>
                </div>
                <a href="../pages/post.php?id=${story['message_id']}" class="readmore">Read more</a>
            </article>
        `;
    return div.firstElementChild;
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
                  <img class="user_img" src="../resources/profile/medium/${story['user_id']}.jpg" onerror="this.src='../resources/profile/default.png'"style="height:50px;width:50px;border-radius:50%;">
                  <label class="user_name">${story['username']}</label>
              </a>
              <div class="score">${story['score']}</div>
              <div class="comments">${story['comments']}</div>
              <div class="date timeago" datetime="${story['date']}"></div>
            </div>
        </aside>
        `;
    return div.firstElementChild;
}


function post_html(story) {
    let post = document.createElement('div');
    post.className = "post";
    let story_elem = story_html(story);
    let story_info_elem = story_info_html(story);
    post.appendChild(story_elem);
    post.appendChild(story_info_elem);

    color_vote(story_info_elem, story_info_elem.dataset.id);
    addVoteListener(story_info_elem);
    return post;
}

function post_html_shrink(story) {
    let post_html_shrink = post_html(story);
    post_html_shrink.classList.add("shrink");
    return post_html_shrink;
}