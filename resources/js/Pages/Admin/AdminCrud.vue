<template>
  <MenuHome />
  <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
    <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
            <div class="mt-4">
                <button class="text-sm font-medium text-gray-600 underline" @click="redirectToHome()">Voltar</button>
            </div>
      <div class="container-list text-center">
  <div>
    <h1 class="text-white" style="margin-top: 10vh; margin-bottom: 5vh; font-size: 2rem; font-weight: bold; text-shadow: 5px 5px 15px rgba(255, 0, 0, 1); letter-spacing: 0.1em;">Lista de Cardápio</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="text-center text-white">Nome</th>
          <th class="text-center text-white">Categoria</th>
          <th class="text-center text-white">Imagem</th>
          <th class="text-center text-white">Preço</th>
          <th class="text-center text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="menuItem in menuItems" :key="menuItem.id">
          <td class="text-center text-white">{{ menuItem.name }}</td>
          <td class="text-center text-white">{{ menuItem.category.name }}</td>
            <td class="text-center text-white">
              <img style="height: 5vh; margin: 0 auto;" :src="'/storage/menuImg/' + menuItem.upload_img" alt="">
            </td>
          <td class="text-center text-white">{{ menuItem.price }}</td>
          <td>
            <button class="btn btn-primary" @click="openEditModal(menuItem)">Editar</button>
            <button class="btn btn-danger" @click="deleteMenuItem(menuItem)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-success" @click="openCreateModal(menuItem)">Adicionar Item</button>
  </div>

<!-- Modal de Edição -->
  <div>
    <div class="modal" :class="{ 'is-active': showEditModal }">
      <form @submit.prevent="submit">
        <div class="modal-background" @click="showEditModal = false"></div>
      <div class="modal-content">
        <h2>Editar Cardápio</h2>
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
              <input type="file" class="form-control" id="upload_img" name="upload_img" @change="uploadImgEdit($event)">
            </div>
            <div class="form-group">
              <label for="price">Preço:</label>
              <input type="text" class="form-control" @input="formattedNumberOnEditModal" id="price" name="price" v-model="formEdit.price">
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

<!-- Modal de Criação -->
  <div>
    <div class="modal" :class="{ 'is-active': showCreateModal }">
      <form @submit.prevent="submit">
        <div class="modal-background" @click="showCreateModal = false"></div>
      <div class="modal-content">
        <h2>Criar Cardápio</h2>
        <div class="field">
            <div class="form-group">
              <label for="name">Nome:</label>
              <input type="text" class="form-control" id="name" name="name" v-model="formCreate.name">
            </div>
            <div class="form-group">
              <label for="description">Descrição do Prato:</label>
              <textarea class="form-control" id="description" name="description" v-model="formCreate.description"> </textarea >
            </div>
            <div class="form-group">
              <label for="upload_img">Imagem do Prato:</label>
              <input type="file" class="form-control" id="upload_img" name="upload_img" @change="uploadImgCreate($event)">
            </div>
            <div class="form-group">
              <label for="price">Preço:</label>
              <input type="text" class="form-control" @input="formattedNumberOnCreateModal" id="price" name="price" v-model="formCreate.price">
            </div>
            <div class="form-group">
                <label for="category_id">Categoria:</label>
                <select class="form-control" id="category_id" name="category_id" v-model="formCreate.category_id">
                  <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
              </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </div>
            <button class="modal-close is-large" aria-label="close" @click="showCreateModal = false"></button>
          </form>
        </div>
      </div>

    </div>

</template>

<script>
import { usePage, router } from '@inertiajs/vue3'
import { ref, onMounted, reactive } from 'vue'
import MenuHome from '../../Components/MenuHome.vue';

export default {
    components: {
      MenuHome,
    },
  data() {
    const { props: { menuItems, allCategories }, visit, inertia } = usePage()

    const successMessage = ref(null)
    const errorMessage = ref(null)

    function redirectToHome() {
        window.location.href = route('home');
    }

    //Função Edit
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

    //Função Create
    let showCreateModal = ref(false);

    function openCreateModal(){
      showCreateModal.value = true
    }

    //Find dos Inputs
    onMounted(() => {
      const modalElCreate = document.querySelector('.modal')
      modalElCreate.addEventListener('shown.bs.modal', () => {
        const inputElCreate = modalElCreate.querySelector('input')
        inputElCreate.focus()
      })
    })

  //Função Delete
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
      isSubmitting: false,
      menuItems,
      redirectToHome,
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
        price: null,
        category_id: null
      },
      showCreateModal,
      openCreateModal,
      formCreate: {
        id: null,
        name: null,
        description: null,
        price: null,
        category_id: null
      },
    }
  },
  methods: {
  formattedNumberOnCreateModal() {
      let numberValue = this.formCreate.price;

      numberValue = numberValue.replace(/\D/g,'');
      numberValue = numberValue.replace(/(\d+)(\d{2})$/, '$1.$2');
      
      this.formCreate.price = numberValue;
  },
  formattedNumberOnEditModal() {
      let numberValue = this.formEdit.price;

      numberValue = numberValue.replace(/\D/g,'');
      numberValue = numberValue.replace(/(\d+)(\d{2})$/, '$1.$2');
      
      this.formEdit.price = numberValue;
  },
  uploadImgEdit(e){
    this.formEdit.upload_img = e.target.files[0]
  },
  uploadImgCreate(e){
    this.formCreate.upload_img = e.target.files[0]
  },
  submit() {
    if (this.isSubmitting) {
      // Se uma operação já estiver em andamento, não faz nada
      return
    }

    if (this.formEdit.id) {
        // Se estiver editando, chama a rota de atualização
        this.isSubmitting = true

        const bodyEdit = new FormData()
        bodyEdit.append('id', this.formEdit.id)
        bodyEdit.append('name', this.formEdit.name)
        bodyEdit.append('description', this.formEdit.description)
        bodyEdit.append('price', this.formEdit.price)
        bodyEdit.append('category_id', this.formEdit.category_id)
        bodyEdit.append('file', this.formEdit.upload_img)

        router.post('/admin/menuitems/' + this.formEdit.id, bodyEdit, {
          onSuccess: () => {
            this.successMessage = 'Item atualizado com sucesso!';
            setTimeout(() => {
              this.successMessage = null;
            }, 3000);
            location.reload()
          },
          onError: () => {
            this.errorMessage = 'Erro ao excluir o item.';
          },
          onFinish: () => {
            this.isSubmitting = false
          }
        })
      } else {
        // Se estiver criando, chama a rota de criação
        this.isSubmitting = true

        const bodyCreate = new FormData()
        bodyCreate.append('id', this.formCreate.id)
        bodyCreate.append('name', this.formCreate.name)
        bodyCreate.append('description', this.formCreate.description)
        bodyCreate.append('price', this.formCreate.price)
        bodyCreate.append('category_id', this.formCreate.category_id)
        bodyCreate.append('file', this.formCreate.upload_img)
        
        router.post('/admin/menuitems/create', bodyCreate, {
          onSuccess: () => {
            this.successMessage = 'Cardápio Criado com Sucesso !';
            location.reload()
          },
          onError: () => {
            this.errorMessage = 'Erro ao criar o item do cardápio';
          },
          onComplete: () => {
            this.isSubmitting = false
          }
        })
      }
    }
  }
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
  margin: 0 auto;
  width: 90%;
}

body {
  background-image: url('/images/image5.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.table{
  display: inline-table;
}
</style>