<template>
  <div id="login">
    <vs-dialog width="550px" not-center v-model="active">
      <template #header>
        <h4 class="not-margin">Login Failed</h4>
      </template>
      <div class="con-content">
        <p>Plese re-enter your email and password</p>
      </div>
    </vs-dialog>
    <div class="row justify-content-center no-gutters">
      <div class="d-flex align-items-center col-lg-12">
        <div class="card w-100">
          <div class="row no-gutters" style="min-height: 100vh">
            <div
              class="bg-primary d-md-flex align-items-center justify-content-center col-lg-6"
            >
              <vs-row align="center" justify="center">
                <vs-col w="8"
                  ><h2 class="text-white">
                    Elegant Design with unlimited features, built with love
                  </h2>
                  <p class="mt-4 text-white op-5 font-weight-normal">
                    Wrappixel helps developers to build organized and well-coded
                    admin dashboards full of beautiful and feature rich modules.
                  </p>

                  <vs-button color="#35b1e8" primary>
                    <h5 class="mt-1">Learn more</h5>
                  </vs-button>
                </vs-col>
              </vs-row>
            </div>
            <div
              class="d-md-flex align-items-center justify-content-center col-lg-6"
            >
              <div class="d-flex align-items-center w-100">
                <div class="p-5 w-100">
                  <div class="row justify-content-center">
                    <div class="col-lg-9 col-xl-6 col-12">
                      <img src="/img/icon.png" alt="" />
                      <h2 class="mt-4 font-weight-bold">Signin</h2>
                      <h6 class="mb-4">
                        Dont have an acount? <a href=""> Signup</a>
                      </h6>
                      <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                        <form @submit.prevent="handleSubmit(login)">
                          <div class="mb-3">
                            <ValidationProvider
                              vid="email"
                              name="E-mail"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <vs-input
                                state="dark"
                                v-model="user.email"
                                placeholder="Email"
                              >
                                <template #icon>
                                  <box-icon name="user"></box-icon>
                                </template>
                                <template v-if="errors" #message-danger>
                                  {{ errors[0] }}
                                </template>
                              </vs-input>
                            </ValidationProvider>
                          </div>
                          <div class="mb-3">
                            <ValidationProvider
                              vid="password"
                              name="Password"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <vs-input
                                state="dark"
                                v-model="user.password"
                                placeholder="password"
                                type="password"
                              >
                                <template #icon>
                                  <box-icon name="lock-alt"></box-icon>
                                </template>
                                <template v-if="errors" #message-danger>
                                  {{ errors[0] }}
                                </template>
                              </vs-input>
                            </ValidationProvider>
                          </div>
                          <vs-row>
                            <vs-col w="6">
                              <vs-checkbox v-model="option1"
                                >I accept the terms and use</vs-checkbox
                              ></vs-col
                            >
                            <vs-col offset="2" w="4">
                              <vs-row justify="flex-end">
                                <router-link to=""
                                  >Forgot pwd?</router-link
                                ></vs-row
                              >
                            </vs-col>
                          </vs-row>
                          <vs-row>
                            <vs-col w="12">
                              <vs-button style="width: 100%" primary>
                                <h5 class="mt-1">Sign In</h5>
                              </vs-button>
                            </vs-col>
                          </vs-row>
                        </form>
                      </ValidationObserver>
                      <vs-row>
                        <vs-col offset="3" w="3">
                          <vs-button style="width: 90%" color="rgb(29,161,242)">
                            <box-icon
                              name="twitter"
                              type="logo"
                              color="#f3e5e5"
                            ></box-icon>
                            Twitter
                          </vs-button>
                        </vs-col>
                        <vs-col w="3">
                          <vs-button style="width: 90%" dark>
                            <box-icon
                              name="github"
                              type="logo"
                              color="#f3e5e5"
                            ></box-icon>
                            Github
                          </vs-button>
                        </vs-col>
                      </vs-row>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import { login } from "../config";
import { ValidationProvider } from "vee-validate";
import { ValidationObserver } from "vee-validate";
import { extend } from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";
import { login } from "../config/config.api";
import { httpClient, injectToken, SET_AUTH_TOKEN } from "../config/httpClient";

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
      active: false,
      option1: "",
      popupActivo: false,
      popup_content: "Please re-enter your email and password",
    };
  },
  methods: {
    login() {
      login(this.user)
        .then((res) => {
          SET_AUTH_TOKEN(res.data.access_token);
          localStorage.setItem("usertoken", res.data.access_token);
          this.$store.dispatch("login", res.data.user);
          this.user = {};
            console.log(localStorage.getItem("redirectPath"));
          this.$router.replace(
            localStorage.redirectPath || "/users"
          );
          localStorage.removeItem("redirectPath");
        })
        .catch((err) => {
          console.log(err);
          if (err.response.status == 422) {
            this.$refs.form.setErrors(err.response.data.errors);
          }
          if (err.response.status == 401) {
            this.active = true;
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
#login {
  min-height: 100vh;
  font-family: "Roboto", sans-serif;
}
.vs-input {
  width: 100%;
}
</style>

