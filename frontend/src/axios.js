
import axios from 'axios';

axios.defaults.baseURL = process.env.VUE_APP_API_LOCATION;
axios.defaults.headers.common.Accept = 'application/json';

window.axios = axios;
