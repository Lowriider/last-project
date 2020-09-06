const uploadImg = document.getElementById("rent_ad_image");
const previewContainer = document.getElementById("image-preview");
const previewImage = previewContainer.querySelector(".image-preview");
const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");

    uploadImg.addEventListener("change", function() {
        const file = this.files[0]
        if(file) {
            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";
            previewImage.src = window.URL.createObjectURL(file)
        }
        else {
            previewDefaultText.style.display = none;
            previewImage.style.display = none;
        }
            
    });