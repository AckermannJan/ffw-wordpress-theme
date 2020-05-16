<template>
  <div class="page page--home">
    <WelcomeMsg />
    <PagesList />
  </div>
</template>

<script>
import RecentPostsWidget from './widgets/RecentPosts.vue';
import WelcomeMsg from "./partials/WelcomeMsg";
import PagesList from "./widgets/PagesList";

export default {
  components: {
    PagesList,
    WelcomeMsg,
    RecentPostsWidget,
  },
};
</script>

<style type="postcss"></style>
