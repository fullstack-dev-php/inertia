<template>
    <form @submit.prevent="toggleVisit">
        <button type="submit">
            {{ visited ? 'Unvisit' : 'Visit' }}
        </button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import {useForm } from '@inertiajs/vue3';

const visited = ref(false);
const form = useForm({
    user_id: 1,
    restaurant_id: 1
})
function toggleVisit(e) {
    e.preventDefault();
    form.post(('/restaurants/toggle-visit'), {
        onSuccess: (response) => {
            visited.value =response.visited;
        }
    });
}

</script>