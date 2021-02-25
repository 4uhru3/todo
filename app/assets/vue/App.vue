<template>
  <div className="container">
    <nav className="navbar navbar-expand-lg navbar-light bg-light">
      <router-link
        class-name="navbar-brand"
        to="/home"
      >
        App
      </router-link>
      <button
        className="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span className="navbar-toggler-icon" />
      </button>
      <div
        id="navbarNav"
        className="collapse navbar-collapse"
      >
        <ul className="navbar-nav">
          <router-link
            class-name="nav-item"
            tag="li"
            to="/home"
            active-class="active"
          >
            <a className="nav-link">Home</a>
          </router-link>
        </ul>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
}
</script>
