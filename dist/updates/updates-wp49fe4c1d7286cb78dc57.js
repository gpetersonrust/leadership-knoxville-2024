(()=>{"use strict";let e=[...document.querySelectorAll(".update-filter-button")],t=e[0];for(const d of e)d.addEventListener("click",(function(){let e=d.dataset.filter,n=updates[e];t.classList.remove("active"),t=d,d.classList.add("active"),a(n,"update-grid")}));function a(e,t){var a=document.getElementById(t);a.innerHTML="",e.forEach((function(e){var t=document.createElement("a");t.href=e.permalink,t.className="update-card";var d=document.createElement("div");d.className="update-card__thumbnail";var n=document.createElement("img");n.src=e.thumbnail_url,n.alt=e.title,d.appendChild(n);var c=document.createElement("h4");c.className="update-card__title",c.textContent=e.title;var l=document.createElement("h5");l.className="update-card__date",l.textContent=e.date,t.appendChild(d),t.appendChild(c),t.appendChild(l),a.appendChild(t)}))}})();
//# sourceMappingURL=updates-wp49fe4c1d7286cb78dc57.js.map