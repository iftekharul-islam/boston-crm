import axios from "axios";

// export const baseUrl = process.env.VUE_APP_BOOKMEETING_BASE_API;
export const baseUrl = window.origin + '/';

export const globalHeaders = {
    headers: {
        'Access-Control-Allow-Origin': '*'
    }

};

export const createConfig = (config) => {
    let headerConfig = globalHeaders;

    if (config) {
        headerConfig.headers = Object.assign(headerConfig.headers, config);
    }

    return headerConfig;
}

export const buildQueryString = (object) => {
    let array = [];

    Object.entries(object).forEach(([key, value]) => {
        array.push(`${key}=${value}`);
    });

    return array.join('&');
}

export const sendRequest = (method_type, url, data = {}, config=null) => {
    let result;

    if (method_type === 'get') {
        let query_string = data ? buildQueryString(data) : '';

        let final_url = query_string.length ? url + '?' + query_string : url;

        result = get(final_url, config);

    } else if (method_type === 'post') {
        result = post(url, data, config)
    } else if (method_type === 'update') {
        result = update(url, data, config)
    } else {
        result = destroy(url, config)
    }
    return result;
}
export const get = ( url, config = null) => {
    console.log(baseUrl + url, 'url')
    return axios.get(baseUrl + url, createConfig(config))
        .then(response => {
            return successData(response.data);
        })
        .catch(error => {
            return errorData(error);
        })
};

export const post = (url, data, config = null) => {

    return axios.post(baseUrl + url, data, createConfig(config))
        .then(response => {
            return successData(response.data);
        })
        .catch(error => {
            return errorData(error);
        })
};

export const update = (url, data, config = null,) => {
    return axios.put(baseUrl + url, data, createConfig(config))
        .then(response => {
            return successData(response.data);
        })
        .catch(error => {
            return errorData(error);
        })
};

export const destroy = (url, config = null) => {

    return axios.delete(baseUrl + url, createConfig(config))
        .then(response => {
            return successData(response.data);
        })
        .catch(error => {
            return errorData(error);
        })
};

export const successData = (data) => {
    return {
        status_code: data.status_code,
        success: data.success,
        message: data.message,
        data: data.data
    }
}

export const errorData = (error) => {
    if (error.response.status === 422) {
        return {
            status_code: error.response.status,
            success: false,
            message: error.response.statusText,
            data: error.response.data
        }
    }
    return {
        status_code: error.response.status,
        success: false,
        message: error.message,
        data: error.response.data
    }
}
