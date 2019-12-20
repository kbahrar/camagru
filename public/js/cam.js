 (function() {

  const realFileBtn = document.getElementById("real-file");
  const customBtn = document.getElementById("custom-button");
  const customTxt = document.getElementById("custom-text");

  
  var streaming = false,
  video        = document.querySelector('#video'),
  cover        = document.querySelector('#cover'),
  canvas       = document.querySelector('#canvas'),
  photo        = document.querySelector('#img-src'),
  startbutton  = document.querySelector('#startbutton'),
  filter = document.querySelector('#filter-src'),
  radio        = document.getElementsByName('filter'),
  width = 320,
  height = 0;
  
  navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);
    
    navigator.getMedia(
      {
        video: true,
        audio: false
      },
      function(stream) {
        if (navigator.mozGetUserMedia) {
          video.mozSrcObject = stream;
        } else {
          // var vendorURL = window.URL || window.webkitURL;
          
          // video.src = window.URL.createObjectURL('broken');
          video.srcObject=stream;
        }
        video.play();
      },
      function(err) {
        console.log("An error occured! " + err);
      }
      );
      
      video.addEventListener('canplay', function(ev){
        if (!streaming) {
          height = video.videoHeight / (video.videoWidth/width);
          video.setAttribute('width', width);
          video.setAttribute('height', height);
          canvas.setAttribute('width', width);
          canvas.setAttribute('height', height);
          streaming = true;
        }
      }, false);
      
function getfilter()
{
  radiobutton = document.querySelector('input[name="filter"]:checked').value;
  if (radiobutton == "imoji")
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/1.png');
    return 1;
  }
  else if (radiobutton == "dog")
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/2.png');
    return 2;
  }
  else if (radiobutton == "pokemon")
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/3.png');
    return 3;
  }
  else if (radiobutton == "loki")
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/4.png');
    return 4;
  }
  else if (radiobutton == "ndader")
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/5.png');
    return 5;
  }
  else
  {
    document.getElementById('snap').setAttribute('src', 'public/img/sup/6.png');
    return 6;
  }
}

function takepicture() {
  canvas.width = width;
  canvas.height = height;
  canvas.getContext('2d').drawImage(video, 0, 0, width, height);
  var data = canvas.toDataURL('image/jpeg');
  photo.setAttribute('value', data);
  data = getfilter();
  filter.setAttribute('value', data);
  realFileBtn.value = "";
  customTxt.innerHTML = "No file chosen, yet";
}

function uploadpicture(src)
{
    var pic = new Image();
    pic.src = src;
    pic.onload = function()
    {
      canvas.width = width;
      canvas.height = height;
      canvas.getContext('2d').drawImage(pic, 0, 0, width, height);
      photo.setAttribute('value', src);
      data = getfilter();
      filter.setAttribute('value', data);
    }
}

customBtn.addEventListener("click", function(){
    realFileBtn.click();
});

realFileBtn.addEventListener("change", function(){
    var file = this.files[0];
    if (file)
    {
      var reader = new FileReader();
      reader.addEventListener("load", function(){
        uploadpicture(this.result);
      });
      reader.readAsDataURL(file);
      customTxt.innerHTML = "choosen";
    }
    else
      customTxt.innerHTML = "No file chosen, yet";
});

startbutton.addEventListener('click', function(ev){
  takepicture();
  ev.preventDefault();
}, false);

})();