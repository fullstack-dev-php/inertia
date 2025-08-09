<template>
    <div>
        {{ date }}
        <flat-pickr v-model="date" />
        <input type="time" name="time" id="" v-model="start_time">
        {{ start_time }}
        <input type="time" name="time" id="" v-model="end_time">
        {{ end_time }}
    </div>
    <div v-if="date && start_time && end_time">
        <select size="10" style="overflow-y:auto; width: 800px;" @scroll="onScroll">
            <option value=""></option>
            <option v-for="theme in filterThemes()" :key="theme.id" :value="theme.id">
                {{ theme.start_time }} - {{ theme.end_time }}- id {{ theme.id }}
            </option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    components: {
        flatPickr
    },
    data() {
        return {
            date: new Date().toISOString().split('T')[0],
            start_time: '10:00',
            end_time: '10:30',
            themes: [],
            page: 1,
            lastPage: 1,
            scrollTimeout: null,
            lastScrollTime: 0
        };
    },
    mounted() {
        this.getThemePaginated();
    },
    methods: {
        getThemePaginated() {
            if (this.page > this.lastPage) return;

            axios.get(route('theme.paginated'), {
                params: { page: this.page }
            })
                .then(res => {
                    const data = res.data.data;
                    this.themes.push(...data.data);
                    this.lastPage = data.last_page;
                    this.page++;
                });
        },
        onScroll(e) {
            const now = Date.now();
            if (now - this.lastScrollTime < 300) return;
            clearTimeout(this.scrollTimeout);
            this.scrollTimeout = setTimeout(() => {
                const el = e.target;
                if (el.scrollTop + el.clientHeight >= el.scrollHeight - 10) {
                    this.lastScrollTime = Date.now();
                    this.getThemePaginated();
                }
            }, 200);
        },
        filterThemes() {
            const feFrom = new Date(this.date + ' ' + this.start_time);
            const feTo = new Date(this.date + ' ' + this.end_time);
            if (feTo < feFrom) {
                return [];
            }
            return this.themes.filter(theme => {
                const dbStart = theme.start_time ? new Date(theme.start_time) : null;
                const dbEnd = theme.end_time ? new Date(theme.end_time) : null;
                const passStart = !dbStart || feFrom >= dbStart; // FE from >= DB start
                const passEnd = !dbEnd || feTo <= dbEnd;         // FE to <= DB end
                return passStart && passEnd;
            });
        }


    }
};
</script>
