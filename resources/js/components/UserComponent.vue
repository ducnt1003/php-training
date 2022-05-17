<template>
  <div>
    <vs-table>
      <template #header>
        <vs-input v-model="search" border placeholder="Search" />
      </template>
      <template #thead>
        <vs-tr>
          <vs-th sort @click="users = $vs.sortData($event, users, 'name')">
            Name
          </vs-th>
          <vs-th sort @click="users = $vs.sortData($event, users, 'email')">
            Email
          </vs-th>
          <vs-th sort @click="users = $vs.sortData($event, users, 'id')">
            Id
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
            {{ tr.name }}
          </vs-td>
          <vs-td>
            {{ tr.email }}
          </vs-td>
          <vs-td>
            {{ tr.id }}
          </vs-td>
        </vs-tr>
      </template>
      <template #footer>
        <vs-pagination v-model="page" :length="$vs.getLength(users, max)" />
      </template>
    </vs-table>
    <!-- <vs-table pagination max-items="10" search :data="users">
      <template slot="header">
        <h3>Users</h3>
      </template>
      <template slot="thead">
        <vs-th sort-key="id"> Nro </vs-th>
        <vs-th sort-key="email"> Email </vs-th>
        <vs-th sort-key="name"> Name </vs-th>
        <vs-th sort-key="role_id"> Role </vs-th>
      </template>

      <template slot-scope="{ data }">
        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
          <vs-td :data="data[indextr].id">
            {{ data[indextr].id }}
          </vs-td>
          <vs-td :data="data[indextr].email">
            {{ data[indextr].email }}
          </vs-td>

          <vs-td :data="data[indextr].name">
            {{ data[indextr].name }}
          </vs-td>
          <vs-td :data="data[indextr].role['role']">
            {{ data[indextr].role['role'] }}
          </vs-td>
        </vs-tr>
      </template>
    </vs-table> -->
  </div>
</template>
<script>
import { user } from "../config";
export default {
  data() {
    return {
      page: 1,
      max: 10,
      search: "",
      users: [],
    };
  },
  mounted() {
    user
      .get("")
      .then((res) => {
        this.users = res.data;
        console.log(this.users);
      });
  },
};
</script>
