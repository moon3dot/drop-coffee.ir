let html = document.getElementsByTagName('html');
let radios = document.getElementsByName('theme-mode-switch');

radios.forEach(function (input){
	input.addEventListener('change', function() {
		html[0].classList.remove(html[0].dataset.theme);
		html[0].dataset.theme = this.dataset.mode;
		html[0].classList.add(this.dataset.mode);
		ahuraSetCookie('ahura-theme-mode', this.dataset.mode, 365);
	});

	if(input.id === html[0].dataset.theme){
		input.checked = true;
		let event = new MouseEvent('mouseover', {
			view: window,
			bubbles: true,
			cancelable: true
		});
		document.querySelector(`label[for="${input.id}"]`).dispatchEvent(event);
	}
});