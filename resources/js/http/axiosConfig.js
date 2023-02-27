import axios from "axios";
import config from "../config/config"

const instance = axios.create({
    baseURL: config.APP_BASE_URL,
    headers: {
        'Access-Control-Allow-Origin': '*'
    }
});

export default instance;
