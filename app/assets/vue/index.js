import Vue from "vue";
import App from "./App";
import router from "./router";
import store from "./store";
import { BootstrapVue, IconsPlugin, AlertPlugin} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(AlertPlugin);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

new Vue({
  components: {App},
  template: "<App/>",
  router,
  store
}).$mount("#app");
