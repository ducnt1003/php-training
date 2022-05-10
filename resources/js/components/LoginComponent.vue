<template>
  <vs-row vs-justify="center">
    <vs-col
      type="flex"
      vs-justify="center"
      vs-align="center"
      vs-lg="6"
      vs-sm="6"
      vs-xs="10"
    >
      <vs-card actionable fixedHeight>
        <div slot="header">
          <h3>Login</h3>
        </div>
        <div class="centerx">
          <vs-row vs-justify="center">
            <vs-input
              size="large"
              label-placeholder="Username"
              v-model="username"
            />
          </vs-row>
          <br>
          <vs-row vs-justify="center">
            <vs-input
              size="large"
              label-placeholder="Password"
              v-model="password"
              type="password"
            />
          </vs-row>
        </div>
        <br>
        <div>
          <vs-row vs-justify="center" vs-align="center">
            <vs-button size="large" type="gradient" color="primary">Login</vs-button>
          </vs-row>
        </div>
      </vs-card>
    </vs-col>
  </vs-row>
</template>
<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
};
</script>
<style>
body {
  min-height: 100vh;
  background-image: radial-gradient(
    circle 621px at 25.3% 13.8%,
    rgba(255, 255, 255, 1) 0%,
    rgba(234, 236, 255, 1) 90%
  );
  margin-top: 50px;
  font-family: "Roboto", sans-serif;
}
</style>

