<<template>
  <nav class="navbar navbar-expand-lg bg-dark rounded">

    <!-- <div class="collapse navbar-collapse justify-content-md-center" id="navbar1">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" to="/">home</router-link>
        </li>
        <li  class="nav-item">
          <router-link class="nav-link" to="/login">Login</router-link>
        </li>
        <li  class="nav-item">
          <router-link class="nav-link" to="/register">Register</router-link>
        </li>
        <li  class="nav-item">
          <router-link class="nav-link" to="/profile">Profile</router-link>
        </li>
        <li  class="nav-item">
          <router-link class="nav-link" href="">Logout</router-link>
        </li>
      </ul>
    </div> -->
    <vs-navbar v-model="activeItem" class="nabarx" text-color="rgba(255,255,255,.6)" active-text-color="rgba(255,255,255,1)">
      <vs-navbar-item index="1">
        <router-link to="/">Home</router-link>
      </vs-navbar-item>
      <vs-navbar-item index="2">
        <router-link to="/login">Login</router-link>
      </vs-navbar-item>
      <vs-navbar-item index="3">
        <router-link to="/logout">Logout</router-link>
      </vs-navbar-item>
    </vs-navbar>
  </nav>

</template>
<script>
export default {
  data:()=>({
    activeItem: 0,
  })
}
</script>
