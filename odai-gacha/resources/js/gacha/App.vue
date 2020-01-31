<template>
  <v-app>
    <v-content>
      <Header>
        <div class="app-main-content" ref="mainContent">
          <div class="main-card-wrapper pa-2" v-for="gacha in gachas" :key="gacha.gacha_id">
            <MainCard :gacha="gacha" />
          </div>
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
      isVisible: true,
    };
  },
  computed: {
    gachas: function() {
      const originGacha = JSON.parse(this._gachas)[0];
      const gachas = [];
      for (let i = 0; i < 30; i++) {
        const copyGacha = Object.assign({}, {...originGacha, gacha_id: i});
        gachas.push(copyGacha);
      }
      return gachas;
    },
  },
};
</script>

<style scoped>
.app-main-content {
  width:100%;
  display: flex;
  flex-wrap: wrap;
  padding: 16px;
}
/* xs */
@media screen and (max-width: 600px) {
  .main-card-wrapper {
    width: calc(100% / 1);
  }
}
/* sm */
@media screen and (min-width:600px) and (max-width:960px) {
  .main-card-wrapper {
    width: calc(100% / 3);
  }
}
/* md */
@media screen and (min-width:960px) and (max-width:1264px) {
  .main-card-wrapper {
    width: calc(100% / 3);
  }
}
/* lg */
@media screen and (min-width:1264px) and (max-width:1420px) {
  .main-card-wrapper {
    width: calc(100% / 3);
  }
}
/* lgg */
@media screen and (min-width:1420px) and (max-width:1904px) {
  .main-card-wrapper {
    width: calc(100% / 4);
  }
}
/* xl */
@media screen and (min-width:1904px) {
  .main-card-wrapper {
    width: calc(100% / 5);
  }
}

</style>