<template>
  <div class="container">
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
      <div class="col-sm" />
      <div class="col-sm">
        <div
          class="card"
          style="width: 18rem; box-shadow: 3px 5px 5px;"
        >
          <div class="card-body">
            <form>
              <div class="form-group">
                <label for="loginInput">Логин</label>
                <input
                  id="loginInput"
                  v-model="login"
                  type="text"
                  class="form-control"
                >
              </div>
              <div class="form-group">
                <label for="passwordInput">Пароль</label>
                <input
                  id="passwordInput"
                  v-model="password"
                  type="password"
                  class="form-control"
                >
              </div>
              <div class="text-center">
                <b-button
                  type="submit"
                  variant="primary"
                  :disabled="login.length === 0 || password.length === 0 || isLoading"
                  @click="performLogin()"
                >
                  <b-spinner
                    v-if="isLoading"
                    small
                    label="Small Spinner"
                    type="grow"
                    variant="light"
                  />
                  Войти
                </b-button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm" />
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      login: "",
      password: "",
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    },
    error() {
      return this.$store.getters["security/error"];
    }
  },
  created() {
    let redirect = this.$route.query.redirect;

    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({path: redirect});
      } else {
        this.$router.push({path: "/tasks"});
      }
    }
  },
  methods: {
    async performLogin() {
      let payload = {login: this.$data.login, password: this.$data.password},
        redirect = this.$route.query.redirect;

      await this.$store.dispatch("security/login", payload);
      if (!this.$store.getters["security/hasError"]) {
        if (typeof redirect !== "undefined") {
          await this.$router.push({path: redirect});
        } else {
          await this.$router.push({path: "/tasks"});
        }
      }
    },
  }
}
</script>
