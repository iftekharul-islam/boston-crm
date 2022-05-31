import Vue from 'vue';
import store from '../store/index';

export const Bus = new Vue();

function apiPost(url, data) {
    const headers = {
        'Content-Type': 'application/json',
    }
    return new Promise((res, rej) => {
        axios.post(`/api/${url}`, data, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

export function host(url) {
    return window.location.origin + '/' + url;
}

function apiGet(url, data) {
    const headers = {
        'Content-Type': 'application/json',
    }
    return new Promise((res, rej) => {
        axios.get(`/api/${url}`, data, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

export function boston() {
    return "Boston CRM";
}


function authGet(url, data = null) {
    const token = `Bearer ${store.state.token}`;
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': token,
    }
    return new Promise((res, rej) => {
        axios.get('/api/' + url, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

function authPost(url, data) {
    const token = `Bearer ${store.state.token}`;
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': token,
    }
    return new Promise((res, rej) => {
        axios.post('/api/' + url, data, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

function get(url, headerToken = null) {
    let headers = {
        'Content-Type': 'application/json',
        "Access-Control-Allow-Origin": '*',
        "Access-Control-Allow-Methods": 'GET'
    }
    if (headerToken) {
        headers.Authorization = headerToken;
    }
    return new Promise((res, rej) => {
        axios.get(url, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

function post(url, data, headerToken = null) {
    let headers = {
        'Content-Type': 'application/json',
    }
    if (headerToken) {
        headers.Authorization = headerToken;
    }
    return new Promise((res, rej) => {
        axios.post(url, data, { headers })
            .then(response => {
                return res(response.data);
            })
            .catch(error => {
                return rej(error);
            });
    });
}

export function head_script(src) {
    if (document.querySelector("script[src='" + src + "']")) {
        return;
    }
    let script = document.createElement("script");
    script.setAttribute("src", src);
    script.setAttribute("defer");
    script.setAttribute("type", "text/javascript");
    document.head.appendChild(script);
}

export function body_script(src) {
    if (document.querySelector("script[src='" + src + "']")) {
        return;
    }
    let script = document.createElement("script");
    script.setAttribute("src", src);
    // script.setAttribute("defer");
    script.setAttribute("type", "text/javascript");
    document.body.appendChild(script);
}

export function del_script(src) {
    let el = document.querySelector("script[src='" + src + "']");
    if (el) {
        el.remove();
    }
}

export function head_link(href) {
    if (document.querySelector("link[href='" + href + "']")) {
        return;
    }
    let link = document.createElement("link");
    link.setAttribute("href", href);
    link.setAttribute("rel", "stylesheet");
    link.setAttribute("media", "all");
    link.setAttribute("type", "text/css");
    document.head.appendChild(link);
}

export function body_link(href) {
    if (document.querySelector("link[href='" + href + "']")) {
        return;
    }
    let link = document.createElement("link");
    link.setAttribute("href", href);
    link.setAttribute("rel", "stylesheet");
    link.setAttribute("media", "all");
    link.setAttribute("type", "text/css");
    document.body.appendChild(link);
}

export function del_link(href) {
    let el = document.querySelector("link[href='" + href + "']");
    if (el) {
        el.remove();
    }
}

export function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
export function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
export function removeCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

export const getPostcodeByLatLng = async(lat, lng) => {
    if (!lat || !lng) return null
    const res = await fetch(`https://api.postcodes.io/postcodes?lon=${lng}&lat=${lat}`);
    return res;
}

export {
    apiPost,
    apiGet,
    authGet,
    authPost,
    get,
    post
};
