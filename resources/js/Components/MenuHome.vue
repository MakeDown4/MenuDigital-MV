<template>
  <MobileMenu v-if="isMobile" :menu="menu" />
  <DesktopMenu v-else :menu="menu" />
</template>

<script>
import MobileMenu from './nav_bar/MobileMenu.vue'
import DesktopMenu from './nav_bar/DesktopMenu.vue'
import { usePage } from '@inertiajs/vue3';

export default {
  name: 'App',
  components: {
    MobileMenu,
    DesktopMenu
  },
  data() {
    const user = usePage().props.auth.user;
    let menu = [
      { name: 'Home', link: route('home') },
      { name: 'Cardápio', link: route('menuitems.index') },
      { name: 'Login', link: 'login' },
      { name: 'Cadastrar', link: 'register' },
    ]
    if(user){
          menu = [
            { name: 'Editar Perfil', link: route('dashboard') },
            { name: 'Solicitar Reservas', link: route('reservations.create') },
            { name: 'Cardápio', link: route('menuitems.index') }
        ]
      if(user.is_admin === 1){
          menu = [
            { name: 'Editar Perfil', link: route('dashboard') },
            { name: 'Gerenciar Reservas', link: route('admin.list.reservations') },
            { name: 'Gerenciar Usuários', link: route('admin.list.users')  },
            { name: 'Gerenciar Cardápio', link: route('admin.menuItems.index'),},
            { name: 'Solicitar Reserva', link: route('reservations.create') },
            { name: 'Cardápio', link: route('menuitems.index') }
        ]
      }
    }

    return {
      menu,
      isMobile: false
    }
  },
  methods: {
    checkScreenSize() {
      this.isMobile = window.innerWidth < 768
    }
  },
  mounted() {
    this.checkScreenSize()
    window.addEventListener('resize', this.checkScreenSize)
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize)
  }
}

</script>