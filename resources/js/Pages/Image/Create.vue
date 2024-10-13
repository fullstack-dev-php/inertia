<script setup lang="ts">
import Form from '@/Pages/Image/Form.vue';
import { ref, provide } from 'vue';
import { useForm } from '@inertiajs/vue3';

const userForm = useForm({
    avatar: null,
});
provide('userForm', userForm);
provide('avatarFromDb', null);
const formSubmit = () => {
    userForm.post(route('image.store'));
};
</script>

<template>
    <div>
        Create
        <form method="post" @submit.prevent="formSubmit" enctype="multipart/form-data">
            <Form :avatarFromDb="null"></Form> <!-- avatar mặc định -->
            <button type="submit">Submit</button>
        </form>
    </div>
</template>
