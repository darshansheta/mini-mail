export default {
  table: {
    tableClass: 'table table-condensed table-bordered',
    ascendingIcon: 'fa fa-angle-up',
    descendingIcon: 'fa fa-angle-down',
    handleIcon: 'glyphicon glyphicon-menu-hamburger',
    renderIcon: function(classes, options) {
      return `<span class="${classes.join(' ')}"></span>`
    }
  },
  pagination: {
    wrapperClass: "pagination pull-right",
    activeClass: "active",
    disabledClass: "disabled",
    pageClass: "",
    linkClass: "",
    icons: {
      first: "",
      prev: "",
      next: "",
      last: ""
    }
  }
}