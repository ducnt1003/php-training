<template>
  <vs-navbar
    v-model="activeItem"
    class="nabarx"
    text-color="rgba(7,8,8,.6)"
    active-text-color="rgba(7,8,8,1)"
  >
    <vs-navbar-item index="1">
      <router-link to="/">Home</router-link>
    </vs-navbar-item>
    <vs-navbar-item index="2">
      <router-link to="/login">Login</router-link>
    </vs-navbar-item>
    <vs-navbar-item index="3">
      <router-link to="/logout">Logout</router-link>
    </vs-navbar-item>
  </vs-navbar>
</template>
<script>
export default {
  data: () => ({
    activeItem: 0,
  }),
};
</script>
