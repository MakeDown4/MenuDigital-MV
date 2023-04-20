<template>
  <div>
    <h1>Itens do Cardápio</h1>
    <table class="table table-striped" style="width: 100%;">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Categoria</th>
          <th>Preço</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="menuItem in menuItems" :key="menuItem.id">
          <td>{{ menuItem.name }}</td>
          <td>{{ menuItem.category.name }}</td>
          <td>{{ menuItem.price }}</td>
          <td>
            <button class="btn btn-primary" @click="editMenuItem(menuItem)">Editar</button>
            <button class="btn btn-danger" @click="deleteMenuItem(menuItem)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="createMenuItem">Adicionar Item</button>
  </div>
</template>


<script>
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

export default {
  setup() {
    const { props: { menuItems }, route, visit, inertia } = usePage()

    const createMenuItem = () => {
      visit(route('admin.menuItems.create'))
    }

    const editMenuItem = (menuItem) => {
      visit(route('admin.menuItems.edit', { menuItem: menuItem.id }))
    }

    const deleteMenuItem = async (menuItem) => {
        const confirmed = confirm(`Tem certeza que deseja excluir o item "${menuItem.name}"?`)
      if (confirmed) {
          console.log('a')
        const response = await router.delete('admin.menuItems.delete', { menuItem: menuItem.id })
        if (response.status === 200) {
          alert('Item excluído com sucesso!')
          // Recarrega a página para atualizar a lista de itens do cardápio
          location.reload()
        } else {
          alert('Ocorreu um erro ao excluir o item.')
        }
      }
    }

    return {
      menuItems,
      createMenuItem,
      editMenuItem,
      deleteMenuItem,
    }
  }
}
</script>