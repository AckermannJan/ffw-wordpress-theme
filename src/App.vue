<template>
  <v-app id="my-app" class="flex flex-col md:min-h-screen">
    <transition name="fade">
      <v-overlay :value="isLoading" class="overlay" v-if="isLoading">
        <div class="welcomeLoader">
          <img src="https://seeklogo.com/images/F/feuerwehr-loschen-bergen-retten-logo-039F98CA40-seeklogo.com.png" alt="Retten Löschen Bergen Schützen">
          <p class="welcomeLoader__headline">
            Unsere Freizeit für Ihre Sicherheit -<br>
            Seit 140 Jahren
          </p>
          <p class="welcomeLoader__text">
            Wir freuen uns, dass Sie den Weg auf unsere Webseite gefunden haben.<br>
            Schauen Sie sich um und entdecken Sie die Vielfalt der Feuerwehr Traisa.
          </p>
          <v-progress-circular indeterminate size="64"></v-progress-circular>
        </div>
      </v-overlay>
    </transition>

    <transition name="fade">
      <app-header v-if="!isLoading" />
    </transition>

    <transition name="fade">
      <v-container fluid fill-height class="mb-8" v-if="!isLoading">
        <v-row justify="center">
          <v-col lg="2" sm="3" xs="12">
            <Sidebar />
          </v-col>
          <v-col lg="5" sm="8" xs="12">
            <router-view></router-view>
          </v-col>
        </v-row>
      </v-container>
    </transition>

    <transition name="fade">
      <app-footer v-if="!isLoading" />
    </transition>
  </v-app>
</template>

<script>
  import { mapGetters } from 'vuex';
  import Header from './components/partials/Header.vue';
  import Footer from './components/partials/Footer.vue';
  import Sidebar from "./components/partials/Sidebar";

  export default {
    data() {
      return {
        showLoader: true,
      };
    },
    computed: {
      ...mapGetters({
        isLoading: 'index/isLoading',
        loadingProgress: 'loadingProgress',
      }),

      loaderStyle() {
        return `width: ${this.loadingProgress}%;`;
      },
    },

    components: {
      Sidebar,
      appHeader: Header,
      appFooter: Footer,
    },
  };
</script>

<style lang="scss">
  @import "App";
</style>
