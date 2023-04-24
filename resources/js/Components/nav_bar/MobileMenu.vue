
<template>
  <div>
    <nav class="navbar navbar-white bg-white" style="z-index: 2;">
      <button  @click="showDiv = !showDiv" class="nav-bar-togle navbar-toggler" type="button" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
    </nav>
  </div>
    <div  v-if="showDiv" class="navbar navbar-white bg-white center-text">
      <ul class="navbar-nav">
        <li class="nav-item" v-for="(item, index) in menu" :key="index">
          <a class="nav-link" :href="item.link">{{ item.name }}</a>
        </li>
      </ul>
    </div>
</template>

<script>
export default {
  name: 'MobileMenu',
  props: {
    menu: Array
  },
  data() {
    return {
      showDiv: false
    }
  }
}
</script>

<style scoped>
  .center-text{
    display: flex !important;
    text-align: center;
    justify-content: center;
  }

  .center {
    margin: auto;
    display: block;
    width:90px;
  }

  .nav-bar-togle {
    position: absolute;
    z-index: 1;
  }
</style>
