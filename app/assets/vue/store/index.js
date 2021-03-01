import Vue from "vue";
import Vuex from "vuex";
import TaskModule from "./task";
import SecurityModule from  "./security";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    task: TaskModule,
    security: SecurityModule
  }
});
