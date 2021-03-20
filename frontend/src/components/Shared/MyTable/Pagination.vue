<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination" style="margin:0;">
        <li class="page-item" v-if="pagination.current_page > 1">
            <a class="page-link" href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(1)">
                <span aria-hidden="true">F</span>
                </a>
            </li>
        <li class="page-item" v-if="pagination.current_page > 1">
            <a class="page-link" href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
                <span aria-hidden="true">«</span>
                </a>
            </li>
        <li class="page-item" v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
            <a class="page-link" href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>
            </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
            <a class="page-link" href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
                <span aria-hidden="true">»</span>
                </a>
            </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
            <a class="page-link" href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.last_page)">
                <span aria-hidden="true">L</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
  export default{
    name: 'Pagination',
      props: {
      pagination: {
          type: Object,
          required: true
      },
      offset: {
          type: Number,
          default: 4
      }
    },
    computed: {
      pagesNumber() {
        if (!this.pagination.to) {
          return [];
        }
        let from = this.pagination.current_page - this.offset;
        if (from < 1) {
          from = 1;
        }
        let to = from + (this.offset * 2);
        if (to >= this.pagination.last_page) {
          to = this.pagination.last_page;
        }
        let pagesArray = [];
        for (let page = from; page <= to; page++) {
          pagesArray.push(page);
        }
          return pagesArray;
      }
    },
    methods : {
      changePage(page) {
        //this.pagination.current_page = page;
        this.$emit('paginate',page);
      }
    }
  }
</script>