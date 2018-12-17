var channel, user,  last_id, order_by, last_value, loading;

function getSettings(){
    let page_type = document.querySelector('#page_type');
    if (page_type != null) {
        channel = page_type.dataset.channel;
        user = page_type.dataset.user;
        order_by = "time";
    }
}

getSettings();
init();

function init(){
    resetSettings();
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
    loading = true;
    let URL = "../database/getPosts.php?channel=" + channel + "&user=" + user + "&order_by=" + order_by +"&last_value=" + last_value + "&last_id=" + last_id;
    console.log(order_by, last_value, last_id);
    ajax(URL, "GET")
        .then(function (responseJSON) {   
            let allStories = document.querySelector('#stories');
            let stories_arr = responseJSON;
            for (let i = 0; i < stories_arr.length; i++) {
                let post_shrink = post_html_shrink(stories_arr[i]);
                console.log(stories_arr[i]);
                last_value = stories_arr[i]['val'];
                allStories.appendChild(post_shrink);
            }
            updateLastId();
            loading = false;
            timeAgo();

        });
}


function setScrollingSettings(new_order_by, new_channel, new_user) {

    //channel
    channel = new_channel;

    //user
    user = new_user;

    //order
    setOrderSetting(new_order_by);

}

function updateLastId(){
    let stories = document.querySelectorAll('#stories aside');
    if (stories.length > 0) {
        last_id = stories[stories.length - 1].dataset.id;
    }
}

function setOrderSetting(new_order_by){
    
    let stories = document.querySelector('#stories');
    while (stories.firstChild) {
        stories.removeChild(stories.firstChild);
    }

    //order
    order_by = new_order_by;

    //reset
    resetSettings();

    loadMore();
}
function resetSettings(){
    last_id = Number.MAX_SAFE_INTEGER;
    last_value = Number.MAX_SAFE_INTEGER;
    loading = false;
}