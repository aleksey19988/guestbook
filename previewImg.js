function previewFile() {
    const previewImage = document.getElementsByClassName('image-preview__image')[0];
    const file = document.getElementById('formFile').files[0];
    const previewImageContainer = document.getElementById('imagePreview');
    const previewDefaultText = previewImageContainer.querySelector('.image-preview__default-text');
    const deleteFileButton = document.getElementById('deleteFileButton');
    let reader = new FileReader();


    reader.onloadend = function () {
        previewImage.src = reader.result;
    }

    if (file) {
        previewDefaultText.style.display = 'none';
        previewImage.style.display = 'block';
        deleteFileButton.style.display = 'block';
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
    const deleteFileButton = document.getElementById('deleteFileButton');

    previewImage.src = "";
    previewImage.style.display = 'none';
    previewDefaultText.style.display = 'flex';
    deleteFileButton.style.display = 'none';
    $('#formFile').val('');
}