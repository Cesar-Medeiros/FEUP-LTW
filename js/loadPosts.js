function loadPosts(order_by) {
    var stories = document.querySelector('#stories');
    while (stories.firstChild) {
        stories.removeChild(stories.firstChild);
    }
    xmlhttp = new XMLHttpRequest();
  
    xmlhttp.addEventListener("load", function () {
        if (this.responseText == ""){
            return;
        } 

        let responseJSON = JSON.parse(this.responseText);
        let stories_arr = responseJSON;
        for (let i = 0; i < stories_arr.length; i++) {
            let post_shrink = post_html_shrink(stories_arr[i]);
            stories.appendChild(post_shrink);
        }
    });
    xmlhttp.open("GET", "../database/getPosts.php?max_id=" + Number.MAX_SAFE_INTEGER + "&channel_id=" + 'all' + "&order_by="+order_by + "&max=" + Number.MAX_SAFE_INTEGER, true);
    xmlhttp.send();
}