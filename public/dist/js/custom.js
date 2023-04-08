function preview_image(event,id) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById(id);
  output.src = reader.result;
 }
reader.readAsDataURL(event.target.files[0]);
}