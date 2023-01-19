//header
import axios from "axios";

//axios.defaults.baseURL = import.meta.env.VITE_API_HOST+import.meta.env.VITE_API_BASE_URL;


axios.defaults.headers.common['Authorization'] = 'Bearer ' + import.meta.env.VITE_API_TOKEN
axios.defaults.headers.common['Content-Type'] = 'application/json;charset=UTF-8';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Access-Control-Allow-Methods'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Credentials'] = 'true';
