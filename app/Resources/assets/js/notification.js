export class Notification {
	constructor(duration = 5000) {
		this.duration = duration
	}

	show (type, message, title) {
		new PNotify({
			type: type,
			title: title,
			text: message,
		})
	}

	success(message, title = 'Información') {
		this.show('success', message, title)
	}
}