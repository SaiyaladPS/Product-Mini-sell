document.getElementById("imginput").onchange = function() {
    document.getElementById("previewimg").src = URL.createObjectURL(imginput.files[0]);

  }