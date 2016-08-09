<template>
<nav aria-label="Page navigation">
  <ul class="pagination" v-if="pages > 0">

	<li v-if="!dynamicPrevNext || previous" :class="{disabled: !previous}">
      <a href="#" aria-label="Previous" @click.prevent="click(previous)" v-if="previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
      <span v-else aria-hidden="true">&laquo;</span>
    </li>

    <li v-for="current in pagesRange" :class="{active: page == current}">
      <a href="#" aria-label="Previous" v-if="page != current" @click.prevent="click(current)">
        {{current}}
      </a>
      <span v-else>{{current}}</span>
    </li>
   
    <li v-if="!dynamicPrevNext || next"  :class="{disabled: !next}">
      <a href="#" aria-label="Next" @click.prevent="click(next)" v-if="next">
        <span aria-hidden="true">&raquo;</span>
      </a>
	  <span aria-hidden="true" v-else>&raquo;</span>
    </li>
  </ul>
</nav>
</template>

<script>
export default {
	props: {
		page: { type: Number, default: 1},
		perPage: { type: Number, required: true},
		count: { type: Number, required: true},
		onClick: {type: Function, required: true},
		dynamicPrevNext: {type: Boolean, default: false}
	},

	data () {
		return {
	        pages: 0,
	        startRecord: 0,
	        previous: false,
	        next: false
		}
	},

	computed: {
		pagesRange () {
			return _.range(1, this.pages + 1)
		},

		pages () {
			return (this.count % this.perPage == 0) 
	        	? this.count / this.perPage
	            : Math.floor((this.count / this.perPage) + 1)
		},

		startRecord () {
			return (this.page * this.perPage) - this.perPage
		},

		previous () {
			return this.page > 1 ? this.page - 1 : false
		},

		next () {
			return this.page < this.pages ? this.page + 1 : false
		},
	},

	methods: {
	    click (page) {
			this.onClick(page)
			this.page = page
	    }
	},
}
</script>