<template>
  <v-app>
    <v-content>
      <Header>
        <div v-for="gacha in gachas" :key="gacha.gacha_id">
          <MainCard :gacha="gacha"/>
        </div>
      </Header>
    </v-content>
  </v-app>
</template>

<script>
import Header from "../components/Header";
import MainCard from "../components/MainCard";


export default {
  components: {
    Header,
    MainCard
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
      const originGacha = JSON.parse(this._gachas)[0];
      const gachas = [];
      for (let i = 0; i < 30; i++) {
        const copyGacha = Object.assign({}, originGacha);
        gachas.push(copyGacha);
      }
      return gachas;
    }
  }
};
</script>

<style>
</style>