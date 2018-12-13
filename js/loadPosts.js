function loadPosts(order_by) {
    console.log(order_by);
    var stories = document.querySelector('#stories');
    while (stories.firstChild) {
        stories.removeChild(stories.firstChild);
    }
    xmlhttp = new XMLHttpRequest();
  
    xmlhttp.addEventListener("load", function () {
        console.log(this.responseText)
        if (this.responseText == ""){
            return;
        } 
        let stories_arr = JSON.parse(this.responseText);
        for(let i=0; i< stories_arr.length; i++){
            let post_shrink = document.createElement('div');
            post_shrink.className = "post shrink";

            /*STORY */
            let story = document.createElement('article');
            story.className = "story";
            let title = document.createElement('header');
            let titleContent = document.createElement('a');
            titleContent.href = "../pages/post.php?id=" + stories_arr[i]['message_id'];
            titleContent.className = "title";
            titleContent.textContent= stories_arr[i]['title'];
            title.appendChild(titleContent);
            story.appendChild(title);
            let content_wrap = document.createElement('div');
            content_wrap.className = "content_wrap";
            let text = document.createElement('p');
            text.className = "text";
            text.textContent = stories_arr[i]['text'];
            content_wrap.appendChild(text);
            story.appendChild(content_wrap);


            let read_more = document.createElement('a');
            read_more.href = "../pages/post.php?id='+ stories_arr[i]['message_id']+ '";
            read_more.className = "readmore";
            read_more.innerHTML = 'Read more';
            story.append(read_more);
            post_shrink.appendChild(story);
        

            /*STORY_INFO*/
            let story_info = document.createElement('aside');
            story_info.className = "story_info";
            story_info.dataset.id = stories_arr[i]['message_id'];
            let channel = document.createElement('div');
            channel.className = 'channel';
            channel.innerHTML = stories_arr[i]['channel'];
            story_info.appendChild(channel);
            let vote = document.createElement('div');
            vote.className = "vote";
            vote.innerHTML ='<a class="vote_up" data-id=' + stories_arr[i]['message_id'] + 'href=""><i class="fas fa-angle-up"></i></a> <a class="vote_down" data-id=' + stories_arr[i]['message_id'] +  'href=""><i class="fas fa-angle-down"></i></a>';
            story_info.appendChild(vote);
            let author_info = document.createElement('a');
            author_info.className = "author_info";
            author_info.innerHTML = '<img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;"> <label class="user_name">' + stories_arr[i]['username'];
            author_info.href = "../pages/profile.php?user_id=" + stories_arr[i]['user_id'];
            story_info.appendChild(author_info);
            let score = document.createElement('div');
            score.className = "score";
            score.innerHTML = stories_arr[i]['score'];
            story_info.appendChild(score);
            let comments = document.createElement('div');
            comments.className ="comments";
            comments.innerHTML = stories_arr[i]['comments'];
            story_info.appendChild(comments);
            let date = document.createElement('div');
            date.className = "date";
            date.innerHTML = timeSince(stories_arr[i]['date']);
            story_info.appendChild(date);
            
            post_shrink.appendChild(story_info);
            console.log(stories);
            stories.appendChild(post_shrink);
        }
    });
    xmlhttp.open("GET", "../database/getPosts.php?max_id=" + Number.MAX_SAFE_INTEGER + "&channel_id=" + 'all' + "&order_by="+order_by + "&max=" + Number.MAX_SAFE_INTEGER, true);
    xmlhttp.send();
}