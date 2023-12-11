function previewFile(key, label){
    const key_photo = document.querySelector('#' + key);
    const label_photo = document.querySelector('#' + label);
 
    label_photo.textContent = key_photo.files[0].name;
}

function previewImage() {
    var input = document.getElementById('customFile');
    var preview = document.getElementById('preview-image');
    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        document.getElementById("temporary-img").style.display="none";
    };

    reader.readAsDataURL(file);
}