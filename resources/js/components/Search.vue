<template>
    <div><a href="/article/create">Create new article</a></div>
    <br>
    <div>
        <label for="resultsearch">Search the article</label>
        <div>
            <form @submit="searchBtn">
                <input
                    type="text"
                    id="resultsearch"
                    size=30
                    placeholder="What are you looking for?"
                    v-model.trim="keyword"
                    @input="search()"
                />
                <button>Search</button>
            </form>

        </div>
        <br>

        <div v-if="results.length !== 0">
            <div id="pagination" v-if="pages > 0">
                <button class="pages" :disabled="currentPage === 1" @click="nextOrPrevious(false)">&lt </button>
                <div class="pages" v-for="page in pages">
                    <b v-if="currentPage === page">{{ page }}</b>
                    <p v-else-if="currentPage + pageRange">{{ page }}</p>

                </div>
                <button class="pages" @click="nextOrPrevious(true)" :disabled="currentPage === pages">&gt</button>
            </div>

            <table  class="table">
                <tr>
                    <th>ArticleID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Created at</th>
                </tr>

                <tr v-for="result in results" :key="result.id">
                    <td> {{ result.id }} </td>
                    <td v-if="result.image.length > 0">
                        <img :src="result.image" width="100" height="100" alt="">
                    </td>
                    <td v-else>
                        No image found
                    </td>
                    <td> {{ result.name }} </td>
                    <td> {{ result.price }}€</td>
                    <td> {{ result.description }} </td>
                    <td> {{ result.creator_id }} </td>
                    <td> {{ result.created_at }} </td>
                </tr>
            </table>
        </div>

        <div v-else-if="results.length === 0 && (btnClicked === true || keyword.length >= 3)">
            No article found
        </div>
    </div>
</template>

<script>
    export default {
        name: "Search",
        data() {
            return {
                btnClicked: false,
                keyword: '',
                results: [],
                pages: 0,
                currentPage: 1,
                pageRange: 2
            }
        },
        methods: {
            search() {
                this.btnClicked = false
                this.results = []
                this.pages = 0
                this.currentPage = 1

                let xhr = new XMLHttpRequest()
                xhr.open("POST", "/api/articles/search", false)
                xhr.setRequestHeader('Content-Type', 'application/json')

                if (this.keyword.length >= 3) {
                    let data = {
                        search: this.keyword,
                        quickSearch: true
                    }

                    xhr.send(JSON.stringify(data))

                    if (xhr.status === 200)
                        this.results = JSON.parse(xhr.responseText)
                    else
                        this.results = []
                } else
                    this.results = []
            },
            searchBtn(event) {
                event.preventDefault()
                this.btnClicked = true

                let xhr = new XMLHttpRequest()
                xhr.open("POST", "/api/articles/search", false)
                xhr.setRequestHeader('Content-Type', 'application/json')

                let data = {
                    search: this.keyword,
                    quickSearch: false,
                }

                xhr.send(JSON.stringify(data))
                let response
                if (xhr.status === 200)
                    response = JSON.parse(xhr.responseText)

                this.results = response.results
                this.pages = response.pages
            },
            nextOrPrevious(next) {
                if (next)
                    this.currentPage++
                else
                    this.currentPage--

                let xhr = new XMLHttpRequest()
                xhr.open("POST", "/api/articles/search", false)
                xhr.setRequestHeader('Content-Type', 'application/json')

                let data = {
                    search: this.keyword,
                    quickSearch: false,
                    currentPage: this.currentPage
                }

                xhr.send(JSON.stringify(data))
                let response
                if (xhr.status === 200)
                    response = JSON.parse(xhr.responseText)

                this.results = response.results
            }

        }
    }
</script>

<style lang="scss" scoped>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

#pagination {
    justify-content: center;
    align-items: center;
    text-align: center;
}

.pages {
    display: inline-block;
    margin: 1em;
}
</style>

