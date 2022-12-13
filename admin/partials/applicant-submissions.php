<div class="wrap" style="background-color: white;padding: 5px">

	<?php
		if(isset($_GET['wda'])){
			FeedBack('applicant_submission',$_GET['wda'],'admin');
			RemoveCurrentUrlParam(['wda']);
		}
		if($id=$_GET['edit']??''){
			wd_request('post') &&
			WdRedirect(
				wd_admin_page_url(
					'applicant-submissions',
					[
						'wda'=>DBContact::ChangeApplicantData()?2:0
					]
				)				
			);
			$data = D_B()->get_row("select * from ".wd_table('applicant_submissions'). " where id=$id");
			require_once WE_DEVS_DIR.'public/partials/applicant-submissions.php';
		}else{
	?>
	<h2>Server Side</h2>
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
                <th data-dosort='0'>
                    Action
                </th>

            </tr>
        </thead>
    </table>


	<script type="text/javascript">

	window.onload = function(){
		(function(){    

		    var dtp = {
		        cols:[],
		        pn:1, //page no
		        scn:0,//sorted cell no
		        so:'asc',//sorted order
		        //searched field value
		        pp:10//per page
		        //total row
		    };
		    ///
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
		    function create_data_table(data){
		        try{            
		            var table = document.querySelector("#data_table");
		            var t_r = ''; 
		            for(var i=0;i<data.length;i++){
		                t_r += `
	                		<tr>
	                			${data_tds(data[i])}
	                			<td>
	                				<a href='<?php echo wd_admin_page_url('applicant-submissions');?>&edit=${data[i]['id']}' class='wd-adeb'>Edit</a>
	                				<button data-id='${data[i]['id']}' class='wd-addb'>Delete</button>
	                			</td>
	                		</tr>
		                `;
		            };
		            !t_r&&(t_r = "<tr><td colspan='10' style='text-align:center'>No Data Found</td></tr>");
		            var tattr = table.getAttributeNames().reduce(function(v, a){    
		              return v += ` ${a}="${table.getAttribute(a)}" `;
		            },'');

		            var [t,p] =[
		                    `<table ${tattr}> 
		                        ${table.querySelector('thead').outerHTML}
		                        <tbody>${t_r}</tbody>
		                    </table>`,
		                    pagination(dtp.tr,dtp.pn)
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
		    function data_tds(d){
		    	var td = '';
		        dtp.cols.forEach(function(c){
		            td += `<td>${d[c]}</td>`;
		        });
		        return td;
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
		    handle_data();
		    ///
		    var pause = false;
		    function handle_data() {
		        if(pause) return;
		        pause = true;
		        var form_data = new FormData();
		        var datas = {
		            args:JSON.stringify(dtp),
		            action: "wd_admin_ajax",
		            purpose:'gasd'
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
		        	dtp.cols=d.cols;
		        	dtp.tr=d.total_row;        	
		            create_data_table(d.data);
		            //cl(d);
		            pause = false;
		        })    
		        .catch(function(error){});
		    }
		    ///
		    document.querySelector('body').addEventListener('click',function(e){ 
		        if(e.target.closest('[data-type="pagination"]') && e.target.tagName=='LI'){
		            if(!e.target.classList.contains('active')){
		                dtp.pn=e.target.innerText;
		                dtp.scn=parseInt(document.querySelector('#data_table .theads [data-sort]').cellIndex);
		                handle_data();
		            }
		        }
		        if(
		        	e.target.closest('#data_table .theads') && 
		        	(e.target.tagName=='TH'|| (th=e.target.closest('th')))
		        ){
		            var th = th||e.target;
		        	if(th.getAttribute('data-dosort')!=1)return;
		            var st = ['asc','desc'];
		            var d = +(th.hasAttribute('data-sort') && th.getAttribute('data-sort')=='asc');
		            !th.hasAttribute('data-sort')&&doss();
		            th.setAttribute('data-sort',st[d]);

		            dtp.pn=parseInt(document.querySelector('[data-type="pagination"] .active').innerText);
		            dtp.scn=parseInt(document.querySelector('#data_table .theads [data-sort]').cellIndex);
		            dtp.so =st[d]; 

		            handle_data();
		        }else if(e.target.classList.contains('wd-addb')){
		        	if(id=e.target.getAttribute('data-id')){

		        		if(!confirm("Are You Sure?"))return;

			        	var form_data = new FormData();
				        var datas = {
				            action: "wd_admin_ajax",
				            purpose:'dasd',
				            d_id:id
				        }
				        Object.keys(datas).forEach(function(key){
				            form_data.append(key, datas[key] );
				        });
				        e.target.setAttribute('disable','disable');
				        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
				            method: "POST",
				            body: form_data
				        })
				        .then(function(r){return r.text();})
				        .then(function(d){
				        	e.target.removeAttribute('disable');
				        	if(d==1){
				        		WD_Alert('success','Data Deleted Successfully');
				        		dtp.sfv = compress(e.target.value);
				                dtp.pn=1; 
				                handle_data();
				        	}else{
				        		WD_Alert('error','Something Wrong! Please Try Again.');
				        	}				        	
				        })    
				        .catch(function(error){});
				    }
		        }
		    });
		    ///
		    document.querySelector('body').addEventListener('change',function(e){
		        if(e.target.hasAttribute('id') && e.target.getAttribute('id')=='wd-dt-pp'){
		            dtp.pp=e.target.value; 
		            dtp.pn=1;                       
		            handle_data();
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
		                handle_data();
		            },500);            
		        }
		    });
		}());
	}
	</script>
	<?php } ?>

</div>

