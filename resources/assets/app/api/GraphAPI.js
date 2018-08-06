import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.use(VueResource);

export default {
    exec(query) {
        return Vue.http.get('/graphql/?query=' + encodeURI(query));
    }
}