<template>
  <div>
    <h1>Login</h1>

    <form>
      <div>
        <label for="usuario">Usuário (e-mail)</label>
        <input type="text" id="usuario" v-model="usuario" />
      </div>

      <div>
        <label for="senha">Senha</label>
        <input type="password" id="senha" v-model="senha" />
      </div>

      <button type="submit">Entrar</button>
    </form>
  </div>
</template>

<script>

export default {
}
</script>