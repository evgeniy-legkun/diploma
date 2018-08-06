import Vue from 'vue';
import VueRouter from 'vue-router'
import router from './routes/routes';

Vue.use(VueRouter);

new Vue({
    router: router,
    components: {
        'Index': require('./views/index/Index.vue')
    },
    template: '<Index></Index>',
    el: '#app'
});

