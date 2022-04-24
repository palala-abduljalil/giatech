import "@mdi/font/css/materialdesignicons.css";
import Vue from "vue";
import Vuetify from "vuetify";
// import preset from "./default-preset/preset";
import "vuetify/dist/vuetify.min.css";
Vue.use(Vuetify);

export default new Vuetify({
    // preset,
    icons: {
        iconfont: "mdi",
    },
});
