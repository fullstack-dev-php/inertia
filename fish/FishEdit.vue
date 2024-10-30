<script setup lang="ts">
/****************** Import Types ******************/
import { createFishValidateSchema, type FishFormData } from "@/types/fish";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import { CCard, CCardBody, CCardFooter, CCardHeader, CCardTitle } from "@coreui/vue";
import { Form } from "vee-validate";
import { CButton } from "@coreui/vue/dist/esm/components/button";
import { route } from 'ziggy-js'
import FishForm from "@/views/fish/FishForm.vue";
/****************** Import Helpers ******************/
import { provide } from 'vue'
import { Link, useForm } from "@inertiajs/vue3";
const props = defineProps({
    fish: {
        type: Object as () => FishFormData,
        required: true,
    }
})

// Use Yup for validation
const validationSchema = createFishValidateSchema()

// const fishForm = ref(props.fish);
const fishForm = useForm<FishFormData>(props.fish);


provide('fishForm', fishForm);
//Handle form submission
const onSubmit = () => {
    fishForm.post(route('admin.fish.update', props.fish.id));
};


</script>
<template>
    <DefaultLayout>
        <!-- Create User Form by using CoreUI Components -->
        <Form enctype="multipart/form-data" :validation-schema="validationSchema" @submit="onSubmit">

            <CCard>
                <CCardHeader>
                    <CCardTitle>魚類編集</CCardTitle>
                </CCardHeader>
                <CCardBody>
                    <FishForm type="edit"></FishForm>
                </CCardBody>
                <CCardFooter>
                    <CButton type="submit" color="primary" class="btn mx-2">編集</CButton>
                    <Link :href="route('admin.fish.index')">
                    <CButton type="button" color="secondary">キャンセル</CButton>
                    </Link>
                </CCardFooter>

            </CCard>
        </Form>


    </DefaultLayout>
</template>
