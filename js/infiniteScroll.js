var stories = document.querySelectorAll('#stories aside');
var min_id = Number.MAX_SAFE_INTEGER;

if (stories.length > 0) {
    var min_id = stories[stories.length - 1].dataset.id;
}
var loading = false;

init();

function init(){
    loadMore();

    document.addEventListener("scroll", function () {

        let scrollHeight = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
        );
        let scrollOffset = window.innerHeight + window.innerHeight/3;

        if ((window.pageYOffset + scrollOffset) > scrollHeight && !loading) {
            loading = true;
            loadMore();
        }
    });
}


function loadMore() {
    let URL = "../database/getPosts.php?min_id=" + min_id + "&channel_id=" + "all";

    ajax(URL, "GET")
        .then(function (responseJSON) {    

            let allStories = document.querySelector('#stories');
            let stories_arr = responseJSON;
            for (let i = 0; i < stories_arr.length; i++) {
                let post_shrink = post_html_shrink(stories_arr[i]);
                allStories.appendChild(post_shrink);
            }
            let stories = document.querySelectorAll('#stories aside');
            min_id = stories[stories.length - 1].dataset.id;
            loading = false;
            timeAgo();

        });
}