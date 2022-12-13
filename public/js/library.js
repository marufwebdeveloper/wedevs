window.onload = function(){
    document.querySelector("body").addEventListener('click',function(e){
        if(m = e.target.closest("#wd-modal"))m.remove();
    });
}

function WD_Alert(t,m){
    if(a=document.querySelector('#wd-modal'))a.remove();
    document.querySelector('body').insertAdjacentHTML("beforeend",`
        <div id="wd-modal" class='alert-${t}'>
            <p class="wd-modal-title">${m}</p>
            <p class="wd-modal-close">x</p>
        </div>
    `);
}