<template>
	<div class="modal fade" id="{{ id }}">
		<div class="modal-dialog {{ modalSize }}">
			<div class="modal-content" v-if="showHeader">
				<slot name="header">
					<div class="modal-header">
						<button type="button" class="close" @click.prevent="close" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{{ title }}</h4>
					</div>
				</slot>
				<slot name="content">
					<div class="modal-body">
						<slot name="body"></slot>
					</div>
					<div class="modal-footer" v-if="showFooter">
						<slot name="footer">
							<button type="button"  @click.prevent="close" class="btn btn-default">Close</button>
							<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
						</slot>
					</div>
				</slot>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	props: {
		show: {
			default: false,
			type: Boolean,
			twoWay: true,
		},
		title: String,
		id: {
			type: String,
			required: true,
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showFooter: {
			type: Boolean,
			default: true,
		},
		size: String,
	},

	methods: {
		close () {
			this.show = false;
		}
	},

	computed: {
		modalSize () { return 'modal-' + this.size },
	},

	ready () {
		var $modal = $(this.$el).modal({
			show: this.show,
		}).on('hidden.bs.modal', (e) => {
			this.show = false
		})

		this.$watch('show', (show) => {
			$modal.modal(show ? 'show': 'hide')
		})
	},

}
</script>