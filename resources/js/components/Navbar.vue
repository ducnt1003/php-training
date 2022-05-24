<template>
  <!-- <vs-row class="navbar bg-primary round" >

    <vs-col mt-2  w="1"><vs-button
        transparent
      > Default
      </vs-button></vs-col
    ><vs-col offset="10" w="1"
      ><vs-button dark @click="logout">Log Out</vs-button></vs-col>
  </vs-row> -->
  <vs-navbar color="primary" text-white square center-collapsed>
    <template #left>
      <vs-navbar-item @click="$router.push({name:'home'})"> Home </vs-navbar-item>
      <vs-navbar-item @click="$router.push({name:'users'})"> Users </vs-navbar-item>
    </template>

    <template #right>
      <vs-button dark @click="logout">Logout</vs-button>
    </template>
  </vs-navbar>
</template>
<script>
import { logout } from "../config/config.api";
export default {
  data(){
     return {
         active:"",
     }
  },
  methods: {
    logout() {
      logout()
        .then((res) => {
          console.log(res);
          this.$router.push({ name: "login" });
          localStorage.removeItem("usertoken");
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
