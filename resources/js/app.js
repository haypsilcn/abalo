import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import mitt from 'mitt';
const emitter = mitt();

import Search from "./components/Search.vue";
import SiteHeader from "./components/Header.vue";
import SiteBody from "./components/Body.vue";
import SiteFooter from "./components/Footer.vue";

const app = createApp({});

app.component("Search", Search)
app.component("SiteHeader", SiteHeader)
app.component("SiteBody", SiteBody)
app.component("SiteFooter", SiteFooter)

app.config.globalProperties.emitter = emitter;
app.mount("#app")
