<script>
export default {
	bind () {
		let $el = $(this.el)

		if(!$el.is('textarea, :text')) {
			throw new Error('Solo se permite usar la directiva "v-editor" en input[text] o textarea')
		}

		let $editorElement = $('<div/>').insertAfter($el.hide())

		this.$editor = new MediumEditor($editorElement);

		// editableInput
		this.$editor.subscribe('blur', (event, editable) => {
			$el.val(this.$editor.getContent()).change()
      	});
	},

	update (content) {
		this.$editor.setContent(content || null)			
	}
}
</script>