function ajax(url, methodType, sendObj) {
    var promiseObj = new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open(methodType, url, true);
        xhr.send(sendObj);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                var resp = xhr.responseText;
                var respJson = (resp === '') ? '' :  JSON.parse(resp);
                if (xhr.status === 200) {
                    resolve(respJson);
                } else {
                    var respJson = JSON.parse(resp);
                    reject({errorCode: xhr.status, info: respJson});
                }
            }
        }
    });
    return promiseObj;
}




class StateSwitch {

    constructor() {
        this.state = 'CLOSE';
    }

    changeState() {
        if (this.state == 'CLOSE') {
            this.state = 'OPEN';
        } else {
            this.state = 'CLOSE';
        }
        return this;
    }

    getState() {
        return this.state;
    }

    setOpenState() {
        this.state = 'OPEN';
    }

    setCloseState() {
        this.state = 'CLOSE';
    }

}



class ReplySwitch extends StateSwitch{

    static instance(id) {
        if (ReplySwitch.comments[id] == undefined) {
            ReplySwitch.comments[id] = new ReplySwitch();
        }
        return ReplySwitch.comments[id];
    }

}
ReplySwitch.comments = [];


class Comment extends StateSwitch{

    static instance(id) {
        if (Comment.comments[id] == undefined) {
            Comment.comments[id] = new Comment();
        }
        return Comment.comments[id];
    }

}
Comment.comments = [];






function timeAgo() {
    var templates = {
        prefix: "",
        suffix: " ago",
        seconds: "Just now",
        minute: "about a minute",
        minutes: "%d minutes",
        hour: "about an hour",
        hours: "about %d hours",
        day: "a day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "about a year",
        years: "%d years"
    };
    var template = function (t, n) {
        return templates[t] && templates[t].replace(/%d/i, Math.abs(Math.round(n)));
    };

    var timer = function (time) {
        if (!time) return;
        time = time.replace(/\.\d+/, ""); // remove milliseconds
        time = time.replace(/-/, "/").replace(/-/, "/");
        time = time.replace(/T/, " ").replace(/Z/, " UTC");
        time = time.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
        time = new Date(time * 1000 || time);

        var now = new Date();
        var seconds = ((now.getTime() - time) * .001) >> 0;
        var minutes = seconds / 60;
        var hours = minutes / 60;
        var days = hours / 24;
        var years = days / 365;

        return (seconds < 45 && template('seconds', seconds)) || 
            templates.prefix + ( 
            seconds < 90 && template('minute', 1) || 
            minutes < 45 && template('minutes', minutes) || 
            minutes < 90 && template('hour', 1) ||
            hours < 24 && template('hours', hours) || 
            hours < 42 && template('day', 1) || 
            days < 30 && template('days', days) || 
            days < 45 && template('month', 1) || 
            days < 365 && template('months', days / 30) || 
            years < 1.5 && template('year', 1) || 
            template('years', years)
            ) + templates.suffix;
    };

    var elements = document.getElementsByClassName('timeago');
    for (var i in elements) {
        var $this = elements[i];
        if (typeof $this === 'object') {
            $this.innerHTML = timer($this.getAttribute('title') || $this.getAttribute('datetime'));
        }
    }
    setTimeout(timeAgo, 60000);

};