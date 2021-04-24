function previewFile() {
    let previewImage = document.getElementsByClassName('image-preview__image')[0];
    let file = document.getElementById('formFile').files[0];
    const previewImageContainer = document.getElementById('imagePreview');
    const previewDefaultText = previewImageContainer.querySelector('.image-preview__default-text');
    let reader = new FileReader();

    reader.onloadend = function () {
        previewImage.src = reader.result;
    }

    if (file) {
        previewDefaultText.style.display = 'none';
        previewImage.style.display = 'block';
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
        previewDefaultText.style.display = null;
        previewImage.style.display = null;
    }

}










// const inputFile = document.getElementById('formFile');
// const previewImageContainer = document.getElementById('imagePreview');
// const previewImage = previewImageContainer.querySelector('.image-preview__image');
// const previewDefaultText = previewImageContainer.querySelector('.image-preview__default-text');
//
// inputFile.addEventListener('change', function() {
//    const file = this.files[0];
//
//    if(file) {
//        const reader = new FileReader();
//
//        previewDefaultText.style.display = 'none';
//        previewImage.style.siplay = 'block';
//
//        reader.addEventListener('load', function() {
//            console.log(this);
//            console.log(typeof this.result);
//            previewImage.setAttribute('src', `${reader.result}`);
//        });
//
//        reader.readAsDataURL(file);
//    } else {
//        previewDefaultText.style.display = null;
//        previewImage.style.siplay = null;
//        previewImage.setAttribute('src', '')
//    }
// });