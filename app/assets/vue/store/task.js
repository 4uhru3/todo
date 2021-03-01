import TaskAPI from "../api/task";

const
  CREATING_TASK = "CREATING_TASK",
  CREATING_TASK_SUCCESS = "CREATING_TASK_SUCCESS",
  CREATING_TASK_ERROR = "CREATING_TASK_ERROR",
  UPDATING_TASK = "UPDATING_TASK",
  UPDATING_TASK_SUCCESS = "UPDATING_TASK_SUCCESS",
  UPDATING_TASK_ERROR = "UPDATING_TASK_ERROR",
  COMPLETING_TASK = "COMPLETING_TASK",
  COMPLETING_TASK_SUCCESS = "COMPLETING_TASK_SUCCESS",
  COMPLETING_TASK_ERROR = "COMPLETING_TASK_ERROR",
  DELETING_TASK = "DELETING_TASK",
  DELETING_TASK_SUCCESS = "DELETING_TASK_SUCCESS",
  DELETING_TASK_ERROR = "DELETING_TASK_ERROR",
  FETCHING_TASKS = "FETCHING_TASKS",
  FETCHING_TASKS_SUCCESS = "FETCHING_TASKS_SUCCESS",
  FETCHING_TASKS_ERROR = "FETCHING_TASKS_ERROR";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    tasks: []
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    hasTasks(state) {
      return state.tasks.length > 0;
    },
    tasks(state) {
      return state.tasks;
    }
  },
  mutations: {
    [CREATING_TASK](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_TASK_SUCCESS](state, task) {
      state.isLoading = false;
      state.error = null;
      state.tasks.unshift(task);
    },
    [CREATING_TASK_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [UPDATING_TASK](state) {
      state.isLoading = true;
      state.error = null;
    },
    [UPDATING_TASK_SUCCESS](state, updatedTask) {
      state.isLoading = false;
      state.error = null;
      let index = state.tasks.findIndex(item => item.id === updatedTask.id);
      state.tasks.splice(index, 1, updatedTask)
    },
    [UPDATING_TASK_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [COMPLETING_TASK](state) {
      state.isLoading = true;
      state.error = null;
    },
    [COMPLETING_TASK_SUCCESS](state, completedTask) {
      state.isLoading = false;
      state.error = null;
      let index = state.tasks.findIndex(item => item.id === completedTask.id);
      state.tasks.splice(index, 1, completedTask)
    },
    [COMPLETING_TASK_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [DELETING_TASK](state) {
      state.isLoading = true;
      state.error = null;
    },
    [DELETING_TASK_SUCCESS](state, deletedTask) {
      state.isLoading = false;
      state.error = null;
      let index = state.tasks.findIndex(item => item.id === deletedTask.id);
      state.tasks.splice(index, 1)
    },
    [DELETING_TASK_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [FETCHING_TASKS](state) {
      state.isLoading = true;
      state.error = null;
      state.tasks = [];
    },
    [FETCHING_TASKS_SUCCESS](state, tasks) {
      state.isLoading = false;
      state.error = null;
      state.tasks = tasks;
    },
    [FETCHING_TASKS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.tasks = [];
    }
  },
  actions: {
    async create({ commit }, task) {
      commit(CREATING_TASK);
      try {
        let response = await TaskAPI.create(task);

        if (response.data.success) {
          commit(CREATING_TASK_SUCCESS, response.data.data);
          return response.data.data;
        } else {
          commit(CREATING_TASK_ERROR, response.data.errors);
          return null;
        }
      } catch (error) {
        commit(CREATING_TASK_ERROR, error);
        return null;
      }
    },
    async update({ commit }, title, id) {
      commit(UPDATING_TASK);
      try {
        let response = await TaskAPI.update(title, id);

        if (response.data.success) {
          commit(UPDATING_TASK_SUCCESS, response.data.data);
          return response.data.data;
        } else {
          commit(UPDATING_TASK_ERROR, response.data.errors);
          return null;
        }
      } catch (error) {
        commit(UPDATING_TASK_ERROR, error);
        return null;
      }
    },
    async complete({ commit }, id) {
      commit(COMPLETING_TASK);
      try {
        let response = await TaskAPI.complete(id);

        if (response.data.success) {
          commit(COMPLETING_TASK_SUCCESS, response.data.data);
          return response.data.data;
        } else {
          commit(COMPLETING_TASK_ERROR, response.data.errors);
          return null;
        }
      } catch (error) {
        commit(COMPLETING_TASK_ERROR, error);
        return null;
      }
    },
    async delete({ commit }, id) {
      commit(DELETING_TASK);
      try {
        let response = await TaskAPI.delete(id);

        if (response.data.success) {
          commit(DELETING_TASK_SUCCESS, response.data.data);
          return response.data.data;
        } else {
          commit(DELETING_TASK_ERROR, response.data.errors);
          return null;
        }
      } catch (error) {
        commit(DELETING_TASK_ERROR, error);
        return null;
      }
    },
    async findAll({ commit }, complete) {
      commit(FETCHING_TASKS);
      try {
        let response = await TaskAPI.findAll(complete);

        if (response.data.success) {
          commit(FETCHING_TASKS_SUCCESS, response.data.data);
          return response.data.data;
        } else {
          commit(FETCHING_TASKS_ERROR, response.data.errors);
          return null;
        }
      } catch (error) {
        commit(FETCHING_TASKS_ERROR, error);
        return null;
      }
    }
  }
};
