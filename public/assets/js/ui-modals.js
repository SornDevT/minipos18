!function(){let t=document.querySelector("#youTubeModal"),e=t.querySelector("iframe");t.addEventListener("hidden.bs.modal",function(){e.setAttribute("src","")});[].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]')).map(function(t){t.onclick=function(){var t=this.getAttribute("data-bs-target"),e=this.getAttribute("data-theVideo")+"?autoplay=1",t=document.querySelector(t+" iframe");t&&t.setAttribute("src",e)}})}();