</main>
<footer class="bg-light">

  <div class="text-center p-3" style="background:#CCCCCC">
  Copyright &copy 2021
  
  </div>
</footer>
<script>
// untuk merun summer note supaya texk area teksnya lebih variais
//misalnya blod, pragraf dll

// cara merun summer note
//pertama isi link dibagian header untuk summernote dan jquery.kemudian run dibagian footer seperti ini. 
//lalu tinggal panggil di text area dengancara memanggil id summernote
$(document).ready(function() {
  $('#summernote').summernote({
    callbacks: {
            onImageUpload: function(files) {
                for(let i=0; i < files.length; i++) {
                    $.upload(files[i]);
                }
            }
        },
     height:200,

     toolbar: [
			["style", ["bold", "italic", "underline", "clear"]],
			["fontname", ["fontname"]],
			["fontsize", ["fontsize"]],
			["color", ["color"]],
			["para", ["ul", "ol", "paragraph"]],
			["height", ["height"]],
			["insert", ["link", "picture", "imageList", "video", "hr"]],
			["help", ["help"]]
		],
		dialogsInBody: true,
		imageList: {
			endpoint: "daftar_gambar.php",
			fullUrlPrefix: "../gambar/",
			thumbUrlPrefix: "../gambar/"
		}
  });
  $.upload = function (file) {
        let out = new FormData();
        out.append('file', file, file.name);

        $.ajax({
            method: 'POST',
            url: 'upload_gambar.php',
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function (img) {
                $('#summernote').summernote('insertImage', img);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };
});
</script>
    
</body>
</html>