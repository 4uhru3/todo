<template>
  <div class="card w-100 mt-2">
    <div class="card-body">
      <div class="row">
        <div class="col text-left">
          <input
            v-if="isEditing"
            v-model="title"
            type="text"
            class="form-control"
            data-id="task.id"
          >
          <span v-if="!isEditing">{{ task.title }}</span>
          <b-icon
            v-if="task.completed"
            icon="check-circle"
            variant="success"
          />
        </div>
        <div class="col text-right">
          <b-button-group size="sm">
            <b-button
              v-if="!task.completed && !isEditing"
              variant="outline-success"
              @click="completeTask(task.id)"
            >
              <b-icon icon="check-circle" />
            </b-button>
            <b-button
              v-if="!task.completed && !isEditing"
              variant="outline-warning"
              @click="editTask()"
            >
              <b-icon icon="pencil" />
            </b-button>
            <b-button
              v-if="isEditing"
              variant="outline-primary"
              @click="saveTask(task.id)"
            >
              <b-icon icon="arrow-down" />
            </b-button>
            <b-button
              v-if="task.completed"
              variant="outline-danger"
              @click="removeTask(task.id)"
            >
              <b-icon icon="trash" />
            </b-button>
          </b-button-group>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Task",
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isEditing: false,
      title: this.$props.task.title
    }
  },
  methods: {
    async completeTask(id) {
      await this.$store.dispatch("task/complete", id);
    },
    async removeTask(id) {
      await this.$store.dispatch("task/delete", id);
    },
    editTask() {
      this.$data.isEditing = true;
    },
    async saveTask(id) {
      const result = await this.$store.dispatch("task/update", {id: id, title: this.$data.title});
      if (result !== null) {
        this.$data.isEditing = false;
      }
    }
  }
};
</script>
