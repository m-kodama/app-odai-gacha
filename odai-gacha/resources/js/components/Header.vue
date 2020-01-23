<template>
  <div>
    <v-app-bar color="white" elevation="0" fixed>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-img src="../img/logo_icon.png" max-width="30"></v-img>
      <v-toolbar-title class="primary--text font-weight-bold">お題ガチャ</v-toolbar-title>

      <v-spacer></v-spacer>
      <div class="d-flex compact-form" style="max-width: 700px; width: 50%;">
        <v-text-field
          color="accent"
          outlined
          solo
          flat
          placeholder="検索"
          dense
          clearable
          hide-details
        ></v-text-field>
        <v-btn depressed color="#F5F0E3" class="ml-1" style="height: 40px;">
          <v-icon color="grey darken-1">mdi-magnify</v-icon>
        </v-btn>
      </div>
      <v-spacer></v-spacer>

      <v-btn icon @click="infoDialog=true">
        <v-icon>mdi-information-outline</v-icon>
      </v-btn>
      <v-dialog v-model="infoDialog" max-width="700">
        <v-card>がちゃです</v-card>
      </v-dialog>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      infoDialog: false
    };
  }
};
</script>

<style>
.compact-form {
  transform: scale(0.9);
  transform-origin: left;
}
</style>