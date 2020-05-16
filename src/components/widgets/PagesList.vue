<template>
    <div>
        <v-row v-for="page in pages" no-gutters>
            <v-col cols="8" class="page__img">
                <img :src="page.startBild" alt="Vorschaubild Seite"/>
            </v-col>
            <v-col class="page__text">
                <h2 class="mb-3">{{page.post_title}}</h2>
                <p>{{ page.post_content.substr(0, 250) + "..." }}</p>
                <v-btn light :to="'/' + page.post_name" color="#af4a45" absolute right>Weiterlesen</v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
  import {mapGetters} from "vuex";

  export default {
    name: "PagesList",
    computed: {
      ...mapGetters('index', {
        isLoading: 'isLoading',
        pages: 'pages',
      }),
    }
  }
</script>

<style scoped lang="scss">
    @import "PageList";
</style>