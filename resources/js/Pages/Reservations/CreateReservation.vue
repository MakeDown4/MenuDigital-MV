<template>
<div v-if="form.successMessage" class="alert alert-success">{{ form.successMessage }}</div>
<div v-if="form.errorMessage" class="alert alert-danger">{{ form.errorMessage }}</div>
<Head>
    <title>Cadastrar Reservas</title>
</Head>
<GuestLayout>
    <div class="center">
        <form @submit.prevent="submit">
            <div class="form-group">
                <InputLabel for="num_people">Quantidade de Pessoas:</InputLabel>
                <input type="number" name="num_people" id="num_people" v-model="form.num_people" class="form-control" />
            </div>

            <div class="form-group">
                <InputLabel for="date">Data:</InputLabel>
                    <input id="date" name="date" type="date" v-model="form.date" class="form-control" />
            </div>

            <div class="form-group">
                <InputLabel for="time">Horários Disponíveis:</InputLabel>
                    <select name="time" id="time" v-model="form.time" class="form-control">
                        <option v-for="option in timeOptions" :value="option.value" :key="option.value">{{ option.label }}</option>
                    </select>
            </div>


            <div class="form-group">
                <InputLabel for="remarks">Comentários adicionais:</InputLabel>
                <input type="text" name="remarks" id="remarks" v-model="form.remarks" class="form-control" />
            </div>

            <div style="margin-top: 10px;">
                <PrimaryButton type="submit" class="btn btn-primary center-submit">Criar Reserva</PrimaryButton>
            </div>
        </form>
    </div>
    </GuestLayout>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { router, Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = reactive({
    num_people: 0,
    date: null,
    time: null,
    remarks: null,
    successMessage: null,
    errorMessage: null,

})

const timeOptions = [
    { label: '10:00', value: '10:00' },
    { label: '10:30', value: '10:30' },
    { label: '11:00', value: '11:00' },
    { label: '11:30', value: '11:30' },
    { label: '12:00', value: '12:00' },
    { label: '12:30', value: '12:30' },
    { label: '13:00', value: '13:00' },
    { label: '13:30', value: '13:30' },
    { label: '14:00', value: '14:00' },
    { label: '14:30', value: '14:30' },
    { label: '15:00', value: '15:00' },
    { label: '15:30', value: '15:30' },
    { label: '16:00', value: '16:00' },
    { label: '16:30', value: '16:30' },
    { label: '17:00', value: '17:00' },
];

function submit() {
    router.post('/reservations', form, {
        onSuccess: () => {
            form.successMessage = 'Reserva criada com sucesso!';
                setTimeout(() => {
                    form.successMessage = null;
            }, 3000);
        },
        onError: () => {
            form.errorMessage = 'A tentativa de criação de reserva não pôde ser realizada!';
                setTimeout(() => {
                    form.errorMessage = null;
            }, 3000);
        },
        onFinish: () => {
            // Redefinir o formulário após enviar os dados
            form.num_people = 0;
            form.date = null;
            form.time = null;
            form.remarks = null;
        },
    });
}
</script>

<style scoped>
.center {
    display: block;
    justify-content: center;
}

.center-submit {
    width: 100%;
}

input.invalid {
    border-color: red;
}
</style>
