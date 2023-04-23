<template>
  <div class="container-list text-center">
  <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
  <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
  <div>
    <h1>Editar Cardápio</h1>
    <table class="table table-striped">
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
            <button class="btn btn-primary" @click="openEditModal(menuItem)">Editar</button>
            <button class="btn btn-danger" @click="deleteMenuItem(menuItem)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="showCreateForm">Adicionar Item</button>
  </div>

  <div>
    <div class="modal" :class="{ 'is-active': showEditModal }">
      <form @submit.prevent="submit">
        <div class="modal-background" @click="showEditModal = false"></div>
      <div class="modal-content">
        <div class="field">
            <div class="form-group">
              <label for="name">Nome:</label>
              <input type="text" class="form-control" id="name" name="name" v-model="formEdit.name">
            </div>
            <div class="form-group">
              <label for="description">Descrição do Prato:</label>
              <textarea class="form-control" id="description" name="description" v-model="formEdit.description"> </textarea >
            </div>
            <div class="form-group">
              <label for="upload_img">Imagem do Prato:</label>
              <input type="file" class="form-control" id="upload_img" name="upload_img">
            </div>
            <div class="form-group">
              <label for="price">Preço:</label>
              <input type="number" class="form-control" id="price" name="price" v-model="formEdit.price">
            </div>
            <div class="form-group">
                <label for="category_id">Categoria:</label>
                <select class="form-control" id="category_id" name="category_id" v-model="formEdit.category_id">
                  <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
              </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </div>
            <button class="modal-close is-large" aria-label="close" @click="showEditModal = false"></button>
          </form>
        </div>
      </div>
    </div>

</template>

<script>
import { usePage, router } from '@inertiajs/vue3'
import { ref, onMounted, reactive } from 'vue'

export default {
  data() {
    const { props: { menuItems, allCategories }, route, visit, inertia } = usePage()

    const successMessage = ref(null)
    const errorMessage = ref(null)

    let showEditModal = ref(false);

    function openEditModal(menuItem){
      showEditModal.value = true
      this.formEdit.id = menuItem.id
      this.formEdit.name = menuItem.name
      this.formEdit.description = menuItem.description
      this.formEdit.upload_img = menuItem.upload_img
      this.formEdit.price = menuItem.price
      this.formEdit.category_id = menuItem.category_id
    }

    onMounted(() => {
      const modalEl = document.querySelector('.modal')
      modalEl.addEventListener('shown.bs.modal', () => {
        const inputEl = modalEl.querySelector('input')
        inputEl.focus()
      })
    })

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
      allCategories,
      showEditModal,
      deleteMenuItem,
      successMessage,
      errorMessage,
      openEditModal,
      formEdit: {
        id: null,
        name: null,
        description: null,
        upload_img: null,
        price: null,
        category_id: null
      }
    }
  },
  methods: {
    submit() {
      router.put('/admin/menuitems/' + this.formEdit.id, this.formEdit)
    },
  },
}
</script>

<style>
.modal {
  display: none;
}
.modal.is-active {
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-background {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-content {
  background-color: #fff;
  padding: 1rem;
  max-width: 500px;
  width: 100%;
  max-height: 80vh;
  overflow-y: auto;
}
.modal-close {
  position: absolute;
  top: 0;
  right: 0;
  background-color: transparent;
  border: none;
  cursor: pointer;
  font-size: 1.5rem;
  padding: 0.75rem;
  margin: 0.5rem;
}

.container-list{
  display: flex;
  justify-content: center;
}

.table{
  display: inline-table;
}
</style>