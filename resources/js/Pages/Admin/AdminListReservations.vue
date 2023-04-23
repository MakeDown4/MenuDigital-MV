<template>
    <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
    <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
  <div>
    <h1>Lista de Reservas</h1>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">Nome</th>
          <th class="text-center">Data</th>
          <th class="text-center">Horário</th>
          <th class="text-center">Comentários Adicionais</th>
          <th class="text-center">Número de pessoas</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="reservation in reservations" :key="reservation.id">
          <td class="text-center">{{ reservation.user_name }}</td>
          <td class="text-center">{{ reservation.date }}</td>
          <td class="text-center">{{ reservation.time }}</td>
          <td class="text-center">{{ reservation.remarks }}</td>
          <td class="text-center">{{ reservation.num_people }}</td>
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

const confirmReservation = (reservationId) => {
const confirmed = confirm(`Tem certeza que deseja confirmar a reserva "${reservationId}"?`);
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
  const confirmed = confirm(`Tem certeza que deseja desfazer a confirmação da reserva "${reservationId}"?`);
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