<template>

    <div><a href="/homepage">Home</a></div>
    <div><a href="/article">Article list</a></div>
    <div>
        <a href="#" @click="showCategories = !showCategories">Kategorie</a>
        <ul v-if="showCategories">
            <li v-for="category in categories">
                {{ category.name }}
            </li>
        </ul>
    </div>
    <div><a href="#">Verkaufen</a></div>
    <div>
        <a href="#" @click="showUnternehmen = !showUnternehmen">Unternehmen</a>
        <ul v-if="showUnternehmen">
            <li>Philosophie</li>
            <li>Karriere</li>
        </ul>
    </div>
    <br>
    <div>
        <vue-dock-menu :items="items" dock="RIGHT">
        </vue-dock-menu>
    </div>

</template>

<script>
import { DockMenu } from "vue-dock-menu";
import "vue-dock-menu/dist/vue-dock-menu.css";

export default {
    name: "Menu",
    components: {
        DockMenu
    },
    created() {
        this.getCategories()
    },
    data() {
        return {
            categories: [],
            showCategories: false,
            showUnternehmen: false,
            items: [
                {
                    name: "File",
                    menu: [{ name: "Open"}, {name: "New Window"}, {name: "Exit"}]
                },
                {
                    name: "Edit",
                    menu: [{ name: "Cut"}, {name: "Copy"}, {name: "Paste"}]
                }
            ]
        }
    },
    methods: {
        getCategories() {
            let xhr = new XMLHttpRequest()
            xhr.open("GET", "/api/categories", false)
            xhr.send()

            if (xhr.status === 200)
                this.categories = JSON.parse(xhr.responseText)
        }

    }
}
</script>
