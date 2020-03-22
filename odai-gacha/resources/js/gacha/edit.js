import Vue from "vue";
import Edit from "./Edit.vue";
import "@mdi/font/css/materialdesignicons.css";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "../bootstrap";

Vue.use(Vuetify);

new Vue({
    el: "#app",
    vuetify: new Vuetify({
        icons: {
            iconfont: "mdi",
        },
        theme: {
            themes: {
                light: {
                    primary: "#F0134D",
                    secondary: "#F5F0E3",
                    accent: "#40BFC1",
                    warning: "#FF6F5E",
                },
                dark: {
                    primary: "#F0134D",
                    secondary: "#F5F0E3",
                    accent: "#40BFC1",
                    warning: "#FF6F5E",
                },
            },
        },
    }),
    components: { Edit },
});
