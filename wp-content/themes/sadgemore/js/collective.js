document.addEventListener('DOMContentLoaded', function () {
	var form = document.getElementById('collective-enquiry-form');
	var status = document.getElementById('collective-form-status');

	if (!form || !status) {
		return;
	}

	form.addEventListener('submit', function (event) {
		event.preventDefault();

		if (!form.checkValidity()) {
			form.reportValidity();
			return;
		}

		var button = form.querySelector('button[type="submit"]');
		var originalLabel = button ? button.textContent : '';
		status.textContent = '';
		status.className = 'collective-form__status';
		form.classList.add('is-sending');

		if (button) {
			button.disabled = true;
			button.textContent = 'Sending...';
		}

		fetch(form.action, {
			method: 'POST',
			body: new FormData(form),
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (data) {
				var message = data && data.data && data.data.message ? data.data.message : 'Unable to send your enquiry. Please try again.';
				status.textContent = message;
				status.classList.add(data && data.success ? 'is-success' : 'is-error');
				if (data && data.success) {
					form.reset();
					if (window.turnstile) {
						window.turnstile.reset();
					}
				}
			})
			.catch(function () {
				status.textContent = 'Unable to send your enquiry. Please try again.';
				status.classList.add('is-error');
			})
			.finally(function () {
				form.classList.remove('is-sending');
				if (button) {
					button.disabled = false;
					button.textContent = originalLabel;
				}
			});
	});
});
