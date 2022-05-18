<template>
  <div>
    <vs-row>
      <vs-table>
        <template #thead>
          <vs-tr>
            <vs-th> Id </vs-th>
            <vs-th> Email </vs-th>
            <vs-th> Name </vs-th>
            <vs-th
              ><vs-row justify="flex-end"
                ><vs-button success @click="activeCreate = !activeCreate"
                  >Create</vs-button
                ></vs-row
              >
            </vs-th>
          </vs-tr>
        </template>
        <template #tbody>
          <vs-tr
            :key="i"
            v-for="(tr, i) in $vs.getPage(users, page, max)"
            :data="tr"
          >
            <vs-td>
              {{ tr.id }}
            </vs-td>
            <vs-td>
              {{ tr.email }}
            </vs-td>
            <vs-td>
              {{ tr.name }}
            </vs-td>
            <vs-td>
              <vs-row justify="flex-end">
                <vs-button> Edit </vs-button>
                <vs-button color="rgb(242, 19, 93)"> Delete </vs-button></vs-row
              >
            </vs-td>
          </vs-tr>
        </template>
        <template #footer>
          <vs-pagination v-model="page" :length="$vs.getLength(users, max)" />
        </template>
      </vs-table>
    </vs-row>
    <vs-dialog width="550px" not-center v-model="activeCreate">
      <template #header>
        <h4 class="not-margin">Create new User</h4>
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
              v-model="user.name"
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
              v-model="user.email"
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
            <vs-select
            label="Role"
              color= success
              v-model="user.role_id"
            >
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
            <vs-button @click="create" transparent>
              Ok
            </vs-button>
            <vs-button @click="activeCreate = false" dark transparent>
              Cancel
            </vs-button></vs-row
          >
        </div>
      </template>
    </vs-dialog>
  </div>
</template>
<script>
import { ValidationProvider } from "vee-validate";
import { getUser } from "../config/config.api";
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  data() {
    return {
      user: {
          name:'',
          email:'',
          role_id:0,
      },
      page: 1,
      max: 10,
      search: "",
      activeCreate: false,
    };
  },
  computed: {
    users() {
      //console.log(this.users);
      return this.$store.getters.users;
    },
  },
  methods:{
      //...mapActions(['createUser']);
      create(){
          this.$store.dispatch("createUser",this.user);
          this.activeCreate = false;
      }

  },

  created() {},
  mounted() {
    console.log(this.users);
    this.$store.dispatch("setUsers");
  },
  components: {
    ValidationProvider,
  },
};
</script>
<style scoped>
.vs-input {
  width: 80%;
}
</style>
