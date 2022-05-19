<template>
  <vs-row class="navbar bg-primary round" justify="flex-end"
    ><vs-button dark @click="logout">Log Out</vs-button></vs-row
  >
</template>
<script>
import { logout } from "../config/config.api";
export default {
  data: () => ({}),
  methods: {
    logout() {
      logout()
        .then((res) => {
          console.log(res);
          this.$router.push({name:'login'});
          localStorage.removeItem("usertoken");
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
