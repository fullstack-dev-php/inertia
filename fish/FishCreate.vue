<script setup lang="ts">
/****************** Import Types ******************/
import {createFishValidateSchema, type FishFormData} from "@/types/fish";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import {CCard, CCardBody, CCardFooter, CCardHeader, CCardTitle} from "@coreui/vue";
import {Form} from "vee-validate";
import {CButton} from "@coreui/vue/dist/esm/components/button";
import {route} from 'ziggy-js'
import FishForm from "@/views/fish/FishForm.vue";
/****************** Import Helpers ******************/
import {provide} from 'vue'
import {Link, useForm} from "@inertiajs/vue3";

// Use Yup for validation
const validationSchema = createFishValidateSchema()
// const fishForm = ref({...getNewFish()});
const fishForm = useForm<FishFormData>({
    name: '',
    description: '',
    fish_media: [],
});
provide('fishForm', fishForm);

//Handle form submission
const onSubmit = () => {
    fishForm.post(route('admin.fish.store'));
};

</script>
<template>
    <DefaultLayout>
        <!-- Create User Form by using CoreUI Components -->
        <Form enctype="multipart/form-data" :validation-schema="validationSchema" @submit="onSubmit">

            <CCard>
                <CCardHeader>
                    <CCardTitle>魚類登録</CCardTitle>
                </CCardHeader>
                <CCardBody>
                    <FishForm type="create"></FishForm>
                </CCardBody>
                <CCardFooter>
                    <CButton type="submit" color="success"  class="btn mx-2">登録</CButton>
                    <Link :href="route('admin.fish.index')">
                        <CButton type="button" color="secondary">キャンセル</CButton>
                    </Link>
                </CCardFooter>

            </CCard>
        </Form>


    </DefaultLayout>
</template>
