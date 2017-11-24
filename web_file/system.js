$(document).ready(function(){
    document.getElementById("overlay").style.display = "block";
});
/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
$("#btn-nav").click(function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
});
/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
$(".closebtn").click(function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
});
$("#overlay").click(function off() {
    document.getElementById("overlay").style.display = "none";
});

