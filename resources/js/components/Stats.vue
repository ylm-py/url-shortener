<template>
    <div class="container">
        <div class="table-container">
            <div class="header">
                <h1>Links Stats</h1>
            </div>
            <div class="goBackArrow">
                <router-link id="stats-link" to="/">&lt;---</router-link>
            </div>

            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Original URL</th>
                        <th>Shortened URL</th>
                        <th>Clicks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="stat in stats" :key="stat.id">
                        <td>{{ stat.id }}</td>
                        <td>
                            <a class="original-url" :href="stat.original_url" target="_blank">{{ stat.original_url }}</a>
                        </td>
                        <td>
                            <a :href="`api/${stat.short_code}`" target="_blank">{{ stat.short_code }}</a>
                        </td>
                        <td>{{ stat.click_count }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="pagination">
                <div class="arrows">
                    <button @click="previousPage" :disabled="currentPage === 1">&#8249;</button>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <button @click="nextPage" :disabled="currentPage === totalPages">&#8250;</button>
                </div>
                <div class="rows-per-page">
                    <label for="rowsPerPage">Rows per page:</label>
                    <select id="rowsPerPage" v-model="rowsPerPage" @change="fetchStats">
                        <option v-for="option in rowsPerPageOptions" :key="option" :value="option">{{ option }}</option>
                    </select>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>
<style src="./Stats.vue.style.css"></style>
<script>
import Footer from "./Footer.vue";
export default {
    name: "Stats",
    components: {
        Footer
    },
    data() {
        return {
            stats: [],
            currentPage: 1,
            totalPages: 1,
            rowsPerPage: 5,
            rowsPerPageOptions: [5, 10, 15],
        };
    },
    async mounted() {
        this.fetchStats();
    },
    methods: {
        async fetchStats() {
            try {
                const response = await axios.get('/urls', {
                    params: {
                        page: this.currentPage,
                        rowsPerPage: this.rowsPerPage,
                    },
                });
                this.stats = response.data.shortenedUrls;
                this.totalPages = response.data.meta.last_page;
            } catch (error) {
                this.$toast.error(error.response.data.message, "Error");
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchStats();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchStats();
            }
        },
    },
    watch: {
        rowsPerPage() {
            this.fetchStats();
        },
    },
};
</script>
  