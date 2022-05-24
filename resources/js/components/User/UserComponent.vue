<template>
  <div>
    <navbar />
    <vs-row class="mt-5">
      <vs-table>
        <template #header>
          <vs-input v-model="search" border placeholder="Search" />
        </template>
        <template #thead>
          <vs-tr>
            <vs-th style="width:10%" sort @click="usersx = $vs.sortData($event, usersx, 'id')">
              Id
            </vs-th>
            <vs-th sort @click="usersx = $vs.sortData($event, usersx, 'email')">
              Email
            </vs-th>
            <vs-th sort @click="usersx = $vs.sortData($event, usersx, 'name')">
              Name
            </vs-th>
            <vs-th sort @click="usersx = $vs.sortData($event, usersx, 'role')">
              Role
            </vs-th>
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
            v-for="(tr, i) in $vs.getPage(usersx, page, max)"
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
              {{ tr.role }}
            </vs-td>
            <vs-td>
              <vs-row justify="flex-end">
                <vs-button @click="edit(tr.id)"> Edit </vs-button>
                <vs-button
                  @click="(id = tr.id), (name = tr.name), (activeDelete = true)"
                  color="rgb(242, 19, 93)"
                >
                  Delete
                </vs-button></vs-row
              >
            </vs-td>
          </vs-tr>
        </template>
        <template #footer>
          <vs-pagination v-model="page" :length="$vs.getLength(usersx, max)" />
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
            <vs-button @click="create" transparent> Ok </vs-button>
            <vs-button @click="activeCreate = false" dark transparent>
              Cancel
            </vs-button></vs-row
          >
        </div>
      </template>
    </vs-dialog>
    <EditComponent />
    <vs-dialog width="550px" not-center v-model="activeDelete">
      <template #header>
        <h4 class="not-margin">Delete User</h4>
      </template>
      <p>Are you sure to delete user {{ name }} (id:{{ id }})</p>

      <template #footer>
        <div class="con-footer">
          <vs-row justify="flex-end">
            <vs-button @click="deleteUser" transparent> Ok </vs-button>
            <vs-button @click="activeDelete = false" dark transparent>
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
import Navbar from "../Navbar.vue";
import EditComponent from "./EditComponent.vue";
import { mapActions, mapGetters, mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        role_id: 0,
      },
      page: 1,
      max: 10,
      search: "",
      activeCreate: false,
      activeDelete: false,
      id: "",
      name: "",
      usersx: [],
    };
  },
  watch: {
    deleteActive() {
      console.log(this.activeDelete);
      console.log(this.id);
    },
    users(newVal) {
      this.usersx = newVal;
    },
    search(newVal) {
      this.usersx = this.getSearch(newVal);
    },
  },
  computed: {
    // users() {
    //   //console.log(this.users);
    //   return this.$store.getters.users;
    // },
    ...mapGetters(["activeEdit", "users"]),
  },
  methods: {
    openNotification(position = null) {
      const noti = this.$vs.notification({
        position,
        title: "Success",
        text: `Create Success`,
      });
    },

    //...mapActions(['createUser']);
    create() {
      this.$store.dispatch("createUser", this.user);
      this.openNotification("top-right");
      this.activeCreate = false;
      this.user = {};
    },
    ...mapMutations(["setActiveEdit"]),
    edit(id) {
      this.$store.dispatch("editUser", id);
    },
    deleteUser() {
      this.$store.dispatch("deleteUser", this.id);
      this.activeDelete = false;
    },
    getSearch(key) {
      if (key != "") {
        return this.users.filter((user) => user.name.search(key) > -1);
      } else {
        return this.users;
      }
    },
  },

  created() {
    this.$store.dispatch("setUsers");
  },
  mounted() {
    //console.log(this.users);
  },
  components: {
    ValidationProvider,
    Navbar: Navbar,
    EditComponent,
  },
};
</script>
<style scoped>
.nav {
  height: 20;
}
.vs-input {
  width: 80%;
}
</style>
