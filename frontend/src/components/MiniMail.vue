<template>
 <div class="container-fluid" v-if="miniMail">
    <mini-mail-table :miniMail="miniMail"></mini-mail-table>
 </div>
</template>
<script>
import { mapGetters, mapActions,mapMutations } from 'vuex';
import MiniMailTable from './MiniMailTable'
export default {
    name: 'MiniMail',
    components: {
        MiniMailTable
    },
    mounted() {
        if (this.$route.params.id) {
            this.getMiniMailAction({id: this.$route.params.id})
        }
    },
    methods: {
        ...mapActions({
            getMiniMailAction: 'miniMail/getMiniMailAction'
        })
    },
    computed: {
        ...mapGetters({
            miniMail: 'miniMail/miniMailGetter',
        }),
    }
}
</script>