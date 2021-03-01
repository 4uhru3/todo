<template>
  <div>
    <b-alert
      v-if="hasError"
      variant="danger"
      show
      class="mt-3"
      dismissible
    >
      {{ error }}
    </b-alert>
    <div class="row mt-5">
      <div class="col" />
      <div class="col-6">
        <b-nav
          pills
          align="center"
        >
          <b-nav-item
            v-for="(item, itemIndex) in navs"
            :key="itemIndex"
            href="#"
            :active="itemIndex === activeItemIndex"
            @click="fetchTasks(item.completed, itemIndex)"
          >
            {{ item.title }}
          </b-nav-item>
          <b-nav-form class="ml-auto">
            <b-form-input
              v-model="title"
              aria-label="Input"
              class="mr-1"
            />
            <b-button
              type="submit"
              :disabled="title.length === 0 || isLoading"
              variant="primary"
              @click="createTask()"
            >
              Создать
            </b-button>
          </b-nav-form>
        </b-nav>
        <div class="text-center">
          <div
            v-if="isLoading"
            style="margin-top: 100px"
          >
            <b-spinner
              large
              label="Small Spinner"
              variant="primary"
            />
          </div>
          <div
            v-else-if="!hasTasks"
            class="row col"
          >
            No tasks!
          </div>
          <div
            v-for="task in tasks"
            v-else
            :key="task.id"
          >
            <task :task="task" />
          </div>
        </div>
      </div>
      <div class="col" />
    </div>
  </div>
</template>

<script>
import Task from "../components/Task";

export default {
  name: "Tasks",
  components: {
    Task
  },
  data() {
    return {
      title: "",
      activeItemIndex: 0,
      navs: [
        {
          completed: null,
          title: "Все"
        },
        {
          completed: 1,
          title: "Завершенные"
        },
        {
          completed: 0,
          title: "Не завершенные"
        },
      ]
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["task/isLoading"];
    },
    hasError() {
      return this.$store.getters["task/hasError"];
    },
    error() {
      return this.$store.getters["task/error"];
    },
    hasTasks() {
      return this.$store.getters["task/hasTasks"];
    },
    tasks() {
      return this.$store.getters["task/tasks"];
    }
  },
  created() {
    this.$store.dispatch("task/findAll");
  },
  methods: {
    async createTask() {
      const result = await this.$store.dispatch("task/create", this.$data.title);
      if (result !== null) {
        this.$data.title = "";
      }
    },
    async fetchTasks(completed, itemIndex) {
      const result = await this.$store.dispatch("task/findAll", completed);
      if (result !== null) {
        this.$data.activeItemIndex = itemIndex;
      }
    }
  }
};
</script>
