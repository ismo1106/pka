var wrapper = document.getElementById("signature-pad"),
        clearButton = wrapper.querySelector("[data-action=clear]"),
        saveButton = wrapper.querySelector("[data-action=save]"),
        canvas = wrapper.querySelector("canvas"),
        signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

saveButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        alert("Please provide signature first.");
    } else {
        //window.open(signaturePad.toDataURL());
        var canvasData = signaturePad.toDataURL("image/png");
        $.post(url, {
            txtImg : canvasData
        }, function(data, statuss){
            bootbox.alert('Signature has been saved!', function (){
                window.location = baseurl;
            });
            console.log('successful');
        });
        
        /*var ajax = new XMLHttpRequest();
        ajax.open("POST", url, false);
        ajax.setRequestHeader('Content-Type', 'application/upload');
        ajax.send(canvasData);
        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4) {
                var response = JSON.parse(ajax.responseText);
                if (ajax.status === 200 && response.status === 'OK') {
                    console.log('successful');
                } else {
                    console.log('failed');
                }
            }
        }*/
        //window.location = baseurl;
    }
});
