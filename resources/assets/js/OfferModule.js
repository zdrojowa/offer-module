import Vue from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import MultiSelect from 'vue-multiselect'
import draggable from 'vuedraggable';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import { Datetime } from 'vue-datetime';

window.axios = require('axios');

Vue.use(CKEditor);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.component('multiselect', MultiSelect);
Vue.component('draggable', draggable);
Vue.component('datetime', Datetime);
Vue.component('media-selector', require('./components/media-selector.vue').default);
Vue.component('nested', require('./components/nested.vue').default);
Vue.component('list', require('./components/list.vue').default);
Vue.component('editor', require('./components/editor.vue').default);
Vue.component('program', require('./components/program.vue').default);
Vue.component('pack', require('./components/pack.vue').default);
Vue.component('files', require('./components/files.vue').default);
Vue.component('cost', require('./components/cost.vue').default);
Vue.component('convenience', require('./components/convenience.vue').default);
Vue.component('offer-convenience', require('./components/offer-convenience.vue').default);
Vue.component('objects', require('./components/objects.vue').default);

const app = new Vue({
    el: '#app'
});

