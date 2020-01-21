<template>
  <v-app>
    <v-content>
      <Header />
      <div style="padding-top:100px;">{{ test }}</div>
    </v-content>
  </v-app>
</template>

<script>
import Header from "../components/Header";

export default {
  components: {
    Header
  },
  props: {
    test: String
  }
  // data: () => ({
  //   message: 'こんにちはvue'
  // }),
};
</script>

<style>
</style>