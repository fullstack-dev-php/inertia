<script setup lang="ts">
import Form from '@/Pages/Image/Form.vue';
import { defineProps, provide } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    restaurant: {
        type: Object,
        required: true,
    },
});

const userForm = useForm(props.restaurant);
provide('userForm', userForm);
provide('avatarFromDb', props.restaurant.avatar);
const formSubmit = () => {
    userForm.post(route('image.update', props.restaurant.id));
};
</script>

<template>
    <div>
        Edit {{ props.restaurant }}
        <form method="post" @submit.prevent="formSubmit" enctype="multipart/form-data">
            <Form></Form> <!-- avatar từ database -->
            <button type="submit">Submit</button>
        </form>
    </div>
</template>
