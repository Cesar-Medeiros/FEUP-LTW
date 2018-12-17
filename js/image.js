

// Show the file browse dialog
document.querySelector('#choose-upload-button').addEventListener('click', function(e) {
	e.preventDefault();
	document.querySelector('#upload-file').click();
});


// When a new file is selected
document.querySelector('#upload-file').addEventListener('change', function() {
	var file = this.files[0],
		excel_mime_types = [ 'image/jpeg', 'image/png' ];
	
	document.querySelector('#error-message').style.display = 'none';
	
	// Validate MIME type
	if(excel_mime_types.indexOf(file.type) == -1) {
		document.querySelector('#error-message').style.display = 'block';
		document.querySelector('#error-message').innerText = 'Error : Only JPEG and PNG files allowed';
		return;
	}

	let maxsize = 2;
	if(file.size > maxsize*1024*1024) {
		document.querySelector('#error-message').style.display = 'block';
		document.querySelector('#error-message').innerText = `Error : Exceeded size ${maxsize}MB`;
		return;
	}

	document.querySelector('#upload-choose-container').style.display = 'none';

	var reader  = new FileReader();
	
    reader.onload = function(e)  {
		var image = document.createElement("img");

		image.id = 'image';
		image.src = e.target.result;
		document.querySelector('#placeholder').appendChild(image);
		document.querySelector('#cancel-button').style.display = 'block';
	}
	reader.readAsDataURL(file);	
});


// Cancel button event
document.querySelector('#cancel-button').addEventListener('click', function(event) {
	event.preventDefault();
	document.querySelector('#error-message').style.display = 'none';
	document.querySelector('#upload-choose-container').style.display = 'block';

	document.querySelector('#upload-file').setAttribute('value', '');
	document.querySelector('#image').remove();
	this.style.display = 'none';
});