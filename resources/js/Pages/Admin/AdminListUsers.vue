<template>
    <div v-if="successMessage" class="alert alert-success">
        <span>{{ successMessage }}</span>
    </div>
    <div v-if="errorMessage" class="alert alert-danger">
        <span>{{ errorMessage }}</span>
    </div>
      <div class="mt-4">
        <button class="text-sm font-medium text-gray-600 underline" @click="redirectToHome()">Voltar</button>
      </div>
  <div class="text-center">
    <h1>Lista de Usuários</h1>
    <table class="table table-striped text-center">
      <thead>
        <tr>
          <th>Nome de Usuário</th>
          <th>E-mail</th>
          <th>Administrador ?</th>
          <th>Data de Criação</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.is_admin ? 'Sim' : 'Não' }}</td>
          <td>{{ formatDate(user.created_at) }}</td>
          <td>
            <button type="button" v-if="user.name !== 'admin'"
                    @click="toggleAdmin(user)"
                    :class="{ 'btn': true, 'btn-primary': !user.is_admin, 'btn-warning': user.is_admin }">
                {{ user.is_admin ? 'Remover Privilégios Admin' : 'Tornar Admin' }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
        <button type="button" @click="openCreateAdminUser(user)" class="btn btn-success"> Criar usuário administrador </button>
  </div>
  <!-- Modal de Criação -->
  <div>
    <div class="modal" :class="{ 'is-active': showCreateAdminUserModal }">
      <form @submit.prevent="submit">
        <div class="modal-background" @click="showCreateAdminUserModal = false"></div>
      <div class="modal-content">
        <h2>Criar novo Usuário Administrador</h2>
        <div class="field">
            <div class="form-group">
              <label for="name">Nome:</label>
              <input type="text" class="form-control" id="name" name="name" v-model="formCreateUser.name">
            </div>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input class="form-control" id="email" name="email" v-model="formCreateUser.email">
            </div>
            <div class="form-group">
              <label for="password">Senha</label>
              <input type="password" class="form-control" id="password" name="password" v-model="formCreateUser.password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Senha</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" v-model="formCreateUser.confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </div>
            <button class="modal-close is-large" aria-label="close" @click="showCreateAdminUserModal = false"></button>
          </form>
        </div>
      </div>
</template>

<script>
import { computed, ref, reactive } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

export default {
  setup() {
    const { props, inertia } = usePage()

    const successMessage = ref(null);
    const errorMessage = ref(null);

    // Computed property para formatar a data
    const formatDate = (date) => {
      const options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
      }
      return new Date(date).toLocaleDateString('pt-BR', options)
    }

    const showCreateAdminUserModal = ref(false);

    function openCreateAdminUser(){
      showCreateAdminUserModal.value = true
    }

    const formCreateUser = reactive({
        name: null,
        email: null,
        password: null,
    })

    function redirectToHome() {
      window.location.href = route('home');
    }

    function submit(){
        if (formCreateUser.password != formCreateUser.confirm_password) {
            errorMessage.value = 'As senhas não correspondem.';
            return;
        }

        const confirmed = confirm(`Tem certeza que deseja tornar este usuário como administrador ?`)
          if (confirmed) {
            router.post(`/admin/users/create-admin`, formCreateUser, {
              onSuccess: () => {
                successMessage.value = 'Usuário adicionado como administrador com sucesso!';
                setTimeout(() => {
                  successMessage.value = null;
                }, 3000);
                location.reload()
              },
              onError: () => {
                errorMessage.value = 'Erro ao adicionar usuário como administrador.';
              }
            })
          }
    }

    const toggleAdmin = (user) => {
      const confirmed = confirm(`Tem certeza que deseja tornar este usuário como administrador ?`)
      if (confirmed) {
        router.put(`/admin/users/make-admin/${user.id}`, user, {
          onSuccess: () => {
            successMessage.value = 'Privilégios de administrador atualizados com sucesso !';
            setTimeout(() => {
              successMessage.value = null;
            }, 3000);
            location.reload()
          },
          onError: () => {
            errorMessage.value = 'Erro ao editar os privilégios de administrador.';
          }
        })
      }
    }

    return {
      users: computed(() => props.users),
      formatDate,
      redirectToHome,
      toggleAdmin,
      successMessage,
      errorMessage,
      openCreateAdminUser,
      showCreateAdminUserModal,
      formCreateUser,
      submit
    }
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