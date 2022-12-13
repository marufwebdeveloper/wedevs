document.addEventListener("DOMContentLoaded", function(event) {
    document.querySelector("body").addEventListener('click',function(e){
        if(m = e.target.closest("#wd-modal"))m.remove();
    });
})

function WD_Alert(t,m){
    if(a=document.querySelector('#wd-modal'))a.remove();
    document.querySelector('body').insertAdjacentHTML("beforeend",`
        <div id="wd-modal" class='alert-${t}'>
            <p class="wd-modal-title">${m}</p>
            <p class="wd-modal-close">x</p>
        </div>
    `);
}

function wd_remove_url_param(k, u) {
    var rtn = u.split("?")[0],
        param,
        params_arr = [],
        queryString = (u.indexOf("?") !== -1) ? u.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (k.includes(param)) {
                params_arr.splice(i, 1);
            }
        }
        if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}
