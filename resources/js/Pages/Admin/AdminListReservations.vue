<template>
    <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
    <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
    <MenuHome />
      <div class="mt-4">
          <button class="text-sm font-medium text-gray-600 underline" @click="redirectToHome()">Voltar</button>
      </div>
  <div class="text-center">
    <h1 class="text-white" style="margin-top: 10vh; font-size: 2rem; font-weight: bold; text-shadow: 5px 5px 15px rgba(255, 0, 0, 1); letter-spacing: 0.1em;">Lista de Reservas</h1>
    <table class="table container-items">
      <thead>
        <tr>
          <th class="text-center text-white">Nome</th>
          <th class="text-center text-white">Data</th>
          <th class="text-center text-white">Horário</th>
          <th class="text-center text-white">Comentários Adicionais</th>
          <th class="text-center text-white">Número de pessoas</th>
          <th class="text-center text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="reservation in reservations" :key="reservation.id">
          <td class="text-center text-white">{{ reservation.user_name }}</td>
          <td class="text-center text-white">{{ reservation.date }}</td>
          <td class="text-center text-white">{{ reservation.time }}</td>
          <td class="text-center text-white">{{ reservation.remarks }}</td>
          <td class="text-center text-white">{{ reservation.num_people }}</td>
          <td>            
              <button v-if="!reservation.isConfirmed" class="btn btn-success" @click="confirmReservation(reservation.id)">Confirmar Reserva</button>
              <button v-else class="btn btn-warning" @click="undoConfirmation(reservation.id)">Desfazer Confirmação</button>
              <button class="btn btn-danger" @click="deleteReservation(reservation.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import MenuHome from '../../Components/MenuHome.vue';

const successMessage = ref(null);
const errorMessage = ref(null);

  const props = defineProps({
    reservations: {
      type: Array,
      required: true
    },
    successMessage: null,
    errorMessage: null
  });

function redirectToHome() {
      window.location.href = route('home');
}

const confirmReservation = (reservationId) => {
const confirmed = confirm(`Tem certeza que deseja confirmar a reserva ?`);
  if (confirmed) {
    router.put(`/admin/list-reservations/${reservationId}`, {
      is_confirmed: 1
    }, {
      onSuccess: () => {
        successMessage.value = 'Reserva confirmada com sucesso!';
        setTimeout(() => {
          successMessage.value = null;
        }, 3000);
        location.reload();
      },
      onError: () => {
        errorMessage.value = 'Erro ao confirmar a reserva.';
      },
    });
  }
};

const undoConfirmation = (reservationId) => {
  const confirmed = confirm(`Tem certeza que deseja desfazer a confirmação da reserva ?`);
  if (confirmed) {
    router.put(`/admin/list-reservations/undo-confirm/${reservationId}`, {
      is_confirmed: 0
    }, {
      onSuccess: () => {
        successMessage.value = 'Confirmação desfeita com sucesso!';
        setTimeout(() => {
          successMessage.value = null;
        }, 3000);
        location.reload();
      },
      onError: () => {
        errorMessage.value = 'Erro ao desfazer a confirmação.';
      },
    });
  }
};


const deleteReservation = (reservationId) => {
  const confirmed = confirm(`Tem certeza que deseja excluir o item "${reservationId}"?`);
  if (confirmed) {
    router.delete(`/admin/list-reservations/${reservationId}`, {
      onSuccess: () => {
        successMessage.value = 'Item excluído com sucesso!';
        setTimeout(() => {
          successMessage.value = null;
        }, 3000);
        location.reload();
      },
      onError: () => {
        errorMessage.value = 'Erro ao excluir o item.';
      },
    });
  }
};
</script>

<style>
.container-items{
    margin: 0 auto;
    width: 90% !important;
}

body {
  background-image: url('/images/image5.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>