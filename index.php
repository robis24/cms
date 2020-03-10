<?php

$url = $_SERVER['REQUEST_URI'];

$url_components = parse_url($url);
parse_str($url_components['query'], $params);

if($params['mode'] == "edit"){
  $edit = "true";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
  <style>
  body, html{
    margin:0;
    padding:0;
    font-family: 'Open Sans', sans-serif;
    scroll-behavior: smooth;
  }
  .side{
    border-right:1px solid #c1c1c1;
    float:left;
    width:270px;
    margin-right:-1px;
    height: 100vh;
    position: fixed;


  }
  td {
    border-right: 43px solid white;
  }
  nav{
    margin: 6em 0 2em 0;
  }
  nav a, nav a:visited{
    padding: 1em 0 1em 1em;
    display: block;
    color:black;
    text-decoration:none;
  }
  ul{
    list-style: none;
  }
  li{
    border-bottom: 1px solid #c1c1c1;
    cursor:pointer;
  }
  .content{
    float:right;
    width:calc(100% - 200px)
  }
  header{
    z-index: 900;
    border-bottom: 1px solid #c1c1c1;
    position: fixed;
    width: 100%;
    background: white;
    padding: 1em;
  }
  section{
    min-height:100vh;
    margin-left: 100px;
  }
  .section-helper{
    height:7em;
  }
  .inner-section{
    margin-right: 1.8em;
  }
  .content-wrapper{
    margin: 0 auto;
    width:100%;
    max-width: 1200px;
  }






  .text-block, .img-block{
    width:100%;
    margin-bottom: 4em;
    border-bottom: 1px solid #c1c1c1;
    padding-bottom: 2em;
  }
  .img-block.full{
    min-height: 400px;
  }
  .edit-mode .img-block.full{
    background: #c5c5c5;
  }
  .img-block .img-wrapper .row{
    display: flex;
  }
  .img-block .img-wrapper .row div{
    transition: all 1s;
    display: table;
    width:100%;
    height:200px;
    margin:1em;
  }
  .edit-mode .img-block .img-wrapper .row div{

    background:#c5c5c5;
  }
  .img-block .img-wrapper{
    position: relative;
    width:100%;
    min-height:1290px;
  }
  .img-wrapper p{
    display: none;
    margin:0;
    border:none;
  }
  .edit-mode .img-wrapper p{
    display: block;
    background: white;
  }

  .img-block img{
    width:100%;
    height:auto;
  }
  .text-block:focus{

    border:none;
    outline:none;
  }
  .hide{
    display:none;
  }
  .img-block .img-wrapper .row div.img-selected{
    width: 1000%;
  }

  .img-selected p {
    display: block;
    position: absolute;
    left: 0;
    transform: translateY(-42px);
  }

  .row div.img-selected:nth-child(1) p, .row div.img-selected:nth-child(2) p {
    left:unset;
    right: -80%;

  }

  .link-edit-input{
    position: absolute;
    background: white;
    border: 1px solid #c1c1c1;
    padding: 0.5em;
    -webkit-box-shadow: 10px 10px 37px -13px rgba(0,0,0,0.56);
    -moz-box-shadow: 10px 10px 37px -13px rgba(0,0,0,0.56);
    box-shadow: 10px 10px 37px -13px rgba(0,0,0,0.56);
  }



  .edeting .edit-icon{
    background:red;
    animation: blink-animation 1s steps(5, start) infinite;
    -webkit-animation: blink-animation 1s steps(5, start) infinite;
  }
  .blink{
    color:red;
    animation: blink-animation 1s steps(5, start) infinite;
    -webkit-animation: blink-animation 1s steps(5, start) infinite;
  }

  @keyframes blink-animation {
    to {
      visibility: hidden;
    }
  }
  @-webkit-keyframes blink-animation {
    to {
      visibility: hidden;
    }
  }
</style>
</head>
<body>
  <div class="side">
    <nav>
      <ul>
        <li><a href="#home" onclick="getSection('home')">Home</a></li>
        <li><a href="#cv" onclick="getSection('cv')">CV</a></li>
        <li><a href="#gallery" onclick="getSection('gallery')">Gallery</a></li>
        <li><a href="#contact" onclick="getSection('contact')">Contact</a></li>
      </ul>
    </nav>
  </div><div class="content <?php if($edit){ echo "edit-mode";} ?>"><header>ROBVIS <?php if($edit){ echo "<span class='blink'>edit mode!</span>";} ?></header>

    <section id="home" >
      <div class="inner-section">
        <div class="section-helper"></div>
        <div class="content-wrapper" >


        </div>
      </div>
    </section>

    <section id="cv" class="hide">
      <div class="inner-section">
        <div class="section-helper"></div>
        <div class="content-wrapper" >


        </div>
      </div>
    </section>


    <section id="gallery" class="hide"  >
      <div class="inner-section">
        <div class="section-helper"></div>
        <div class="content-wrapper">

        </div>
      </div>
    </section>

    <section id="contact" class="hide"  >
      <div class="inner-section">
        <div class="section-helper"></div>
        <div class="content-wrapper">

        </div>
      </div>
    </section>

  </div>
</body>
<script>


(function() {

  if(location.hash){
    hs = location.hash;
    getSection(hs.replace('#', ''));
  }else{
    getSection('home')
  }


})();

function getSection(id){
  selct = document.querySelector(".link-edit-input")
  if(selct !== null){
    selct.remove();
  }
  activ = document.querySelector(".active");
  if(activ !== null){
    activ.removeAttribute('class');
  }
  var section = document.getElementById(id);
  if(!section.classList.contains("fetched")){
    fetch('files/'+id+'.json')
    //fetch(id+'.json')
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      section.classList.add("fetched");
      section.querySelector(".content-wrapper").innerHTML = data.html;
      section.classList.remove("hide");
      window.location.hash = "";
      window.location.hash = "#"+id;
      <?php if($edit){

        $js = "dragImg(id);editLink(id);var block = document.querySelectorAll('.text-block'), i;";

        $js .= "for (i = 0; i < block.length; ++i) { block[i].setAttribute('contenteditable', 'true');  block[i].setAttribute('oninput', 'saveHtml(this)') }";

        echo $js;

      }else{

        $js = "initLightbox(id);var block = document.querySelectorAll('.text-block'), i;";

        $js .= "for (i = 0; i < block.length; ++i) { block[i].removeAttribute('contenteditable');  block[i].removeAttribute('oninput') }";

        echo $js;

      } ?>

    });

  }
}

function saveFile(img){
  //  console.log(img);

  var url = 'write.php';
  var formData = new FormData();
  //  var dt = '<div class="hallo"></div>'
  formData.append('img', img.getAttribute("src"));

  fetch(url, { method: 'POST', body: formData })
  .then(function (response) {
    return response.text();
    console.log(response);
  })
  .then(function (body) {
    var block = img.closest("section").querySelector('.text-block');
    img.setAttribute("src", "files/"+body);
    img.classList.remove("base64");
    saveHtml(block);

    console.log(body);
  });

}




function saveHtml(block){

  //console.log(block.innerHTML+"id="+block.closest("section").id);
  //block.removeAttribute("oninput");
  //block.removeAttribute("contenteditable");

  var id = block.closest("section").id;
  var tml = block.closest(".content-wrapper").innerHTML;

  var url = 'write.php';
  var formData = new FormData();
  //  var dt = '<div class="hallo"></div>'
  formData.append('x', tml);
  formData.append('id', id);

  fetch(url, { method: 'POST', body: formData })
  .then(function (response) {
    return response.text();
  })
  .then(function (body) {
    console.log(body);
    //  block.setAttribute("oninput", "saveHtml(this)");
    //  block.setAttribute("contenteditable", "true");
  });

}

function saveLink(){
  var item = document.querySelector('.active');
  var text = this.closest(".link-edit-input").querySelector('input[name="text"]').value;
  var link = this.closest(".link-edit-input").querySelector('input[name="link"]').value;
  item.innerHTML = text;
  item.href = link;
  item.removeAttribute("class");
  selct = document.querySelector(".link-edit-input")
  if(selct !== null){
    selct.remove();
  }
  saveHtml(item.closest('.text-block'));
}



function editLink(id){

  var changeLink = function(e){
    activ = document.querySelector(".active");
    if(activ !== null){
      activ.removeAttribute('class');
    }
    this.classList.add('active');

    selct = document.querySelector(".link-edit-input")
    if(selct !== null){
      selct.remove();
    }
    x = e.clientX;
    var bodyRect = document.body.getBoundingClientRect(),
    elemRect = this.getBoundingClientRect(),
    y   = elemRect.top - bodyRect.top;
    //  y = rect.top;
    var input = document.createElement("div");
    var inp = this.innerHTML;
    var inl = this.href;
    input.classList.add("link-edit-input");
    input.setAttribute("style","top:"+y+"px;left:"+x+"px");
    input.innerHTML = "link: <input name='link' type='text' value='"+inl+"'>text: <input name='text' type='text' value='"+inp+"'><button data='' class='save-link'>Save</button>";
    document.body.appendChild(input);
    document.querySelector('.save-link').addEventListener('click', saveLink, false);

  }

  var link = document.getElementById(id).querySelectorAll('.text-block a'), i;

  for (i = 0; i < link.length; ++i) {
    link[i].addEventListener('click', changeLink, false);
  }

}



// function debounce(func, wait, immediate) {
//   console.log("hoi" );
// 	var timeout;
// 	return function() {
// 		var context = this, args = arguments;
// 		var later = function() {
// 			timeout = null;
// 			if (!immediate) func.apply(context, args);
// 		};
// 		var callNow = immediate && !timeout;
// 		clearTimeout(timeout);
// 		timeout = setTimeout(later, wait);
// 		if (callNow) func.apply(context, args);
// 	};
// };





function initLightbox(id){

  var img = document.getElementById(id).querySelectorAll('img'), i;

  var openLightbox = function(e) {
    if(!this.closest("div").classList.contains("img-selected")){
      for (i = 0; i < img.length; ++i) {
        if(!img[i].closest("div").classList.contains("full")){
          img[i].closest("div").removeAttribute("class");
        }
      }
      this.closest("div").classList.add("img-selected");
    }else{
      this.closest("div").removeAttribute("class");
    }
  }


  for (i = 0; i < img.length; ++i) {
    if(!img[i].closest("div").classList.contains("full")){
      img[i].addEventListener('click', openLightbox, false);
    }
  }

}


function dragImg(id){

  var handleDrag = function(e) {
    //kill any default behavior
    e.stopPropagation();
    e.preventDefault();
  };
  var handleDrop = function(e) {
    // dropZone.innerHTML = "";
    //kill any default behavior
    e.stopPropagation();
    e.preventDefault();
    //console.log(e);
    //get x and y coordinates of the dropped item
    x = e.clientX;
    y = e.clientY;
    //drops are treated as multiple files. Only dealing with single files right now, so assume its the first object you're interested in
    var file = e.dataTransfer.files[0];
    //don't try to mess with non-image files
    if (file.type.match('image.*')) {
      //then we have an image,

      //we have a file handle, need to read it with file reader!
      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        //get the data uri
        var dataURI = theFile.target.result;
        //make a new image element with the dataURI as the source
        var img = document.createElement("img");
        img.classList.add("base64");
        img.src = dataURI;

        //Insert the image at the carat

        // Try the standards-based way first. This works in FF
        if (document.caretPositionFromPoint) {
          var pos = document.caretPositionFromPoint(x, y);
          range = document.createRange();
          range.setStart(pos.offsetNode, pos.offset);
          range.collapse();
          if(range.startContainer.tagName !== 'P' && range.startContainer.getAttribute("class") !== 'row'){
            range.startContainer.innerHTML = "";

            pr = document.createElement('p');
            pr.classList.add('text-block');
            pr.setAttribute('onclick', 'saveHtml(this)');
            pr.setAttribute('contenteditable', 'true');
            pr.innerHTML = 'Wat text onder dit (900 x 400)';
            range.insertNode(pr);

            range.insertNode(img);

            saveFile(img);
          }

          // var block = range.startContainer.closest("section").querySelector(".text-block");

          //   saveHtml(block);
        }
        // Next, the WebKit way. This works in Chrome.
        else if (document.caretRangeFromPoint) {
          range = document.caretRangeFromPoint(x, y);
          if(range.startContainer.tagName !== 'P' && range.startContainer.getAttribute("class") !== 'row'){
            range.startContainer.innerHTML = "";

            pr = document.createElement('p');
            pr.classList.add('text-block');
            pr.setAttribute('onclick', 'saveHtml(this)');
            pr.setAttribute('contenteditable', 'true');
            pr.innerHTML = 'Wat text onder dit (900 x 400)';
            range.insertNode(pr);

            range.insertNode(img);
            //   var block = range.startContainer.closest("section").querySelector(".text-block");

            saveFile(img);


          }


        }
        else
        {
          //not supporting IE right now.
          console.log('could not find carat');
        }


      });
      //this reads in the file, and the onload event triggers, which adds the image to the div at the carat
      reader.readAsDataURL(file);
    }
    //   imgEditor(dropZone);


  };


  var imgblock = document.getElementById(id).querySelectorAll('.img-block'), i;

  for (i = 0; i < imgblock.length; ++i) {
    imgblock[i].addEventListener('dragover', handleDrag, false);
    imgblock[i].addEventListener('drop', handleDrop, false);
  }


  //   if(document.getElementById('d')){
  //     var dropZone = document.getElementById('d');
  //
  //   dropZone.addEventListener('dragover', handleDrag, false);
  //   dropZone.addEventListener('drop', handleDrop, false);
  // }
}



//http://jsfiddle.net/MWe8U/

//https://stackoverflow.com/questions/23548745/drag-and-drop-image-file-into-contenteditable-div-works-fine-in-ff-fails-miser
</script>
</html>
