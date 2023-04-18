<template>
    <div class="center">
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="num_people">Quantidade de Pessoas:</label>
                <input type="number" name="num_people" id="num_people" v-model="form.num_people" class="form-control" />
            </div>

            <div class="form-group">
                <label for="date">Data:</label>
                <input id="date" name="date" type="date" v-model="form.date" class="form-control" />
            </div>

            <div class="form-group">
                <label for="time">Horário:</label>
                <input type="time" name="time" id="time" v-model="form.time" class="form-control" />
            </div>

            <div class="form-group">
                <label for="remarks">Comentários adicionais:</label>
                <input type="textarea" name="remarks" id="remarks" v-model="form.remarks" class="form-control" />
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="btn btn-primary">Criar Reserva</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
    num_people: null,
    date: null,
    time: null,
    remarks: null
})

const state = reactive({
    success: false
})

function submit() {
    router.post('/reservations', form)
}
</script>

<style scoped>
.center {
    display: flex;
    justify-content: center;
}
</style>
