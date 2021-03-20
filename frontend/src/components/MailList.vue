<template>
    <div>
        <mail-list-filter @filterChange="filterChangeHandler($event)"></mail-list-filter>
        <my-table 
            v-bind:fields="fields" 
            v-bind:data="data"
            v-bind:displayIndex="true"
            v-bind:responsive="true"
            :table-class="['table-sm table-hover bg-white']"
            v-on:change="filterList($event)"
            style="margin:10px 5px 0 5px;"
            >
            
            <div
                slot="status"
                slot-scope="props"
            >
                    <span class="badge" :class="{
                        'badge-secondary': props.rowData.status == 'Posted',
                        'badge-primary': props.rowData.status == 'Sent',
                        'badge-danger': props.rowData.status == 'Failed'
                    }">{{props.rowData.status}}</span>
            </div>
            <div
                slot="attachmentsCount"
                slot-scope="props"
            >
               {{props.rowData.attachmentsCount ? 'Yes - '+props.rowData.attachmentsCount : 'No'}}
            </div>
            <div
                slot="action"
                slot-scope="props"
            >
                <a class="btn btn-info btn-sm" @click="viewMail(props.rowData.id)">View</a>
            </div>
            
        </my-table>
    </div>
</template>
<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';
import MyTable from '@/components/Shared/MyTable/MyTable'
import CssConfig from '@/components/Shared/MyTable/VuetableCssConfig.js'
import moment from 'moment';
import MailListFilter from './MailListFilter';

const fields = [{
                name: 'id',
                title:'#',
                sortField: 'id',
                visible:false
            }, {
                name: 'from',
                sortField: 'from',
                title: 'From',
            }, {
                name: 'to',
                sortField: 'to',
                title: 'To',
            }, {
                name: 'subject',
                title: 'Subject',
            }, {
                name: 'status',
                sortField: 'status',
                title: 'Status'
            }, {
                name: 'attachmentsCount',
                title: 'Attachments/Count'
            },  {
                name: 'sentAt',
                sortField: 'sent_at',
                title: 'Sent At',
                callback: function(date) {
                    if (date === null) {
                        return 'N/A';
                    }
                    return moment(date).format('DD/MM/YYYY  h:mm A');

                }
            }, {
                name: 'action',
                title: 'Action'
            }
            ];
            const data = () => {
                return {
                    fields: fields
                }
            }

export default {
    name: 'MailList',
    mounted(){
        this.filterList();
    },
    data:data,
    components: {
        MailListFilter,
        MyTable
    },
    methods:{
        ...mapActions({
            filterListAction:'miniMail/filterListAction',
        }),
        ...mapMutations({
            filtersMutation: 'miniMail/filtersMutation'
        }),
        filterList(data){
            this.filtersMutation({...data})
            this.filterListAction({})
        },
        filterChangeHandler(filters) {
            this.filterList({filters})
        },
        viewMail(id) {
            this.$router.push('/min-mail/'+id)
        }
    },
    computed: {
        ...mapGetters({
            data: 'miniMail/dataGetter',
        }),
    },
}
</script>