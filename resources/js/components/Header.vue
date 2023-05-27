<template>

    <div><a href="#">Home</a></div>
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
</template>

<script>
export default {
    name: "Menu",
    created() {
        this.getCategories()
    },
    data() {
        return {
            categories: [],
            showCategories: false,
            showUnternehmen: false
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
