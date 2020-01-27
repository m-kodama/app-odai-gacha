<template>
  <v-app>
    <v-content>
      <Header>
        <div v-if="isVisible" style="padding-top:100px;">{{ gachas[0].gacha_name }}</div>
        <button v-on:click="isVisible　=　!isVisible" style="padding-top:100px;">ボタン</button>
        <div style="height:2000px;"></div>
      </Header>
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
    _gachas: String
  },
  data: function() {
    return {
      isVisible: true
    };
  },
  computed: {
    gachas: function() {
      return JSON.parse(this._gachas);
    }
  }
};
</script>

<style>
</style>