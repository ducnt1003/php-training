<template>
  <div>
    <Navbar />
    <vs-row class="mt-5">
      <vs-table>
        <template #header>
          <vs-row>
            <vs-col w="6"
              ><vs-input v-model="search" border :placeholder="$t('search')"
            /></vs-col>
            <vs-col w="2">
              <vs-row justify="flex-start"
                ><vs-col w="12"
                  ><vs-select
                    :placeholder="$t('role')"
                    color="success"
                    v-model="role_id"
                  >
                    <vs-option :label="$t('all')" value="4">
                      {{ $t("all") }}
                    </vs-option>
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
                <vs-button @click="exportUsers" transparent icon>
                  <box-icon name="export"></box-icon> </vs-button
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
                  <vs-checkbox class="dropdown-item" val="id" v-model="options">
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
                    {{ $t("name") }}
                  </vs-checkbox>
                  <vs-checkbox
                    class="dropdown-item"
                    val="role"
                    v-model="options"
                  >
                    {{ $t("role") }}
                  </vs-checkbox>
                  <vs-checkbox
                    v-if="check_role == 'SuperAdmin'"
                    class="dropdown-item"
                    v-model="action"
                  >
                    Action
                  </vs-checkbox>
                </ul>
              </vs-row>
            </vs-col>
          </vs-row>
        </template>
        <template #thead>
          <vs-tr>
            <vs-th v-if="check_role == 'SuperAdmin'" style="width: 3%">
              <vs-checkbox
                :indeterminate="selected.length == users.length"
                v-model="allCheck"
                @change="selected = $vs.checkAll(selected, users)"
              />
            </vs-th>
            <vs-th
              v-if="options.includes('id')"
              style="width: 7%"
              sort
              @click="
                usersx = $vs.sortData($event, usersx, 'id');
                sort = editSort('id');
              "
            >
              Id
            </vs-th>
            <vs-th
              v-if="options.includes('email')"
              style="width: 40%"
              sort
              @click="
                usersx = $vs.sortData($event, usersx, 'email');
                sort = editSort('email');
              "
            >
              Email
            </vs-th>
            <vs-th
              v-if="options.includes('name')"
              style="width: 20%"
              sort
              @click="
                usersx = $vs.sortData($event, usersx, 'name');
                sort = editSort('name');
              "
            >
              {{ $t("name") }}
            </vs-th>
            <vs-th
              v-if="options.includes('role')"
              style="width: 10%"
              sort
              @click="
                usersx = $vs.sortData($event, usersx, 'role_id');
                sort = editSort('role_id');
              "
            >
              {{ $t("role") }}
            </vs-th>
            <vs-th
              v-if="check_role == 'SuperAdmin' && action"
              style="width: 20%"
              ><vs-row justify="flex-end"
                ><vs-button success @click="activeCreate = !activeCreate">{{
                  $t("create")
                }}</vs-button>
                <vs-button
                  @click="activeDeleteMulti = true"
                  color="rgb(242, 19, 93)"
                >
                  {{ $t("delete") }}
                </vs-button>
              </vs-row>
            </vs-th>
          </vs-tr>
        </template>
        <template #tbody>
          <vs-tr
            :key="i"
            v-for="(tr, i) in $vs.getPage(usersx, page, max)"
            :data="tr"
            :is-selected="!!selected.includes(tr)"
          >
            <vs-td v-if="check_role == 'SuperAdmin'"
              ><vs-checkbox v-if="tr.id != 1" :val="tr" v-model="selected"
            /></vs-td>
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
            <vs-td v-if="check_role == 'SuperAdmin' && action">
              <vs-row align="center" justify="flex-end">
                <vs-button @click="edit(tr.id)"> {{ $t("edit") }} </vs-button>
                <vs-button
                  @click="(id = tr.id), (name = tr.name), (activeDelete = true)"
                  color="rgb(242, 19, 93)"
                >
                  {{ $t("delete") }}
                </vs-button>
              </vs-row>
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
          <h4 class="not-margin">{{ $t("create") }}</h4>
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
                  :label="$t('name')"
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
              <vs-select
                :label="$t('role')"
                color="success"
                v-model="user.role_id"
              >
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
                {{ $t("ok") }}
              </vs-button>
              <vs-button @click="activeCreate = false" dark transparent>
                {{ $t("cancel") }}
              </vs-button></vs-row
            >
          </div>
        </template>
      </vs-dialog>
    </ValidationObserver>
    <EditComponent />
    <vs-dialog width="550px" not-center v-model="activeDelete">
      <template #header>
        <h4 class="not-margin">{{ $t("delete") }}</h4>
      </template>
      <p>{{ $t("textdelete", { name: name }) }}</p>

      <template #footer>
        <div class="con-footer">
          <vs-row justify="flex-end">
            <vs-button @click="deleteUser" transparent>
              {{ $t("ok") }}
            </vs-button>
            <vs-button @click="activeDelete = false" dark transparent>
              {{ $t("cancel") }}
            </vs-button></vs-row
          >
        </div>
      </template>
    </vs-dialog>
    <vs-dialog width="550px" not-center v-model="activeDeleteMulti">
      <template #header>
        <h4 class="not-margin">{{ $t("delete") }}</h4>
      </template>
      <p>{{ $t("textdeleteall") }}</p>

      <template #footer>
        <div class="con-footer">
          <vs-row justify="flex-end">
            <vs-button @click="deleteUsers" transparent>
              {{ $t("ok") }}
            </vs-button>
            <vs-button @click="activeDeleteMulti = false" dark transparent>
              {{ $t("cancel") }}
            </vs-button></vs-row
          >
        </div>
      </template>
    </vs-dialog>
  </div>
</template>
<script>
import {
  ValidationProvider,
  extend,
  ValidationObserver,
  localize,
} from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";
import Navbar from "../Navbar.vue";
import EditComponent from "./EditComponent.vue";
import i18n from "../../i18n";

extend("required", {
  ...required,
  message: (_, values) => i18n.t("required", values),
});
extend("email", {
  ...email,
  message: (_, values) => i18n.t("invalidemail", values),
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
      activeDeleteMulti: false,
      id: "",
      name: "",
      usersx: [],
      role_id: 0,
      check_role: "",
      errorsCreate: [],
      options: ["id", "name", "email", "role"],
      activeOption: false,
      delete_id: [],
      allCheck: false,
      selected: [],
      action: true,
      sort: {
        key: "",
        type: 0,
      },
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
    success(newVal){
        this.openNotification("top-right");
        this.activeCreate = false;
        this.user = {
          name: "",
          email: "",
          role_id: -1,
        };
        this.$store.dispatch("setSuccess");
    }
  },
  computed: {
    // users() {
    //   //console.log(this.users);
    //   return this.$store.getters.users;
    // },
    ...mapGetters(["activeEdit", "users", "errors","success"]),
  },
  methods: {
    openNotification(position = null) {
      if (this.errors != "") {
        const noti = this.$vs.notification({
          position,
          title: this.$t("error"),
          text: this.$t("createfail"),
        });
      } else {
        const noti = this.$vs.notification({
          position,
          title: this.$t("success"),
          text: this.$t("createsuccess"),
        });
        this.activeCreate = false;
        this.user = {};
      }
    },
    openNotificationSelected(position = null) {
      const noti = this.$vs.notification({
        position,
        title: this.$t("error"),
        text: this.$t("errorselect"),
      });
    },

    //...mapActions(['createUser']);
    create() {
      this.$store.dispatch("createUser", this.user);

    },
    ...mapMutations(["setActiveEdit"]),
    edit(id) {
      this.$store.dispatch("editUser", id);
    },
    deleteUser() {
      this.$store.dispatch("deleteUser", this.id);
      this.activeDelete = false;
    },
    deleteUsers() {
      //console.log(this.selected)
      if (this.selected.length > 0) {
        this.$store.dispatch("deleteUsers", this.selected);
        this.selected = [];
        this.activeDeleteMulti = false;
      } else {
        this.openNotificationSelected("top-right");
      }
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
    exportUsers() {
      this.$store.dispatch("exportUsers", {
        options: this.options,
        search: this.search,
        sort: this.sort,
        role_id: this.role_id,
      });
    },
    editSort(key) {
      if (this.sort.key == key) {
        if (this.sort.type == 2) {
          return {
            key: key,
            type: 0,
          };
        } else {
          let a = this.sort.type + 1;
          return {
            key: key,
            type: a,
          };
        }
      } else {
        return {
          key: key,
          type: 1,
        };
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
