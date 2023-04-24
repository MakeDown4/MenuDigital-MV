<template>
  <nav id="nav-bar" class="navbar-invisible justify-content-center navbar navbar-white bg-white navbar-expand fixed-top">
    <div class="justify-content-center">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <template v-for="item in menu" :key="item.name">
          <li class="nav-item active item-menu-home" >
            <a class="nav-link" :href="item.link">{{item.name}}</a>
          </li>
        </template>
      </ul>
    </div>
    <div style="padding-left: 10vh" class="text-white" v-if="user">
      <button type="submit" @click="logout()" :href="route('logout')">Log Out</button>
    </div>
  </nav>
</template>

<script>
import { router } from '@inertiajs/vue3'

export default {
  name: 'DesktopMenu',
  props: {
    menu: Array,
    user: Object
  },
  created() {
    window.addEventListener('scroll', this.handleScroll);
  },
  methods: {
    handleScroll() {
      if(!document.getElementById('nav-bar')) {
        return;
      }
      const scrollTop = window.pageYOffset;
      document.getElementById('nav-bar').classList.remove('navbar-invisible');
      
      if(scrollTop == 0){
        document.getElementById('nav-bar').classList.add('navbar-invisible');
      }
    },
    logout() {
      router.post('/logout');
      location.reload()
    }
  }
}
</script>

<style scoped>
.logo {
  height: 80px !important;
  margin-left: 80px !important;
}

.nav-link:hover{
  color: rgb(255, 0, 0) !important;
  animation: ease-in 1s;
}
.nav-link{
  color: rgb(8, 8, 8);
  
}

.item-menu-home {
  margin-right: 30px;
}

.logo-div{
  position: absolute;
  left: 10px;
}

.navbar-invisible {
  background-color: transparent !important;
}

.navbar-invisible .nav-link {
  color: #fff;
  animation: ease-in 1s;
}

@media (max-width:1100px) {
  .logo {
    height: 70px !important;
    margin-left: 20px !important;
  }
}
</style>