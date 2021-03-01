import axios from "axios";

export default {
  create(title) {
    return axios.post("/api/task/create", {
      title: title
    });
  },
  update(payload) {
    return axios.post("/api/task/update/" + payload.id, {
      title: payload.title
    })
  },
  complete(id) {
    return axios.post("/api/task/complete/" + id)
  },
  delete(id) {
    return axios.post("/api/task/delete/" + id)
  },
  findAll(completed) {
    return axios.get("/api/task/list", {
      params: {
        completed: completed
      }
    });
  }
};
