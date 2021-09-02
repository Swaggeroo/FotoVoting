const actualBtn = document.getElementById('upload');

const fileChosen = document.getElementById('file-chosen');

actualBtn.addEventListener('change', function(){
    fileChosen.textContent = this.files[0].name
    PreviewImage();
})

function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("upload").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview").src = oFREvent.target.result;
    };
};