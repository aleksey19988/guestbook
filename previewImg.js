function previewFile() {
    let previewImage = document.getElementsByClassName('image-preview__image')[0];
    let file = document.getElementById('formFile').files[0];
    const previewImageContainer = document.getElementById('imagePreview');
    const previewDefaultText = previewImageContainer.querySelector('.image-preview__default-text');
    let reader = new FileReader();
    console.log(previewImage);

    reader.onloadend = function () {
        previewImage.src = reader.result;
    }

    if (file) {
        previewDefaultText.style.display = 'none';
        previewImage.style.display = 'block';
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
        previewDefaultText.style.display = 'flex';
        previewImage.style.display = null;
    }

}

function deleteImage() {
    let previewImage = document.getElementsByClassName('image-preview__image')[0];
    const previewImageContainer = document.getElementById('imagePreview');
    const previewDefaultText = previewImageContainer.querySelector('.image-preview__default-text');
    previewImage.src = "";
    previewImage.style.display = 'none';
    previewDefaultText.style.display = 'flex';
    $('#formFile').val('');
}