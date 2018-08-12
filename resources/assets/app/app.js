import Vue from 'vue';
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate';
import router from './routes/routes';

Vue.use(VueRouter);
Vue.use(VeeValidate);

new Vue({
    router: router,
    components: {
        'Index': require('./views/index/Index.vue')
    },
    template: '<Index></Index>',
    el: '#app'
});

