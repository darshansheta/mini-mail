<template>
    <div> 
    <div :class="{'table-responsive':responsive}">
    <table :class="['table',...tableClass]">
        <thead>
            <tr>
                    <th v-if="displayIndex">No.</th>
                <template v-for="(field,fieldIndex) in fields" >
                <th 
                    v-on:click.prevent="changeSort(field.sortField ? field.sortField : undefined )" 
                    v-if="field.visible === undefined || field.visible" 
                    :class="[field.titleClass]"
                    >
                    {{field.title}}
                    <span v-if="sortBy && field.sortField == sortBy && sortOrder =='asc'">&#9650;</span>
                    <span v-if="sortBy && field.sortField == sortBy && sortOrder =='desc'">&#9660;</span>
                </th>
            </template>
            </tr>
            </thead>
            <tbody v-if="!reducer">
                <template  v-for="(row,rowIndex) in data.data">
                    <my-tr 
                        :key="rowIndex"
                        :row="row"
                        :fields="fields"
                        :displayIndex="displayIndex"
                        :fieldPrefix="fieldPrefix"
                        :perPage="data.per_page"
                        :page="page"
                        :rowIndex="rowIndex"
                    >
                            <slot v-if="isFieldSlot(field.name)" v-for="field in fields" :name="field.name" :slot="field.name"
                              :row-data="row" :row-index="rowIndex" :row-field="field"
                            ></slot>
                    </my-tr>
                </template>
                <!-- <tr v-for="(row,rowIndex) in data.data" :key="rowIndex" >
                    <td v-if="displayIndex">{{(page-1)*data.per_page + (rowIndex + 1)}}</td>

                    <template v-for="(field,fieldIndex) in fields" >
                        <template v-if="(field.visible === undefined || field.visible)">
                            <template v-if="isFieldComponent(field.name)">
                                <component :is="field.name"
                                  :key="fieldIndex"
                                  :row-data="row" :row-index="rowIndex" :row-field="field"
                                  :class="bodyClass('vuetable-component', field)"
                                  :style="{width: field.width}"
                                  @vuetable:field-event="onFieldEvent"
                                ></component>
                            </template>
                            <template v-else-if="isFieldSlot(field.name)">
                                <td :class="bodyClass('vuetable-slot', field)"
                                  :key="fieldIndex"
                                  :style="{width: field.width}"
                                >
                                  <slot :name="field.name" :slot="field.name"
                                    :row-data="row" :row-index="rowIndex" :row-field="field"
                                  ></slot>
                                </td>
                            </template>
                            <template v-else-if="!field.href">
                                <td
                                    v-html="renderNormalField(field, row)" 
                                    :class="[field.dataClass]"
                                    :style="{width: field.width}"
                                    >
                                    
                                </td>
                            </template>
                            <template v-else-if="field.href">
                                <td :class="[field.dataClass]" :style="{width: field.width}">
                                  <router-link :to="field.href(getObjectValue(row,''))">
                                    {{renderNormalField(field, row)}}
                                  </router-link>
                                </td>
                            </template>
                        </template>
                    </template>
                </tr> -->
                <tr v-show="data.data && data.data.length == 0">
                  <td :colspan="fields.length + (displayIndex ? 1 : 0)" >No records found.</td>
                </tr>
            </tbody>
            <tbody v-else>
                <template v-for="(reduced,reducedIndex, loopIndex) in reducedData" >
                    <my-tr
                        v-if="reducerPrepend && reducerPrepend.length"
                        :row="reduced"
                        :fields="reducerPrepend"
                        :displayIndex="false"
                        :fieldPrefix="fieldPrefix"
                        :perPage="data.per_page"
                        :page="page"
                        :rowIndex="parseInt(loopIndex)"
                    />
                    <template v-for="(row, rowIndex) in reduced">


                            <my-tr 
                                :row="row"
                                :fields="fields"
                                :displayIndex="displayIndex"
                                :fieldPrefix="fieldPrefix"
                                :perPage="data.per_page"
                                :page="1"
                                :rowIndex="parseInt(rowIndex)"
                            >
                                <template v-if="isFieldSlot(field.name)" v-for="field in fields">
                                    <slot :name="field.name" :slot="field.name"
                                      :row-data="row" :row-index="rowIndex" :row-field="field"
                                    ></slot>
                                </template>
                            </my-tr>
                    </template>

                    <my-tr
                        v-if="reducerAppend && reducerAppend.length"
                        :row="reduced"
                        :fields="reducerAppend"
                        :displayIndex="false"
                        :fieldPrefix="fieldPrefix"
                        :perPage="data.per_page"
                        :page="page"
                        :rowIndex="parseInt(reducedIndex)"
                    />
                    <tr >
                        <td :colspan="fields.length + (displayIndex ? 1 : 0)" style="width:100% !imporant;position: relative;" >
                            
                        </td>
                    </tr>
                </template>
                <template v-if="staticAppends && staticAppends.length" v-for="(staticAppend, sIndex) in staticAppends" >
                    <my-tr
                        v-if="staticAppend && staticAppend.length"
                        :row="data"
                        :fields="staticAppend"
                        :displayIndex="false"
                        :fieldPrefix="fieldPrefix"
                        :perPage="data.per_page"
                        :page="page"
                        :rowIndex="0"
                    />
                </template>
            </tbody>
            <tfoot v-if="!responsive">
                <tr >
                    <td :colspan="fields.length + (displayIndex ? 1 : 0)" style="width:100% !imporant;position: relative;" >
                        <div style="">
                    <vue-pagination  v-bind:pagination="data"
                                        v-on:paginate="changePage"
                                        :offset="4">
                       </vue-pagination>
                       </div>
                       
                       </td>
                </tr>
            </tfoot>
   
    </table>


</div>
    <template v-if="responsive">
    <vue-pagination  v-bind:pagination="data"
                        v-on:paginate="changePage"
                        :offset="4">
       </vue-pagination>
       </template>
       <button class="btn btn-default" v-if="exportButton" style="float:right" @click.prevent="$emit('export')">EXPORT <i class="fa fa-download "></i></button>
</div>
</template>
<script>
import VuePagination from './Pagination'
import MyTr from './MyTr'
import _ from 'lodash'
const initialData = () => {
  return {
      sortBy: '',
      sortOrder: 'asc',
      page:1
  }
}
export default {
    name: 'Pagination',
    props: {
        data: {
            type: [Array, Object],
            default: null
        },
        fields: {
            type: Array,
            required: true
        },
        displayIndex: {
            type: Boolean,
            default: false
        },
        responsive: {
            type: Boolean
        },
        exportButton: {
            default:false,
            type: Boolean
        },
        fieldPrefix: {
          type: String,
          default() {
            return 'vuetable-field-'
          }
        },
        tableClass:{
            type:[Array,String],
            default:''
        },
        reducer:{
            type:String,
            default:null
        },
        reducerAppend:{
            type: Array,
            default:() => []
        },
        reducerPrepend:{
            type: Array,
            default:() => {}
        },
        staticAppends:{
            type: Array,
            default:() => {}
        }
    },
    data:initialData,
    components:{
        MyTr,
        VuePagination
    },
    methods : {
      changePage(page) {
        this.page = page
            this.$emit('change',{
                page,
                sort: {
                   sortBy: this.sortBy, 
                   sortOrder: this.sortOrder, 
                }
            });
      },
      changeSort(field) {
        if (field == undefined) {
            return false;
        }
        let page = 1;
        if (this.sortBy == field) {

            
            if (this.sortOrder == 'asc'){
                this.sortOrder = 'desc';
            } else if (this.sortOrder == 'desc') {
                this.sortBy = '';
            } else {
                this.sortOrder = 'asc';
            }

            
        } else {

            
            this.sortBy = field;
            this.sortOrder = 'asc';
        }
        this.$emit('change',{
                    page,
                    sort:{
                        sortBy: this.sortBy,
                        sortOrder: this.sortOrder
                    }
                });
        },
        hasCallback: function hasCallback(item) {
          return item.callback ? true : false;
        },
        renderNormalField: function renderNormalField(field, item) {
          return this.hasCallback(field) ? this.callCallback(field, item) : this.getObjectValue(item, field.name, '');
        },
        callCallback: function callCallback(field, item) {
          if (!this.hasCallback(field)) return;

          if (typeof field.callback == 'function') {
            return field.callback(this.getObjectValue(item, field.name));
          }

          var args = field.callback.split('|');
          var func = args.shift();

          if (typeof this.$parent[func] === 'function') {
            var value = this.getObjectValue(item, field.name);

            return args.length > 0 ? this.$parent[func].apply(this.$parent, [value].concat(args)) : this.$parent[func].call(this.$parent, value);
          }

          return null;
        },
        getObjectValue: function getObjectValue(object, path, defaultValue) {
          defaultValue = typeof defaultValue === 'undefined' ? null : defaultValue;

          var obj = object;
          if (path.trim() != '') {
            var keys = path.split('.');
            keys.forEach(function (key) {
              if (obj !== null && typeof obj[key] !== 'undefined' && obj[key] !== null) {
                obj = obj[key];
              } else {
                obj = defaultValue;
                return;
              }
            });
          }
          return obj;
        },
        isFieldComponent (fieldName) {
          if (fieldName instanceof Object) {
            // let's assume it is a Vue component
            return true
          }

          return fieldName.slice(0, this.fieldPrefix.length) === this.fieldPrefix
            || fieldName.slice(0, 2) === '__'
        },

        isFieldSlot (fieldName) {
          return typeof this.$scopedSlots[fieldName] !== 'undefined'
        },
        bodyClass (base, field) {
          return [ base, field.dataClass ]
        },
        reducedRow(data) {

        }
    },
    computed: {
        reducedData() {
            if (!_.isEmpty(this.reducer) && this.data && this.data.data) {
                console.log(this.data.data[0])
                return this.data.data.reduce((data,row) => {
                    (data[row[this.reducer]] = data[row[this.reducer]] || []).push(row);
                        return data;
                },{})
            }
            return [];
        }
    }
}
</script>