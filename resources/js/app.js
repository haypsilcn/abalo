import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import mitt from 'mitt';
const emitter = mitt();

import Search from "./components/Search.vue";
import SiteHeader from "./components/Header.vue";
import SiteBody from "./components/Body.vue";
import SiteFooter from "./components/Footer.vue";
import { DockMenu } from "vue-dock-menu";

const app = createApp({
    created: function () {
        Echo.channel("maintenance").listen("MaintenanceNotification", () => {
            alert("We are currently under improvement Abalo for you!\n" +
                "After a short break we'll right back for you. Promised!")
        });

    },

});

app.component("Search", Search)
app.component("SiteHeader", SiteHeader)
app.component("SiteBody", SiteBody)
app.component("SiteFooter", SiteFooter)
app.component("DockMenu", DockMenu)

app.config.globalProperties.emitter = emitter;
app.mount("#app")
