import axios from 'axios';
window.axios = axios;

import Cookies from 'js-cookie'
window.Cookies = Cookies

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
