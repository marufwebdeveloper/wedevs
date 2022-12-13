<div class="wrap" style="background-color: white;padding: 5px">
	<h2>Client Side</h2>
	<table id="data_table" style="width:100%">
        <thead>
            <tr class="theads">
            	<th data-dosort='1' data-sort='asc'>
                    ID
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    First Name
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Last Name
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Email
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Mobile
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Post
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Address
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    CV
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
                <th data-dosort='1'>
                    Submitted Time
                    <div class="sorting-sign">
                        <p class="_arrow_ _up_"><i></i></p>
                        <p class="_arrow_ _down_"><i></i></p>
                    </div>
                </th>
            </tr>
        </thead>
    </table>


	<script type="text/javascript">
	window.onload = function(){
		(function(){
		    var dtd = [];    
		    var dtp = {
		        cols:[],
		        pn:1, //page no
		        scn:0,//sorted cell no
		        so:'asc',//sorted order
		        //searched field value
		        pp:10//per page
		    };

		    (function(){
		    	var form_data = new FormData();
		        var datas = {
		            action: "wd_admin_ajax",
		            purpose:'gaasd'
		        }
		        Object.keys(datas).forEach(function(key){
		            form_data.append(key, datas[key] );
		        });
		        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
		            method: "POST",
		            body: form_data
		        })
		        .then(function(r){return r.json();})
		        .then(function(d){
		        	dtd = d.data;
		        	dtp.cols = d.cols;
		        	create_data_table();
		        })    
		        .catch(function(error){});    	
		    }())
		    

		    function doss(){
		        //doss = disable others sorting sign
		        document.querySelectorAll(`#data_table .theads th`).forEach(function(th){
		            th.removeAttribute('data-sort');
		        });
		    }    
		    ///
		    function cl(d){
		        console.log(d);
		    }
		    ///
		    function data_table_data(){
		        var data = [];
		        try{
		            data = dtd;
		            var col = dtp.cols[dtp.scn];
		            var o = !dtp.so||dtp.so=='asc'?1:-1;
		            dtp.sfv&&(data = data.filter(function(r){
		                var b = false;
		                Object.values(r).forEach(function(v){
		                    if(compress(v).includes(dtp.sfv)){
		                        b = true;
		                        return;
		                    }                
		                });            
		                return b;
		            }));
		            data.sort(function(a,b){
		            	var [x,y] = [a[col].toLowerCase(),b[col].toLowerCase()];
		                return (x<y)?(-1)*o:(x>y?o:0);
		            });
		        }catch(e){}
		        return data;    
		    }
		    ///
		    function create_data_table(){
		        try{
		            var data = data_table_data();
		            var table = document.querySelector("#data_table");
		            var start = (dtp.pn-1)*dtp.pp;
		            var end = dtp.pp*dtp.pn; 
		            var tr = ''; 
		            for(var i=start;i<(end>data.length?data.length:end);i++){
		                tr +=create_row(data[i]);
		            };
		            var tattr = table.getAttributeNames().reduce(function(v, a){    
		              return v += ` ${a}="${table.getAttribute(a)}" `;
		            },'');

		            var [t,p] =[
		                    `<table ${tattr}> 
		                        ${table.querySelector('thead').outerHTML}
		                        <tbody>${tr}</tbody>
		                    </table>`,
		                    pagination(data.length,dtp.pn)
		            ];
		            if(tzn = table.closest("#wddtzn")){
		                tzn.querySelector("#wd-dt").innerHTML = t;
		                tzn.querySelector("#wd-tp").innerHTML = p;            
		            }else if(table){
		                table.outerHTML = `
		                    <div id='wddtzn'>
		                        <div id='wd-sa'>
		                            ${per_page_lists()}
		                            <input type='text' value='${dtp.sfv||''}' data-type='table-search' placeholder='Search' style='float:right'/>
		                        </div>
		                        <div id='wd-dt'>${t}</div>
		                        <div id='wd-tp'>${p}</div>
		                    </div>
		                `;
		            }
		        }catch(e){}
		    };
		    ///    
		    function create_row(d){
		        var tr = '<tr>';
		        dtp.cols.forEach(function(c){
				    tr += `<td>${d[c]}</td>`;
				});
		        tr += '</tr>';
		        return tr;
		    }
		    ///
		    function pagination(tr,pn){
		        var p = '<ul class="wddp" data-type="pagination">';
		        for(var i=1;i<=(Math.ceil(tr/dtp.pp));i++){
		            p +=`<li ${i==pn?"class='active'":''}>${i}</li>`;
		        }
		        p +='</ul>';
		        return p;
		    }
		    ///
		    function compress(s){
		        return s?s.replaceAll(/\s/g,'').toLowerCase():'';
		    }
		    ///
		    function per_page_lists(){
		        var l = [10,25,50,100,200,500];
		        var s = "<select id='wd-dt-pp'>";
		        l.forEach(function(v){
		            s += `<option value='${v}'>${v}</option>`;
		        });
		        s += "</select>";
		        return s;
		    }
		    ///
		    document.querySelector('body').addEventListener('click',function(e){ 
		        if(e.target.closest('[data-type="pagination"]') && e.target.tagName=='LI'){

		            if(!e.target.classList.contains('active')){
		                dtp.pn=e.target.innerText;
		                dtp.scn=parseInt(document.querySelector('#data_table .theads [data-sort]').cellIndex);
		                create_data_table();
		            }
		        }
		        if(e.target.closest('#data_table .theads') && (e.target.tagName=='TH'|| (th=e.target.closest('th')))){
		            var th = th||e.target;
		            var st = ['asc','desc'];
		            var d = +(th.hasAttribute('data-sort') && th.getAttribute('data-sort')=='asc');
		            !th.hasAttribute('data-sort')&&doss();
		            th.setAttribute('data-sort',st[d]);

		            dtp.pn=parseInt(document.querySelector('[data-type="pagination"] .active').innerText);
		            dtp.scn=parseInt(document.querySelector('#data_table .theads [data-sort]').cellIndex);
		            dtp.so =st[d]; 

		            cl(dtp);

		            create_data_table();
		        }
		    });
		    ///
		    document.querySelector('body').addEventListener('change',function(e){
		        if(e.target.hasAttribute('id') && e.target.getAttribute('id')=='wd-dt-pp'){
		            dtp.pp=e.target.value; 
		            dtp.pn=1;                       
		            create_data_table();
		        }
		    });
		    ///
		    var sn;
		    document.querySelector('body').addEventListener('keyup',function(e){        
		        if(e.target.hasAttribute('data-type') && e.target.getAttribute('data-type')=='table-search'){
		            clearTimeout(sn);
		            sn = setTimeout(function(){
		                dtp.sfv = compress(e.target.value);
		                dtp.pn=1; 
		                create_data_table();
		            },500);            
		        }
		    });
		}());
	}
	//https://docs.google.com/document/d/1j_NNNz-1UrkLXTbtqccOlf3QQaixkQrKrhov60S3m0U/edit#heading=h.cbqj99du88i3
	</script>

</div>

