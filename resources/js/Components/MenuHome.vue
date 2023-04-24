<template>
  <MobileMenu v-if="isMobile" :menu="menu" />
  <DesktopMenu v-else :menu="menu" :user="user" />
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
      { name: 'Cadastrar', link: 'register' }
    ]
    if(user){
          menu = [
            { name: 'Solicitar Reservas', link: route('reservations.create') },
            { name: 'Cardápio', link: route('menuitems.index') },
            { name: 'Editar Cadastro', link: route('profile.edit') }
        ]
      if(user.is_admin === 1){
          menu = [
            { name: 'Gerenciar Reservas', link: route('admin.list.reservations') },
            { name: 'Gerenciar Usuários', link: route('admin.list.users')  },
            { name: 'Gerenciar Cardápio', link: route('admin.menuItems.index'),},
            { name: 'Solicitar Reserva', link: route('reservations.create') },
            { name: 'Cardápio', link: route('menuitems.index') },
            { name: 'Editar Cadastro', link: route('profile.edit') }
        ]
      }
    }

    return {
      user,
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