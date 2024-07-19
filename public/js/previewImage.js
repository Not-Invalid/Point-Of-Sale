document.getElementById('dropzone-file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }

        reader.readAsDataURL(file);

        document.getElementById('file-name').innerText = `File: ${file.name}`;
    }
});