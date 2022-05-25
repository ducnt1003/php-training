<template>
  <vs-dialog width="550px" not-close not-center v-model="active">
    <template #header>
      <h4 class="not-margin">Edit User</h4>
    </template>

    <div>
      <vs-row class="mt-5">
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="10"
          offset="1"
        >
          <ValidationProvider
            vid="name"
            name="name"
            rules="required"
            v-slot="{ errors }"
          >
            <vs-input
              label="Name"
              state="dark"
              v-model="user.name"
              placeholder="Name"
              ><template v-if="errors" #message-danger>
                {{ errors[0] }}
              </template></vs-input
            >
          </ValidationProvider>
        </vs-col>
      </vs-row>
      <vs-row class="mt-5">
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="10"
          offset="1"
        >
        <ValidationProvider
                vid="email"
                name="email"
                rules="required|email"
                v-slot="{ errors }"
              >
          <vs-input
            label="Email"
            state="dark"
            v-model="user.email"
            placeholder="Email"
          ><template v-if="errors" #message-danger>
                    {{ errors[0] }}
                  </template></vs-input
                >
              </ValidationProvider>
        </vs-col>
      </vs-row>
      <vs-row class="mt-5">
        <vs-col
          vs-type="flex"
          vs-justify="center"
          vs-align="center"
          w="10"
          offset="1"
        >
          <vs-select label="Role" color="success" v-model="user.role_id">
            <vs-option label="SuperAdmin" value="1"> SuperAdmin </vs-option>
            <vs-option label="Admin" value="2"> Admin </vs-option>
            <vs-option label="User" value="3"> User </vs-option>
          </vs-select>
        </vs-col>
      </vs-row>
    </div>

    <template #footer>
      <div class="con-footer">
        <vs-row justify="flex-end">
          <vs-button @click="update" transparent> Ok </vs-button>
          <vs-button @click="setActiveEdit" dark transparent>
            Cancel
          </vs-button></vs-row
        >
      </div>
    </template>
  </vs-dialog>
</template>
<script>
import { mapActions, mapGetters, mapMutations, mapState } from "vuex";
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
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
      active: false,
    };
  },
  watch: {
    // user(newVal,oldVal){
    //     this.user1 = newVal;
    //     // this.name = newVal.name;
    //     // this.email = newVal.email;
    //     // this.role_id=newVal.role_id;
    // },
    activeEdit(newVal, oldVal) {
      this.active = newVal;
    },
    active() {
      console.log(this.active);
    },
  },
  computed: {
    ...mapGetters(["activeEdit", "user"]),
  },
  methods: {
    ...mapMutations(["setActiveEdit"]),
    update() {
      this.$store.dispatch("updateUser", {
        id: this.user.id,
        name: this.user.name,
        email: this.user.email,
        role_id: this.user.role_id,
      });
    },
  },

  created() {},
  mounted() {},
  components: {
    ValidationProvider,
    ValidationObserver,
  },
};
</script>
