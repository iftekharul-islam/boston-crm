import Vue from "vue";

const months = {
    full: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
}
Vue.prototype.$months = months;

Vue.filter('moment', (date) => {
    if (date == null) {
        return '-';
    }
    let d = new Date(Date.parse(date));
    let month = months.short[d.getMonth() - 1];
    let year = d.getFullYear();
    let dates = d.getDate();
    let fullDate = `${dates} ${month}, ${year}`;
    return fullDate;
});
Vue.filter('momentTime', (date) => {
    if (date == null) {
        return '-';
    }
    let d = new Date(Date.parse(date));
    let month = months.short[d.getMonth()];
    let year = d.getFullYear();
    let dates = d.getDate();

    var hours = d.getHours();
    var minutes = d.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;

    let fullDate = `${strTime} | ${dates} ${month}, ${year}`;
    return fullDate;
});

Vue.filter('dateTime', (date) => {
    if (date == null) {
        return '-';
    }
    let d = new Date(Date.parse(date));
    let month = months.short[d.getMonth()];
    let year = d.getFullYear();
    let dates = d.getDate();

    var hours = d.getHours();
    var minutes = d.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;

    let fullDate = `${decimalNumber(dates)}-${decimalNumber(d.getMonth())}-${year} | ${strTime}`;
    return fullDate;
});

Vue.filter('onlyDate', (date) => {
    if (date == null) {
        return '-';
    }
    let d = new Date(Date.parse(date));
    let year = d.getFullYear();
    let dates = d.getDate();

    let fullDate = `${decimalNumber(dates)}-${decimalNumber(d.getMonth() + 1)}-${year}`;
    return fullDate;
});

function decimalNumber(val) {
    if (val < 10) {
        return "0" + val;
    } else {
        return val;
    }
}