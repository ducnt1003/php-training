<template>
  <vs-dialog width="550px" not-close not-center v-model="activeEdit">
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
          <vs-input
            label="Name"
            state="dark"
            v-model="user1.name"
            placeholder="Name"
          ></vs-input>
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
          <vs-input
            label="Email"
            state="dark"
            v-model="user1.email"
            placeholder="Email"
          ></vs-input>
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
          <vs-select label="Role" color="success" v-model="user1.role_id">
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
          <vs-button @click="update"  transparent> Ok </vs-button>
          <vs-button @click="setActiveEdit" dark transparent>
            Cancel
          </vs-button></vs-row
        >
      </div>
    </template>
  </vs-dialog>
</template>
<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex';
export default {
  data() {
    return {
        user1:{},
    };
  },
    watch:{
        user(newVal,oldVal){
            this.user1=newVal;
        },
    },
  computed: {
      ...mapGetters(['activeEdit','user']),
  },
  methods: {
      ...mapMutations(['setActiveEdit']),
      update(){
          this.$store.dispatch('updateUser',this.user1);
      },

  },

  created() {},
  mounted() {
  },
  components: {},
};
</script>
