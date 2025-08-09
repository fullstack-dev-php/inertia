<template>
    <div>
        <input ref="input" type="text" v-model="name">
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '1234'
        };
    },

    mounted() {
        console.log(this.$refs.input.value);
    },

    methods: {

    },
    watch: {
        name(newValue, oldValue) {
            console.log(newValue, oldValue);
        },

    },

};
</script>
