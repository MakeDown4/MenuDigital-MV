<template>
  <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
  <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
  <div>
    <h1>Itens do Cardápio</h1>
    <table class="table table-striped mx-auto text-center">
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
            <button class="btn btn-primary" @click="showEditForm(menuItem)">Editar</button>
            <button class="btn btn-danger" @click="deleteMenuItem(menuItem)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="showCreateForm">Adicionar Item</button>
  </div>

  <div v-if="showEditModal == true">
    <div class="modal fade show" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Item do Cardápio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" @click="showEditModal = false">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitEditForm">
              <div class="form-group">
                <label for="edit-item-name">Nome do Item:</label>
                <input type="text" class="form-control" id="edit-item-name" v-model="editForm.name">
              </div>
              <div class="form-group">
                <label for="edit-item-category">Categoria:</label>
                <select class="form-control" id="edit-item-category" v-model="editForm.category_id">
                  <!-- <option v-for="category in categories" :value="category.id">{{ category.name }}</option> -->
                </select>
              </div>
              <div class="form-group">
                <label for="edit-item-price">Preço:</label>
                <input type="number" step="0.01" class="form-control" id="edit-item-price" v-model="editForm.price">
              </div>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import { usePage, router } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'

export default {
  setup() {
    const { props: { menuItems }, route, visit, inertia } = usePage()

    const successMessage = ref(null)
    const errorMessage = ref(null)

    const createMenuItem = () => {
      visit(route('admin.menuItems.create'))
    }

    const showEditForm = (menuItem) => {
      editForm = { ...menuItem }
      showEditModal = true
      console.log(showEditModal)
    }

    function submitEditForm(item) {
      const { component, props } = usePage();

      router.put('/admin/menuitems/' + item.id, {
        item
      })
    }

    function deleteMenuItem (menuItem) {
      const confirmed = confirm(`Tem certeza que deseja excluir o item "${menuItem.name}"?`)
      if (confirmed) {
        router.delete('/admin/menuitems/' +  menuItem.id, {
          onSuccess: () => {
            successMessage.value = 'Item excluído com sucesso!';
            setTimeout(() => {
              successMessage.value = null;
            }, 3000);
            location.reload()
          },
          onError: () => {
            errorMessage.value = 'Erro ao excluir o item.';
          }
        });
      }
    }

    return {
      menuItems,
      createMenuItem,
      showEditForm,
      submitEditForm,
      showEditModal: false,
      deleteMenuItem,
      successMessage,
      errorMessage
    }
  }
}
</script>