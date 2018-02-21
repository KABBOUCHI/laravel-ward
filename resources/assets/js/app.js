import Vue from 'vue';
import axios from 'axios';
import App from './components/App.vue';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import fontawesome from '@fortawesome/fontawesome'
import brands from '@fortawesome/fontawesome-free-solid'
import faSpinner from '@fortawesome/fontawesome-free-solid/faSpinner'

fontawesome.library.add(brands, faSpinner);
Vue.component('font-awesome-icon', FontAwesomeIcon);

window.axios = axios;

new Vue({
    el: '#root',
    render: h => h(App)
});
