<template>
  <div>
    <vs-table pagination max-items="10" search :data="users">
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
    </vs-table>
  </div>
</template>
<script>
import api from "../config";
export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    this.axios
      .get(api["user"], {
        headers: {
          Authorization: `Bearer ${localStorage.usertoken}`,
        },
      })
      .then((res) => {
        this.users = res.data;
        console.log(this.users);
      });
  },
};
</script>
