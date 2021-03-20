import Vue from 'vue'
import Vuex from 'vuex'
import miniMail from './vuex/miniMail'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
        miniMail
    },
})
