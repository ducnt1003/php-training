<template>
  <div class="container">
    <!-- <vs-row vs-align="center"
  vs-type="flex" vs-justify="center" vs-w="12" >
    <vs-col
      type="flex"
      vs-justify="center"
      vs-align="center"
      vs-lg="6"
      vs-sm="6"
      vs-xs="10"
    >
    <vs-spacer></vs-spacer>
      <vs-card fixedHeight>
        <div slot="header">
          <h3>Login</h3>
        </div>
        <form v-on:submit.prevent="login">
          <div class="centerx">
            <vs-row vs-justify="center">
              <vs-input
                size="large"
                label-placeholder="Email"
                v-model="user.email"
              />
            </vs-row>
            <br />
            <vs-row vs-justify="center">
              <vs-input
                size="large"
                label-placeholder="Password"
                v-model="user.password"
                type="password"
              />
            </vs-row>
          </div>
          <br />
          <div>
            <vs-row vs-justify="center" vs-align="center">
              <vs-button button="submit" size="large" type="gradient" color="primary"
                >Login</vs-button
              >
            </vs-row>
          </div>
        </form>
      </vs-card>
    </vs-col>
  </vs-row> -->
    <div class="row">
      <div class="col-md-6 mt-5 mx-auto">
        <vs-card fixedHeight>
          <div slot="header">
            <h3>Login</h3>
          </div>
          <form v-on:submit.prevent="login">
            <div class="centerx">
              <vs-row vs-justify="center">
                <vs-input
                  size="large"
                  label-placeholder="Email"
                  v-model="user.email"
                  :danger="checkMail"
                  :danger-text="textMail"
                />
              </vs-row>
              <br />
              <vs-row vs-justify="center">
                <vs-input
                  size="large"
                  label-placeholder="Password"
                  v-model="user.password"
                  :danger="checkPass"
                  :danger-text="textPass"
                  type="password"
                />
              </vs-row>
            </div>
            <br />
            <div>
              <vs-row vs-justify="center" vs-align="center">
                <vs-button
                  button="submit"
                  size="large"
                  type="gradient"
                  color="primary"
                  >Login</vs-button
                >
              </vs-row>
            </div>
          </form>
        </vs-card>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: {},
      checkMail: false,
      textMail: "",
      checkPass: false,
      textPass: "",
    };
  },
  methods: {
    login() {
      let uri = "http://127.0.0.1:8000/api/auth/login";
      if (this.checkForm()) {
        this.axios
          .post(uri, this.user)
          .then((res) => {
            localStorage.setItem("usertoken", res.data.access_token);
            this.user = {};
            this.$router.push({ name: "example" });
          })
          .catch((err) => {
              console.log(err.response);
            if (err.response.status == 422) {
              if (err.response.data.errors.email != null) {
                this.checkMail = true;
                this.textMail = err.response.data.errors.email[0];
              }else{
                  this.checkMail = false;
              }
              if (err.response.data.errors.password != null) {
                this.checkPass = true;
              }else{
                  this.checkPass = false;
                  this.textPass = err.response.data.errors.password[0];
              }
            }

          });
      }
    },
    checkForm() {
      let errors = 0;
      if (this.user["email"] == null) {
        this.checkMail = true;
        this.textMail = "Email is required";
        errors++;
      }
      if (this.user["password"] == null) {
        this.checkPass = true;
        this.textPass = "Password is required";
        errors++;
      }
      if (errors > 0) return false;
      return true;
    },
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
  font-family: "Roboto", sans-serif;
}
</style>

