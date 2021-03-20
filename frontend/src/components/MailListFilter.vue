
<template>
    <div class="container-fluid" style="border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 10px;padding-top: 10px">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row" >

                            <div class="col-3">
                                <select class="form-control" v-model="status">
                                    <option value="">ALL</option>
                                    <option value="Sent">Sent</option>
                                    <option value="Posted">Posted</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" v-model="filters.from" placeholder="From Email">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" v-model="filters.to" placeholder="To Email">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" v-model="filters.subject" placeholder="Subject">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapActions,mapMutations } from 'vuex';
import _ from 'lodash';
const initialData = () => {
    return {
        filters: {
            to: '',
            from: '',
            subject: ''
        }
    }
}
export default {
    name:'MailListFilter',
    data:initialData,
    methods: {

        ...mapMutations({
            filtersMutation: 'miniMail/filtersMutation'
        }),
    },
    computed: {
        status: {
            get () {
                return this.$store.state.miniMail.status
            },
            set (val) {
                this.$store.commit('miniMail/statusMutation',val)
            }
        }
    },
    watch: {
        filters: {
            handler:_.debounce(function(){
                this.$emit('filterChange',{...this.filters,status:this.status});
            },300),
            deep: true
        },
        status: function(val) {
            this.$emit('filterChange',{...this.filters,status:this.status});
        }
  }
}
</script>