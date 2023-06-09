<template>
  <div class="container">
    <div class="content">
      <div class="two">
        <h1>URL Shortener
          <span>Make your links shorter</span>
        </h1>
      </div>
      <form @submit.prevent="shortenUrl">
        <input required type="text" v-model="url" placeholder="Enter URL" />
        <button type="submit">Shorten</button>
      </form>
      <router-link id="stats-link" to="/stats">View Stats</router-link>
      <p v-if="shortenedUrl" class="shortened">
        Shortened URL: <a class="shortened-url" :href="shortenedUrl" target="_blank">{{ shortenedUrl }}</a>
      </p>
    </div>
    <Footer />
  </div>
</template>
<style src="./App.vue.style.css"></style>

<script>
import Footer from "./Footer.vue";
export default {
  components: {
    Footer,
  },
  data() {
    return {
      url: '',
      shortenedUrl: null,
    };
  },
  methods: {
    async shortenUrl() {
      try {
        const response = await axios.post('/shorten', {
          url: this.url,
        });
        console.log(response.data)
        this.shortenedUrl = response.data.shortUrl;
      } catch (error) {
        this.showError(error.response.data.message);
      }
    },
    showError(error) {
      this.$toast.error(error);
    },
  },
};
</script>