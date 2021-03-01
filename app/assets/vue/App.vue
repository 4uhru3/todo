<template>
  <div className="container-flex">
    <b-navbar
      v-if="isAuthenticated"
      toggleable="lg"
      type="dark"
      variant="info"
    >
      <b-navbar-toggle
        target="nav-collapse"
      />
      <b-collapse
        id="nav-collapse"
        is-nav
      >
        <b-navbar-nav />
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item
            href="/api/security/logout"
          >
            Logout
          </b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <router-view />
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  computed: {
    isAuthenticated() {
      return this.$store.getters['security/isAuthenticated']
    },
  },
  created() {
    axios.interceptors.response.use(undefined, (err) => {
      return new Promise(() => {
        if (err.response.status === 401) {
          this.$router.push({path: "/login"})
        }
        throw err;
      });
    });
  },
}
</script>
