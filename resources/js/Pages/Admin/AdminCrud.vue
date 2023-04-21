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
import { usePage, router } from '@inertiajs/vue3'

export default {
  setup() {
    const { props: { menuItems }, route, visit, inertia } = usePage()

    const createMenuItem = () => {
      visit(route('admin.menuItems.create'))
    }

    const editMenuItem = (menuItem) => {
      visit(route('admin.menuItems.edit', { menuItem: menuItem.id }))
    }

    function deleteMenuItem (menuItem) {
      const confirmed = confirm(`Tem certeza que deseja excluir o item "${menuItem.name}"?`)
      if (confirmed) {router.delete('/admin/menuitems/' +  menuItem.id, {
          onSuccess: () => {
          },
          onError: () => {
          }
        });
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