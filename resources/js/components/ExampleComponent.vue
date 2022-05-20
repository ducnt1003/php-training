<template>
  <div class="container">
    <navbar />
    <div class="row justify-content-center">
      <div class="col-md-6 mt-5 mx-auto">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">I'm an example component.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar.vue";
export default {
  mounted() {
    console.log("Component mounted.");
  },
  components: {
    Navbar: Navbar,
  },
};
</script>
