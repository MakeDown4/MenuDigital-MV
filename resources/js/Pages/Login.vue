<template>
  <form @submit.prevent="submit">
    <div>
      <label for="username" class="form-label">Usuário / Email</label>
      <input id="username" v-model="form.username" class="form-control" />
    </div>
    <div>
      <label for="password" class="form-label">Senha</label>
      <input id="password" v-model="form.password" class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
  </form>
</template>




<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  first_name: null,
  last_name: null,
  email: null,
})

function submit() {
  router.post('/users', form)
}
</script>

<style scoped>
  .form-label {
  display: flex;
  margin-bottom: 0.5rem;
  font-size: 1rem;
  font-weight: 600;
}

.form-control {
  display: flex;
  width: 50%;
  height: calc(2.25rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn {
  display: inline-block;
  font-weight: 400;
  color: #fff;
  margin-top: 1%;
  text-align: center;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background-color: #007bff;
  border: 1px solid #007bff;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;

}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}
</style>
