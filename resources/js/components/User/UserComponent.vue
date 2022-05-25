<template>
  <div>
    <Navbar />
    <vs-row class="mt-5">
      <vs-table>
        <template #header>
          <vs-row>
            <vs-col w="6"
              ><vs-input v-model="search" border placeholder="Search By Name"
            /></vs-col>
            <vs-col w="2">
              <vs-row justify="flex-start"
                ><vs-col w="12"
                  ><vs-select
                    placeholder="Role"
                    color="success"
                    v-model="role_id"
                  >
                    <vs-option label="All" value="4"> All </vs-option>
                    <vs-option label="SuperAdmin" value="1">
                      SuperAdmin
                    </vs-option>
                    <vs-option label="Admin" value="2"> Admin </vs-option>
                    <vs-option label="User" value="3"> User </vs-option>
                  </vs-select></vs-col
                ></vs-row
              >
            </vs-col>

            <vs-col w="4">
              <vs-row justify="flex-end">
                <vs-col w="2"
                  ><vs-row justify="flex-end"
                    ><vs-button transparent icon>
                      <box-icon name="export"></box-icon> </vs-button></vs-row
                ></vs-col>
                <vs-col w="2"
                  ><vs-row justify="flex-end"
                    ><vs-button
                      @click="activeOption = !activeOption"
                      :active="activeOption"
                      transparent
                      icon
                    >
                      <box-icon name="menu"></box-icon>
                    </vs-button>
                    <ul
                      v-if="activeOption"
                      class="dropdown-menu dropdown-menu-right show"
                    >
                      <!-- <li>1</li>
                    <li>2</li> -->
                      <vs-checkbox
                        class="dropdown-item"
                        val="id"
                        v-model="options"
                      >
                        Id
                      </vs-checkbox>
                      <vs-checkbox
                        class="dropdown-item"
                        val="email"
                        v-model="options"
                      >
                        Email
                      </vs-checkbox>
                      <vs-checkbox
                        class="dropdown-item"
                        val="name"
                        v-model="options"
                      >
                        Name
                      </vs-checkbox>
                      <vs-checkbox
                        class="dropdown-item"
                        val="role"
                        v-model="options"
                      >
                        Role
                      </vs-checkbox>
                    </ul>
                  </vs-row>
                </vs-col>
              </vs-row>
            </vs-col>
          </vs-row>
        </template>
        <template #thead>
          <vs-tr>
            <vs-th
              v-if="options.includes('id')"
              style="width: 10%"
              sort
              @click="usersx = $vs.sortData($event, usersx, 'id')"
            >
              Id
            </vs-th>
            <vs-th
              v-if="options.includes('email')"
              style="width: 40%"
              sort
              @click="usersx = $vs.sortData($event, usersx, 'email')"
            >
              Email
            </vs-th>
            <vs-th
              v-if="options.includes('name')"
              style="width: 20%"
              sort
              @click="usersx = $vs.sortData($event, usersx, 'name')"
            >
              Name
            </vs-th>
            <vs-th
              v-if="options.includes('role')"
              style="width: 10%"
              sort
              @click="usersx = $vs.sortData($event, usersx, 'role')"
            >
              Role
            </vs-th>
            <vs-th v-if="check_role == 'SuperAdmin'"
            style="width: 20%"
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
            <vs-td v-if="options.includes('id')">
              {{ tr.id }}
            </vs-td>
            <vs-td v-if="options.includes('email')">
              {{ tr.email }}
            </vs-td>
            <vs-td v-if="options.includes('name')">
              {{ tr.name }}
            </vs-td>
            <vs-td v-if="options.includes('role')">
              {{ tr.role }}
            </vs-td>
            <vs-td v-if="check_role == 'SuperAdmin'">
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
    <ValidationObserver ref="form" v-slot="{ handleSubmit }">
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
                >
                  <template v-if="errors" #message-danger>
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
              ><ValidationProvider
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
              <template v-if="errors" #message-danger>
                {{ errors[0] }}
              </template>
            </vs-col>
          </vs-row>
        </div>
        <template #footer>
          <div class="con-footer">
            <vs-row justify="flex-end">
              <vs-button @click="handleSubmit(create)" transparent>
                Ok
              </vs-button>
              <vs-button @click="activeCreate = false" dark transparent>
                Cancel
              </vs-button></vs-row
            >
          </div>
        </template>
      </vs-dialog>
    </ValidationObserver>
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
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";
import Navbar from "../Navbar.vue";
import EditComponent from "./EditComponent.vue";
extend("required", {
  ...required,
  message: "This field is required",
});
extend("email", {
  ...email,
  message: "Invalid email address!",
});
import { mapActions, mapGetters, mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        role_id: -1,
      },
      page: 1,
      max: 10,
      search: "",
      activeCreate: false,
      activeDelete: false,
      id: "",
      name: "",
      usersx: [],
      role_id: 0,
      check_role: "",
      errorsCreate: [],
      options: ["id", "name", "email", "role"],
      activeOption: false,
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
      if (this.role_id != 4 && this.role_id != 0) {
        this.usersx = this.getSearch(
          this.filterRole(this.users, this.role_id),
          newVal
        );
      } else {
        this.usersx = this.getSearch(this.users, newVal);
      }
    },
    errors(newVal) {
      this.$refs.form.setErrors(newVal);
      this.openNotification("top-right");
      console.log(newVal);
    },
    role_id(newVal) {
      if (this.search != "") {
        this.usersx = this.filterRole(
          this.getSearch(this.users, this.search),
          newVal
        );
      } else {
        this.usersx = this.filterRole(this.users, newVal);
      }
    },
    options(newVal) {
      console.log(this.options);
    },
  },
  computed: {
    // users() {
    //   //console.log(this.users);
    //   return this.$store.getters.users;
    // },
    ...mapGetters(["activeEdit", "users", "errors"]),
  },
  methods: {
    openNotification(position = null) {
      if (this.errors != "") {
        const noti = this.$vs.notification({
          position,
          title: "Error",
          text: `Create Fail`,
        });
      } else {
        const noti = this.$vs.notification({
          position,
          title: "Success",
          text: `Create Success`,
        });
        this.activeCreate = false;
        this.user = {};
      }
    },

    //...mapActions(['createUser']);
    create() {
      this.$store.dispatch("createUser", this.user);
      // this.openNotification("top-right");

      //   this.activeCreate = false;
      //   this.user = {};
    },
    ...mapMutations(["setActiveEdit"]),
    edit(id) {
      this.$store.dispatch("editUser", id);
    },
    deleteUser() {
      this.$store.dispatch("deleteUser", this.id);
      this.activeDelete = false;
    },
    getSearch(array, key) {
      if (key != "") {
        return array.filter((user) => user.name.search(key) > -1);
      } else {
        return array;
      }
    },
    filterRole(array, role_id) {
      if (role_id != 4 && this.role_id != 0) {
        return array.filter((user) => user.role_id == role_id);
      } else {
        return array;
      }
    },
  },

  created() {
    this.$store.dispatch("setUsers");
    this.check_role = JSON.parse(localStorage.getItem("user")).role;
  },
  mounted() {
    //console.log(this.users);
  },
  components: {
    ValidationProvider,
    ValidationObserver,
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
.vs-select {
  width: 100%;
}
</style>
