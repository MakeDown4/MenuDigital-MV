<template>
  <div class="container">
    <div class="container-image">
    </div>
    <div class="h-full flex flex-col justify-end items-center pt-6">
      <div class="absolute top-0 right-0 h-full w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg container-form mt-0">
        <div class="flex flex-col justify-center items-center h-full w-full">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { Link } from '@inertiajs/vue3';
</script>

<style>
html, body {
  height: 100%;
}

#app {
  height: 100%;
}

.container {
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.container-form {
  display: flex;
  align-items: center;
  height: 100%;
  flex: 1;
}

.container-image {
  height: 100% !important;
  width: 80%;
  position: absolute;
  left: 0;
  right: 0;
  z-index: 0;
  background-color: black;
  background-image: url('/images/macarrao4k.jpg');
  background-size: cover;
}

</style>