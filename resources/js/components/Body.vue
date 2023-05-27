<template>
    <hr>
    <Imprint v-if="showImprint"></Imprint>
    <keep-alive>
        <Search v-if="!showImprint"></Search>
    </keep-alive>
</template>

<script>
    import Search from "./Search.vue";
    import Imprint from "./Imprint.vue";
export default {
    name: "SiteBody",
    components: {
        Search,
        Imprint,
    },
    mounted() {
        this.emitter.on("show-imprint", showImprint => {
            this.showImprint = showImprint
        })
    },
    data() {
        return {
            showImprint: false
        }
    }
}
</script>
