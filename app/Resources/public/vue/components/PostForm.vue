<template>
	<validator name="postValidation" initial="isNew ? 'off' : 'on'">
	    <form method="POST" role="form" @submit.prevent="submit" novalidate>
	        <legend v-if="showLegend">{{isNew ? 'Crear' : 'Editar'}} Post</legend>

	        <div v-if="showGlobalErrors($postValidation)" class="alert alert-danger">
	        	<ul>
	        		<li v-show="showError($postValidation.title, 'required')">El título no puede estar vacío</li>
	        		<li v-show="showError($postValidation.title, 'minlength')">El título debe contener 5 caracteres o más</li>
	        		<li v-show="showError($postValidation.content, 'required')">El Contenido no puede estar vacío</li>
	        		<li v-show="showError($postValidation.content, 'minlength')">El Contenido debe contener 10 caracteres o más</li>
	        	</ul>
	        </div>

	        <div class="form-group" :class="{'has-error': markAsInvalid($postValidation.title)}">
	            <label for="">Título</label>
	            <input type="text" class="form-control" v-model="post.title"
	            v-validate:title="{required: true, minlength: 5}" detect-change="off">
	        </div>
	        <div class="form-group">
	            <label for="">Contenido</label>
	            <textarea class="form-control" v-model="post.content"
	            v-validate:content="{required: true, minlength: 10}" detect-change="off"></textarea>
	        </div>

			<hr>
			<div class="text-right">
		        <button type="submit" class="btn btn-primary" :disabled="$postValidation.invalid">Guardar</button>
		        <a href="#" @click="closeForm">Cerrar</a>
			</div>
	    </form>
    </validator>
</template>

<script>
export default {
	props: {
		post: { 
			//required: true,
			type: Object,
			default: () => {
				return {}
			}
		},
		pathList: {
			type: String
		},
		showLegend: {
			type: Boolean,
			default: true,
		},
		onClose: {
			type: Function,
			required: true,
		},
		onSubmit: {
			type: Function,
			default: () => {},
		}
	},

	data() {
		return {
			submited: false,
		}
	},

	methods: {
		submit() {
			this.submited = true
		},

		closeForm() {
			// this.submited = false
			// this.onClose.call();
		},

		markAsInvalid(field) {
			return field.dirty && field.invalid
		},

		showErrors(field) {
			return field.dirty && field.invalid
		},

		showGlobalErrors(container) {
			return this.showErrors(container.title)
				|| this.showErrors(container.content)
		},

		showError(field, type) {
			return this.showErrors(field) && !!field[type]
		},
	},

	computed: {
		isNew () {
			return !this.post.id
		},
	},

	ready() {
		this.$watch('post', (post, oldPost) => {
			if (post != oldPost){
				this.$resetValidation()
			}
		})
	},

	components: {
	},
}
</script>