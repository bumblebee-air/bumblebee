@extends('templates.doorder') @section('title', 'View QR')

@section('styles')
<style>
#printDiv {
	/* 	width: 600px; */
	/*             height: 600px; */
	
}

.btnDoorder {
	border-radius: 6px;
	min-width: 180px;
	height: 40px;
	font-family: Quicksand;
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 21px;
	color: #FFFFFF;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	user-select: none;
	padding: 6px 14px;
}

.btn-doorder-primary {
	background: #E9C218;
	border: 1px solid #E9C218;
}
.btnDoorder:focus{
    outline: none;
}
</style>
@endsection @section('content')
<div class="" id="printDiv">

	<div class="row mx-auto justify-content-center">
		<div class="col-3  py-3">
			<img src="{{asset('images/doorder-logo2.png')}}" height="80px"
				width="250px">
		</div>
		<div class="col-3"></div>
	</div>
	<div class="row mx-auto justify-content-center">
		<div class="col-3" style="display: inline-block;">
			<div class="row">

				<div class="col-12  ">
					<div class="form-group  mx-auto">
						<label class="control-label  ">Name </label> <span
							class="control-label  " style="display: block; font-weight: 600">
							{{$name}} </span>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group ">
						<label class="control-label">Order number </label> <span
							class="control-label" style="display: block; font-weight: 600">
							{{$order_number}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3" style="display: inline;">
			<div class="col-12">
				<div class="delivery-qrcode-reader">
					<img :src="newQRCode" alt="QRCode" />
				</div>
			</div>
		</div>


	</div>
</div>
<div class="row justify-content-center mt-2">
	<div class="col-lg-3  col-md-3 col-sm-4 ">
		<button class="btnDoorder btn-doorder-primary" type="button"
			onclick="PrintElem()">Print</button>
	</div>
</div>
@endsection @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script
	src="https://juanpabllo.github.io/QRCode-generator/js/qrious.min.js"></script>

<script src="{{asset('js/print.min.js')}}"></script>
<script>
        var app = new Vue({
            el: '#printDiv',
            data: {
                qr_code: '',
                text: '{!! $qr_str !!}',
                  qrcode: new QRious({ size: 150 }),
                },
            computed: {
                  newQRCode() {
                    this.qrcode.value = this.text;
                    return this.qrcode.toDataURL();
                  },
        	},
            methods: {
               
            }
        });
        function PrintElem()
				{
				printJS({ printable: 'printDiv', 
            		type: 'html',
            		width:'600px',
            		height:'300px',
            		style: '#printDiv .col-md-12 { text-align: center;max-width:50px; max-height:30px;}',
            		css: '{{asset('css/material-dashboard.min.css')}}'
            		})
            		
// 					var mywindow = window.open('', 'PRINT', 'height=400,width=600');

// 					mywindow.document.write('<html><head><title>' + document.title  + '</title>');
// 					mywindow.document.write('</head><body >');
// 					mywindow.document.write(document.getElementById('printDiv').innerHTML);
// 					mywindow.document.write('</body></html>');

// 					mywindow.document.close(); // necessary for IE >= 10
// 					mywindow.focus(); // necessary for IE >= 10*/

// 					mywindow.print();
// 					mywindow.close();

// 					return true;
				}
    </script>
@endsection
