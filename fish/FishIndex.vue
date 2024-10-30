<script setup lang="ts">
import {
    CCard,
    CCardHeader,
    CCardBody,
    CButton,
    CModal,
    CModalHeader,
    CModalBody,
    CModalFooter,
    CTable,
    CTableHeaderCell,
    CTableRow,
    CTableDataCell,
    CForm,
} from '@coreui/vue'
import {cilArrowTop, cilArrowBottom, cilPlus} from "@coreui/icons";
import {Link, router} from '@inertiajs/vue3'

import DefaultLayout from '@/layouts/DefaultLayout.vue'
import type {Fish} from '@/types/fish'
import type {PaginateLink, Pagination} from "@/types/data";
import BasePaginate from "@/components/paginate/BasePaginate.vue";

/****************** Import Helpers ******************/
import {router as inertialRouter} from '@inertiajs/vue3'
import {route} from "ziggy-js";
import {ref} from 'vue'
import CIcon from "@coreui/icons-vue";
import {getFlash} from "@/helpers/flash_message";
import BaseInputSearch from '@/components/BaseInputSearch.vue';

defineProps<{
    fishes: Pagination<Fish>
}>()

//Trạng thái sắp xếp
const orders = ref<Record<string, 'asc' | 'desc' | null>>({
    name: null,
    email: null,
})
// Hàm xử lý toggle sắp xếp
const toggleSort = (key: string) => {
    if (orders.value[key] !== null) {
        orders.value[key] = orders.value[key] == 'asc' ? 'desc' : 'asc'
        console.log("key", key, orders.value[key]);
    } else {
        orders.value[key] = 'asc'
    }

    inertialRouter.get(route('admin.fish.index', {'orders': orders.value}))

}

// Trạng thái của modal
const showModal = ref(false)
const itemToDelete = ref<Fish | null>(null)

// Hàm xử lý sự kiện Edit

// Hàm mở modal xác nhận xóa
const confirmDelete = (item: Fish) => {
    itemToDelete.value = item
    showModal.value = true
}

// Hàm xử lý sự kiện Delete
const handleDelete = () => {
    if (itemToDelete.value) {
        showModal.value = false

        router.delete(route('admin.fish.destroy', itemToDelete.value.id),{
            onSuccess: () => {
                getFlash()
            }
        })
    }
}


const changePage = (pageLink: PaginateLink) => {
    if (pageLink.url) {
        router.get(pageLink.url)
    }
}
const name = ref<string>('')
    const onSubmit = () => {
    router.get(route('admin.fish.index', { name: name.value }), {}, {
        preserveState: true,
        preserveScroll: true
    })
}
</script>

<template>
    <DefaultLayout>
        <CForm class="mb-2 d-flex" @submit.prevent="onSubmit">
            <BaseInputSearch v-model="name" />
        </CForm>
        <CCard>
            <CCardHeader>
                <h2>魚類管理

                    <!-- Add Create Fish Button float to the right -->
                    <Link :href="route('admin.fish.create')">
                        <CButton color="success" class="text-white float-end">
                            <CIcon :icon="cilPlus"/>
                            新規登録
                        </CButton>
                    </Link>

                </h2>

            </CCardHeader>
            <CCardBody>
                <CTable hover responsive>
                    <thead>
                    <tr>
                        <CTableHeaderCell style="cursor: pointer;" @click="toggleSort('id')">
                            ID
                            <CIcon v-if="orders.id === 'asc'" :icon="cilArrowTop"/>
                            <CIcon v-if="orders.id === 'desc'" :icon="cilArrowBottom"/>
                        </CTableHeaderCell>
                        <CTableHeaderCell style="cursor: pointer;" @click="toggleSort('name')">
                            魚類名
                            <CIcon v-if="orders.name === 'asc'" :icon="cilArrowTop"/>
                            <CIcon v-if="orders.name === 'desc'" :icon="cilArrowBottom"/>
                        </CTableHeaderCell>
                        <CTableHeaderCell class="text-center col-2">操作</CTableHeaderCell>
                    </tr>
                    </thead>
                    <tbody>
                    <CTableRow v-for="(fish) in fishes.data" :key="fish.id">
                        <CTableDataCell>{{ fish.id }}</CTableDataCell>
                        <CTableDataCell>{{ fish.name }}</CTableDataCell>
                        <CTableDataCell class="col-2 col-md-2 col-lg-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <Link :href="route('admin.fish.edit',fish.id)">
                                    <CButton size="sm" color="info" class="text-white mx-1">
                                        編集
                                    </CButton>
                                </Link>
                                <CButton size="sm" color="danger" class="text-white" @click="confirmDelete(fish)">
                                    削除
                                </CButton>
                            </div>
                        </CTableDataCell>
                    </CTableRow>
                    </tbody>
                </CTable>
                <div class="d-flex justify-content-center mt-3">
                    <BasePaginate :links="fishes.links" @change-page="changePage"/>
                </div>
            </CCardBody>
        </CCard>

        <!-- Modal xác nhận xóa -->
        <CModal v-model:visible="showModal" @close="() => { showModal = false }">
            <CModalHeader>
                削除確認
            </CModalHeader>
            <CModalBody>
                この管理者のアカウントを削除します。よろしいでしょうか？
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="showModal = false">キャンセル</CButton>
                <CButton color="danger" @click="handleDelete">削除する</CButton>
            </CModalFooter>
        </CModal>
    </DefaultLayout>
</template>
