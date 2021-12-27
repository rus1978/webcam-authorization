$(function() {
	let photo = PhotoFactory.create(window.SETTINGS.pageName);
	photo.init();
});

class PhotoFactory
{
	static create (pageName) {

		let photo;

		switch (pageName) {
			case 'home':
				photo = new AuthPhoto();
				photo.ajaxUrl = '/auth-photo';
				break
			case 'account':
				photo = new SavePhoto();
				photo.ajaxUrl = '/save-photo';
				break
			default:
				throw "Class photo not found";
		}

		return photo;
	}
}

class BasePhoto{
	#baseEl;
	#buttStartCam;
	#buttTakePhoto;

	#width = 320;
	#height = 0;

	#streaming = false;

	#video = null;
	#canvas = null;
	#photo = null;

	ajaxUrl = null

	init() {
		this.#baseEl = $('#video-form');

		this.#video = document.getElementById('video');
		this.#canvas = document.getElementById('canvas');
		this.#photo = document.getElementById('photo');

		this.#buttStartCam = this.#baseEl.find('#button-start-camera').click(() => {
			this.#baseEl.attr('data-status', 'sign-in');
			this.startStreaming();
		});

		this.#buttTakePhoto = this.#baseEl.find('#button-take-photo').click(() => {
			this.takePhoto();
		});

		this.clearPhoto();
	}

	startStreaming() {
		navigator.mediaDevices.getUserMedia({ video: true, audio: false })
			.then((stream) => {
				this.#video.srcObject = stream;
				this.#video.play();
			})
			.catch((err) => console.log('An error occurred: ' + err));

		this.#video.addEventListener('canplay', (ev) => {
			if (!this.#streaming) {
				this.#height = this.#video.videoHeight / (this.#video.videoWidth / this.#width);

				if (isNaN(this.#height)) {
					this.#height = this.#width / (4 / 3);
				}

				this.#video.setAttribute('width', this.#width);
				this.#video.setAttribute('height', this.#height);
				this.#canvas.setAttribute('width', this.#width);
				this.#canvas.setAttribute('height', this.#height);
				this.#streaming = true;
			}
		}, false);
	}

	takePhoto() {
		var context = this.#canvas.getContext('2d');
		if (this.#width && this.#height) {
			this.#canvas.width = this.#width;
			this.#canvas.height = this.#height;
			context.drawImage(this.#video, 0, 0, this.#width, this.#height);

			var data = this.#canvas.toDataURL('image/png');
			this.#photo.setAttribute('src', data);

			this.send(data);
		}
		else {
			this.clearPhoto();
		}
	}

	send (data) {
		$.ajax({
			url:        this.ajaxUrl,
			data:       {
				face: data,
			},
			type:       'post',
			dataType:   'json',
			beforeSend: () => {
				this.#baseEl.attr('data-status', 'sign-in-loading');
			},
			complete:   () => {
				this.#baseEl.attr('data-status', 'sign-in');
			},
			error:      function(xhr) {
				console.error(xhr.responseText);
			},
			success:    (response, textStatus, request) => {
				console.log(response);

				if (typeof response.message !== 'undefined') {
					alert(response.message);
					return;
				}

				this.success(response)
			}
		});
	}

	clearPhoto() {
		var context = this.#canvas.getContext('2d');
		context.fillStyle = '#AAA';
		context.fillRect(0, 0, this.#canvas.width, this.#canvas.height);

		var data = this.#canvas.toDataURL('image/png');
		this.#photo.setAttribute('src', data);
	}
}

class AuthPhoto extends BasePhoto
{
	success(response) {
		if (response.status === 'success' && response.match === true) {
			alert('Вы прошли авторизацию с коэффициентом ['
				+ response.distanceEuclidean + ']');
			document.location.href = '/account';
		}
		if (response.status === 'success' && response.match === false) {
			alert('Вы не прошли авторизацию, т.к. коэффициент ['
				+ response.distanceEuclidean + ']');
		}
	}
}

class SavePhoto extends BasePhoto
{
	success(response) {
		if (response.status !== 'success') {
			alert('Что-то пошло не так');
		}
	}
}