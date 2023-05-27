<template>
    <hr/>
    <div id="footer">
        <a href="#" @click="show">Imprint</a>
    </div>
</template>

<script>
    import Imprint from "./Imprint.vue";
export default {
    name: "SiteFooter",
    components: {
        Imprint
    },
    data() {
        return {
            showImprint: false,
        }
    },
    methods: {
        show() {
            this.showImprint = true
            this.emitter.emit("show-imprint", this.showImprint)
        }
    }
}
</script>
