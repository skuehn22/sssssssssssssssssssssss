import { createApp } from 'vue';
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import 'bootstrap/dist/css/bootstrap.css'
import axios from 'axios'
import { createVfm } from 'vue-final-modal'
import 'vue-final-modal/style.css'
import '../sass/app.scss'
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import App from './components/App.vue'
import router from './router'

const vfm = createVfm()

const app = createApp(App);
app.use(router, axios, vfm);
app.mount('#vue-app');
