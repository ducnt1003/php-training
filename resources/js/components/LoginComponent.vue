<template>
  <div class="container">
    <vs-popup
      title="Login falled"
      :active.sync="popupActivo"
    >
      <p>
       {{ popup_content }}
      </p>
    </vs-popup>
    <div class="row">
      <div class="col-md-6 mt-5 mx-auto">
        <vs-card actionable fixedHeight>
          <div slot="header">
            <h3>Login</h3>
          </div>
          <ValidationObserver v-slot="{ invalid }">
            <form v-on:submit.prevent="login">
              <div class="centerx">
                <vs-row vs-justify="center">
                  <ValidationProvider
                    rules="email|required"
                    v-slot="{ errors }"
                  >
                    <vs-input
                      size="large"
                      label-placeholder="Email"
                      v-model="user.email"
                      :danger="`${errors}` ? true : false"
                      :danger-text="errors[0]"
                    />
                  </ValidationProvider>
                </vs-row>
                <br />
                <vs-row vs-justify="center">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <vs-input
                      size="large"
                      label-placeholder="Password"
                      v-model="user.password"
                      :danger="`${errors}` ? true : false"
                      :danger-text="`${errors[0]}`"
                      type="password"
                    />
                  </ValidationProvider>
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
                    :disabled="invalid"
                    >Login</vs-button
                  >
                </vs-row>
              </div>
            </form>
          </ValidationObserver>
        </vs-card>
      </div>
    </div>
  </div>
</template>
<script>
import { login } from "../config";
import { ValidationProvider } from "vee-validate";
import { ValidationObserver } from "vee-validate";
import { extend } from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required",
});
extend("email", {
  ...email,
  message: "Invalid email address!",
});

export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
      checkMail: false,
      textMail: "",
      checkPass: false,
      textPass: "",
      errors: [],
      popupActivo: false,
      popup_content: 'Please re-enter your email and password',
    };
  },
  methods: {
    login() {
      login
        .post("", this.user)
        .then((res) => {
          localStorage.setItem("usertoken", res.data.access_token);
          this.user = {};
          this.$router.push({ name: "example" });
        })
        .catch((err) => {
          if (err.response.status == 422) {
            if (err.response.data.errors.email != null) {
              this.checkMail = true;
              this.textMail = err.response.data.errors.email[0];
            } else {
              this.checkMail = false;
            }
            if (err.response.data.errors.password != null) {
              this.checkPass = true;
            } else {
              this.checkPass = false;
              this.textPass = err.response.data.errors.password[0];
            }
          }
          if (err.response.status == 401) {
            this.popupActivo = true;
          }
        });
    },
  },
  components: {
    ValidationProvider,
    ValidationObserver,
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

