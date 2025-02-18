<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
    visits: Object
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ visits }}</h2>
        </template>
        <div>
            <div v-for="(items, index) in visits">
                <b>{{ index }}</b>
                <div v-for="item in items" :key="item.id">
                    <p>ID: {{ item.id }}</p>
                    <p>Trạng thái: {{ item.status }}</p>
                    <p>Giá: {{ item.price }}</p>
                    <p>Ngày tạo: {{ item.created_at }}</p>
                    <hr />
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
