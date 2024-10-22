<script setup lang="ts">
import { CCol, CRow, CWidgetStatsA } from '@coreui/vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { usePage } from '@inertiajs/vue3';
interface DashboardMetric {
    label:string,
    count:number,
    color:string,
}
const dashboardMetrics = <DashboardMetric[]>usePage().props.dashboardMetrics
</script>

<template>
    <DefaultLayout>
        <CRow>
            <template v-for="(dashboardMetric,index) in dashboardMetrics" :key="index">     
                <CCol>
                    <CWidgetStatsA :color="dashboardMetric.color">
                        <template #value>
                            {{ dashboardMetric.count }}
                        </template>
                        <template #title>
                            {{ dashboardMetric.label }}
                        </template>
                        <div class="mt-3 mx-3" style="height: 70px"></div>
                    </CWidgetStatsA>
                </CCol>
            </template>    
        </CRow>
    </DefaultLayout>
</template>
