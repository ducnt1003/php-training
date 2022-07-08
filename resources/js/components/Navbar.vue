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
      <router-link class="btn textWhite vs-navbar__item" to="/">{{
        $t("home")
      }}</router-link>
      <router-link class="btn textWhite vs-navbar__item" to="/users"
        >{{$t("users")}}</router-link
      >
    </template>

    <template #right>
      <div>
        <vs-button
          @click="activeOption = !activeOption"
          :active="activeOption"
          transparent
          icon
        >
          <span class="text-black">{{lang}} </span>
         <box-icon name='caret-left' rotate='270' ></box-icon>
        </vs-button>
        <ul v-if="activeOption" class="dropdown-menu dropdown-menu-right show">
          <li><a class="dropdown-item" @click="changeLanguage('vi')">vi</a></li>
          <li><a class="dropdown-item" @click="changeLanguage('en')">en</a></li>
        </ul>
      </div>
      <!-- <vs-select transparent placeholder="Select" v-model="value">
        <vs-option label="Vuesax" value="1">
          Vuesax
        </vs-option>
        <vs-option label="Vue" value="2">
          Vue
        </vs-option>

      </vs-select> -->

      <vs-button dark @click="logout">{{$t("logout")}}</vs-button>
    </template>
  </vs-navbar>
</template>
<script>
import { logout } from "../config/config.api";
import i18n from '../i18n';
export default {
  data() {
    return {
      active: "",
      value: "",
      activeOption: "",
      lang:''
    };
  },
  methods: {
    logout() {
      logout()
        .then((res) => {
          console.log(res);
          this.$router.push({ name: "login" });
          localStorage.removeItem("usertoken");
          localStorage.removeItem("user");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    changeLanguage(lang){
        this.lang=lang;
        this.activeOption = false;
        i18n.locale = lang;
    }
  },
  created(){
      this.lang = i18n.locale;
  },
};
</script>

