<template>
    <tr>
        <td v-if="displayIndex">{{(parseInt(page)-1)*parseInt(perPage) + (parseInt(rowIndex) + 1)}}</td>
        <template v-for="(field,fieldIndex) in fields" >
            <template v-if="(field.visible === undefined || field.visible)">
                <template v-if="isFieldComponent(field.name)">
                    <component :is="field.name"
                      :key="fieldIndex"
                      :row-data="row" :row-index="rowIndex" :row-field="field"
                      :class="bodyClass('vuetable-component', field)"
                      :style="{width: field.width}"
                      :colspan="field.colspan || 1"
                      @vuetable:field-event="onFieldEvent"
                    ></component>
                </template>
                <template v-else-if="isFieldSlot(field.name)">
                    <td :class="bodyClass('vuetable-slot', field)"
                      :key="fieldIndex"
                      :style="{width: field.width}"
                      :colspan="field.colspan || 1"
                    >
                      <slot :name="field.name"
                        :row-data="row" :row-index="rowIndex" :row-field="field"
                      ></slot>
                    </td>
                </template>
                <template v-else-if="!field.href">
                    <td
                        v-html="renderNormalField(field, row)" 
                        :class="[field.dataClass]"
                        :style="{width: field.width}"
                        :colspan="field.colspan || 1"
                        >
                        
                    </td>
                </template>
                <template v-else-if="field.href">
                    <td :class="[field.dataClass]" :colspan="field.colspan || 1" :style="{width: field.width}">
                      <router-link :to="field.href(getObjectValue(row,''))">
                        {{renderNormalField(field, row)}}
                      </router-link>
                    </td>
                </template>
            </template>
        </template>
    </tr>
</template>
<script>
    import _ from 'lodash'
    const initialData = () => {
      return {
          
      }
    }
    export default {
        name: 'MyTr',
        props: {
            row: {
                type: [Array, Object],
                default: null
            },
            fields: {
                type: Array,
                required: true
            },
            perPage: {
                type: Number,
                required: 0
            },
            rowIndex: {
                type: Number,
                required: 0
            },
            page: {
                type: Number,
                required: 0
            },
            displayIndex: {
                type: Boolean,
                default: false
            },
            fieldPrefix: {
              type: String,
              default() {
                return 'vuetable-field-'
              }
            }
        },
        data:initialData,
        components:{
        },
        methods : {
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
        },
        computed: {

        }
    }
</script>