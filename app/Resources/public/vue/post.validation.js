export default class Validator {
 	validate (post) {
		return {
			title: {
				empty: post.title != undefined && !!post.title.trim(),
			},
			content: {
				empty: post.content != undefined && !!post.content.trim(),
			}
		}			
	}
}